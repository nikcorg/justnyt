<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    protected function getVisitorId() {
        $visitorId = $this->request->COOKIES->vid;

        if (null == $visitorId) {
            $visitorId = substr(uniqid(rand() . ".", true), 0, 32);
        }

        // Update the cookie lifetime
        setcookie("vid", $visitorId, time() + 2592000 /* 30 days */, "/", $_SERVER["HTTP_HOST"], false, true);

        return $visitorId;
    }

    protected function createVisit($visitorId) {
        $visit = new \justnyt\models\Visit();
        $visit->setVisitorId($visitorId)->setRecordedOn($_SERVER["REQUEST_TIME"]);

        return $visit;
    }

    protected function stripUtmParams($url) {
        if (strpos($url, "?") === false) {
            return $url;
        }

        list($uri, $query) = explode("?", $url);
        $rDrop = "/^(utm_source|utm_medium|utm_term|utm_content|utm_campaign)/";
        $params = array_filter(explode("&", $query), function ($value) use ($rDrop) {
            return ! preg_match($rDrop, $value);
        });
        $query = implode("&", $params);

        return $uri . "?" . $query;
    }

    protected function redirectTo($recommendation) {
        $visitorId = $this->getVisitorId();

        if (null == $this->request->GET->notrack) {
            $recommendation->addVisit($this->createVisit($visitorId))->save();
        }

        $url = $recommendation->getUrl();
        $url .= (strpos($this->stripUtmParams($url), "?") === false ? "?" : "&") . "utm_source=justnyt.fi";

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
            ->_if(null == $this->request->GET->unpubfilter || "off" != $this->request->GET->unpubfilter)
                ->approved()
            ->_endif()
            ->filterByShortlink($hash)
            ->findOne();

        if (is_null($recommendation)) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($recommendation);
    }
}
