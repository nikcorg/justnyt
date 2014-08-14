<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    protected function redirectTo($recommendation) {
        $recommendation->addVisit();

        $url = $recommendation->getUrl();
        $url .= (strpos($url, "?") === false ? "?" : "&") . "utm_source=justnyt.fi";

        throw new \glue\exceptions\http\E303Exception($url);
    }

    public function redirect() {
        $newestRecommendation = \justnyt\models\RecommendationQuery::create("r")
            ->latestApproved()
            ->findOne();

        if (! $newestRecommendation) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($newestRecommendation);
    }

    public function hashLookup($hash) {
        $recommendation = \justnyt\models\RecommendationQuery::create("r")
            ->approved()
            ->filterByShortlink($hash)
            ->findOne();

        if (is_null($recommendation)) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($recommendation);
    }
}
