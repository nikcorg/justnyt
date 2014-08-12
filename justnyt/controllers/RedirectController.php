<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    protected function redirectTo($url) {
        $url .= (strpos($url, "?") === false ? "?" : "&") . "utm_source=justnytfi";

        throw new \glue\exceptions\http\E303Exception($url);
    }

    public function redirect() {
        $newestRecommendation = \justnyt\models\RecommendationQuery::create("r")
            ->orderByCreatedOn(\Propel\Runtime\ActiveQuery\Criteria::DESC)
            ->where("r.ApprovedOn IS NOT NULL")
            ->findOne();

        if (! $newestRecommendation) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($newestRecommendation->getUrl());
    }

    public function hashLookup($hash) {
        $recommendation = \justnyt\models\RecommendationQuery::create("r")
            ->filterByShortlink($hash)
            ->where("r.ApprovedOn IS NOT NULL")
            ->findOne();

        if (is_null($recommendation)) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($recommendation->getUrl());
    }
}
