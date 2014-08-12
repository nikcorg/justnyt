<?php

namespace justnyt\models;

use justnyt\models\Base\Recommendation as BaseRecommendation;

class Recommendation extends BaseRecommendation
{
    public function generateShortLink($tokenlen = 3) {
        $candidates = 5;
        $hash = sha1($this->getUrl() . microtime(true) . rand());
        $matches = array();

        preg_match_all("/([a-z].{" . ($tokenlen - 1) . "})/", $hash, $matches, PREG_PATTERN_ORDER);

        $unusables = \justnyt\models\RecommendationQuery::create("rd")
            ->select("Shortlink")
            ->where("rd.Shortlink IN ('" . implode("','", $matches[0]) . "')")
            ->find()
            ->toArray();

        $tokens = array_diff($matches[0], $unusables);

        // If all collide, increase token length
        // TODO: add alert for this event
        if (count($tokens) === 0) {
            return $this->generateShortLink($tokenlen + 1);
        }

        $this->setShortlink(array_shift($tokens));
    }

    public function save(\Propel\Runtime\Connection\ConnectionInterface $con = null) {
        if (is_null($this->getShortlink())) {
            $this->generateShortLink();
        }

        return parent::save($con);
    }
}
