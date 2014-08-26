<?php

namespace justnyt\models;

use justnyt\models\Base\Curator as BaseCurator;

class Curator extends BaseCurator
{
    public function getApprovedRecommendations() {
        $curatorId = $this->getCuratorId();
        $query = <<<EOQUERY
SELECT
    r.RECOMMENDATION_ID, r.CURATOR_ID, r.CREATED_ON, r.SCRAPED_ON, r.APPROVED_ON, r.GRAPHIC_CONTENT, r.SHORTLINK, r.URL, r.TITLE,
    COALESCE(SUM(visitorclicks), 0) AS CLICKS, COUNT(visitorclicks) AS VISITORS
FROM
    recommendation r
LEFT JOIN (
    SELECT
        v.recommendation_id, COUNT(1) AS `visitorclicks`
    FROM
        visit v
    GROUP BY
        v.recommendation_id,
        v.`visitor_id`
) v ON v.recommendation_id = r.recommendation_id
WHERE
    r.curator_id = :curator_id
AND
    r.approved_on < NOW()
GROUP BY
    r.recommendation_id
ORDER BY
    r.approved_on DESC
EOQUERY;
        $con = \Propel\Runtime\Propel::getConnection();
        $stmt = $con->prepare($query);
        $stmt->bindParam(":curator_id", $curatorId);
        $res = $stmt->execute();

        return $stmt;
        // return \justnyt\models\RecommendationQuery::create()
        //     ->joinWith("Recommendation.Visit")
        //     ->useVisitQuery(null, "INNER JOIN")
        //         ->withColumn("COUNT(1)", "VisitorClicks")
        //         ->endUse()
        //     ->filterByCurator($this)
        //     ->where("Recommendation.ApprovedOn < NOW()")
        //     ->groupBy("Visit.VisitorId")
        //     ->orderByApprovedOn("DESC")
        //     ->find();
    }

    public function activate() {
        $this->setActivatedOn(time());

        return $this->save();
    }

    public function deactivate() {
        $this->setDeactivatedOn(time());

        return $this->save();
    }

    public function preInsert(\Propel\Runtime\Connection\ConnectionInterface $con = null) {
        $this->setCreatedOn(time());
        $this->generateToken();
        return true;
    }

    public function generateToken($tokenlen = 5) {
        $candidates = 10;
        $tokens = array();

        for ($i = 0; $i < $candidates; $i++) {
            $hash = sha1(time() . rand());
            array_push($tokens, substr($hash, rand(0, strlen($hash) - $tokenlen - 1), $tokenlen));
        }

        $unusables = \justnyt\models\CuratorQuery::create("cr")
            ->select("Token")
            ->where("cr.Token IN ('" . implode("','", $tokens) . "')")
            ->find()
            ->toArray();

        $tokens = array_diff($tokens, $unusables);

        // If all collide, increase token length
        // TODO: add alert for this event
        if (count($tokens) < 2) {
            return $this->generateToken($tokenlen + 1);
        }

        $this->setToken(array_pop($tokens));
        $this->setInviteToken(array_pop($tokens));

        return true;
    }
}
