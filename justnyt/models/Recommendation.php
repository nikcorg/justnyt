<?php

namespace justnyt\models;

use justnyt\models\Base\Recommendation as BaseRecommendation;

class Recommendation extends BaseRecommendation
{
    public function generateShortLink($tokenlen = 3) {
        $candidates = 5;
        $tokens = array_filter(str_split(sha1($this->url), $tokenlen), function ($val) use ($tokenlen) {
            return strlen($val) == $tokenlen;
        });
        $unusables = \justnyt\models\RecommendationQuery::create("rd")
            ->select("Shortlink")
            ->where("rd.Shortlink IN ('" . implode("','", $tokens) . "')")
            ->find()
            ->toArray();

        $tokens = array_diff($tokens, $unusables);

        // If all collide, increase token length
        // TODO: add alert for this event
        if (count($tokens) === 0) {
            return $this->generateShortLink($tokenlen + 1);
        }

        $this->setShortlink(array_shift($tokens));
    }
}
