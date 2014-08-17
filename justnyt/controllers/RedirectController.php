<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    protected function createVisit() {
        $visitorId = $this->request->COOKIES->vid;

        if (null == $visitorId) {
            $visitorId = substr(uniqid(rand() . ".", true), 0, 32);
        }

        // Update the cookie lifetime
        setcookie("vid", $visitorId, time() + 2592000 /* 30 days */, "/", $_SERVER["HTTP_HOST"], false, true);

        $visit = new \justnyt\models\Visit();
        $visit->setVisitorId($visitorId)->setRecordedOn($_SERVER["REQUEST_TIME"]);

        return $visit;
    }

    protected function redirectTo($recommendation) {
        $recommendation->addVisit($this->createVisit())->save();

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
