<?php
namespace justnyt\controllers;

class RecommendationController extends \glue\Controller
{
    protected function getCurator($token) {
        $curator = \justnyt\models\CuratorQuery::create()->getActiveCuratorByToken($token);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E403Exception();
        }

        return $curator;
    }

    public function scrape($token, $id) {
        $curator = $this->getCurator($token);
        $pending = \justnyt\models\RecommendationQuery::create()->findOneByRecommendationId($id);

        if (is_null($pending)) {
            throw new \glue\exceptions\http\E400Exception("Invalid ID");
        } elseif (! is_null($pending->getScrapedOn())) {
            return $this->response->setJSONContent($pending->toJSON());
        }

        $curl = \glue\utils\Curl::factory($pending->getUrl());

        if (! $curl->get() || $curl->getResponseCode() !== 200) {
            throw new \glue\exceptions\http\E500Exception("Error scraping " . $pending->getUrl());
        }

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($curl->getResponseBody());
        $title = html_entity_decode(trim($dom->find("title", 0)->plaintext));

        if (empty($title)) {
            $title = "Untitled";
        }

        try {
            $pending->setScrapedOn(time());
            $pending->setTitle($title);
            $pending->save();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error updating recommendation", 0, $e);
        }

        $this->response->setJSONContent($pending->toJSON());
    }

    public function prepare($token) {
        $curator = $this->getCurator($token);
        $url = $this->request->GET->url;
        $upcoming = \justnyt\models\RecommendationQuery::create("r")
            ->upcomingApproved()
            ->find();

        if (empty($url)) {
            throw new \glue\exceptions\http\E400Exception("Empty URL");
        }

        try {
            $prepare = new \justnyt\models\Recommendation();
            $prepare->setCurator($curator);
            $prepare->setCreatedOn(time());
            $prepare->setUrl($this->request->GET->url);
            $prepare->save();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error saving recommendation candidate", 0, $e);
        }

        // Add scrape job to queue, include job ID in response
        $this->response->setContent(\glue\ui\View::quickRender(
            "layout",
            array(
                "title" => "Uusi suositus",
                "content" => \glue\ui\View::quickRender(
                    "recommendation/prepare",
                    array(
                        "token" => $token,
                        "candidateId" => $prepare->getRecommendationId(),
                        "title" => "",
                        "url" => $url,
                        "upcoming" => $upcoming,
                        "currentTime" => new \DateTime()
                        )
                    ),
                "scripts" => array("/assets/js/app.js")
                )
            )
        );
    }

    public function remove($curator, $pending) {
        try {
            $pending->delete();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error removing recommendation", 0, $e);
        }

        $this->response->setContent(\glue\ui\View::quickRender(
            "layout",
            array(
                "content" => \glue\ui\View::quickRender(
                    "recommendation/remove",
                    array(
                        "title" => $pending->getTitle(),
                        "url" => $pending->getUrl(),
                        "token" => $curator->getToken()
                        )
                    )
                )
            )
        );
    }

    public function approve($token, $id) {
        $curator = $this->getCurator($token);
        $pending = \justnyt\models\RecommendationQuery::create()->findOneByRecommendationId($id);

        if (is_null($pending)) {
            throw new \glue\exceptions\http\E404Exception("Invalid ID");
        }

        if ($this->request->POST->action === "remove") {
            return $this->remove($curator, $pending);
        }

        try {
            $pending->setTitle($this->request->POST->title);
            $pending->setUrl($this->request->POST->url);
            $pending->setApprovedOn(time() + max(0, min(intval($this->request->POST->delay), 43200)));
            $pending->save();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error saving recommendation candidate", 0, $e);
        }

        if (preg_match("/application\/json/", $this->request->getHeader("Accept"))) {
            return $this->response->setJSONContent($pending->toJSON());
        }

        $this->response->setContent(\glue\ui\View::quickRender(
            "layout",
            array(
                "content" => \glue\ui\View::quickRender(
                    "recommendation/approve",
                    array(
                        "title" => $pending->getTitle(),
                        "url" => $pending->getUrl(),
                        "token" => $token
                        )
                    )
                )
            )
        );
    }
}
