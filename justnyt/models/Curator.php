<?php

namespace justnyt\models;

use justnyt\models\Base\Curator as BaseCurator;

class Curator extends BaseCurator
{
    public function getApprovedRecommendations() {
        return \justnyt\models\RecommendationQuery::create("rc")
            ->filterByCurator($this)
            ->where("rc.ApprovedOn < NOW()")
            ->orderByApprovedOn("DESC")
            ->find();
    }

    public function activate() {
        $this->setActivatedOn(time());

        return $this->save();
    }

    public function deactivate() {
        $this->setDeactivatedOn(time());

        return $this->save();
    }

    public function generateToken($tokenlen = 5) {
        $candidates = 5;
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
        if (count($tokens) === 0) {
            return $this->generateToken($tokenlen + 1);
        }

        $this->setToken(array_pop($tokens));
    }
}
