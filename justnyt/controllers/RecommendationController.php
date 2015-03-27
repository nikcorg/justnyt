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

    public function create($token) {
        $curator = $this->getCurator($token);
        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "recommendation/create",
                array(
                    "title" => "Uusi suositus",
                    "curator" => $curator
                    )
                )
        );
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
        $curl->setHeader("User-Agent", "JustNyt/0.1; for more info see https://justnyt.fi");

        if (! $curl->get() || $curl->getResponseCode() !== 200) {
            throw new \glue\exceptions\http\E500Exception("Error scraping " . $pending->getUrl());
        }

        $dom = \Sunra\PhpSimple\HtmlDomParser::str_get_html($curl->getResponseBody());

        $titleStr = "Untitled";
        $descStr = "";

        $title = $dom->find("title", 0);
        $desc = $dom->find("meta[name=description]", 0);
        $ogSiteName = $dom->find("meta[property=og:site_name]", 0);
        $ogTitle = $dom->find("meta[property=og:title]", 0);
        $ogDesc = $dom->find("meta[property=og:description", 0);

        if (null != $title) {
            $titleStr = html_entity_decode(trim($title->plaintext));
        }

        if (null != $ogTitle) {
            $titleStr = html_entity_decode(trim($ogTitle->content));
        }

        if (null != $ogSiteName) {
            $titleStr .= " - " . html_entity_decode(trim($ogSiteName->content));
        }

        if (null != $desc) {
            $descStr = strip_tags(html_entity_decode(trim($desc->content)));
        }

        if (null != $ogDesc) {
            $descStr = strip_tags(html_entity_decode(trim($ogDesc->content)));
        }

        try {
            $pending->setScrapedOn(time());
            $pending->setTitle($titleStr);
            $pending->setQuote($descStr);
            $pending->save();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error updating recommendation", 0, $e);
        }

        $this->response->setJSONContent($pending->toJSON());
    }

    public function prepare($token) {
        $curator = $this->getCurator($token);
        $url = $this->request->GET->url;
        $quote = $this->request->GET->quote;
        $hintId = $this->request->GET->fromHint;
        $hint = null;

        if (empty($url) && empty($hintId)) {
            throw new \glue\exceptions\http\E400Exception("Empty URL");
        }

        if ($quote == "null") {
            $quote = "";
        } else {
            $quote = strip_tags(trim($quote));
        }

        if (! empty($hintId)) {
            $hint = \justnyt\models\RecommendationHintQuery::create()
                ->findOneByRecommendationHintId($hintId);

            if (null == $hint) {
                throw new \glue\exceptions\http\E400Exception("Invalid hintId");
            }

            $url = $hint->getUrl();
        }

        $mostRecent = \justnyt\models\RecommendationQuery::create("r")
            ->latestApproved()
            ->findOne();
        $upcoming = \justnyt\models\RecommendationQuery::create("r")
            ->upcomingApproved()
            ->find();
        $dupCheck = \justnyt\models\RecommendationQuery::create("r")
            ->where("r.ApprovedOn IS NOT NULL")
            ->where("r.Url = ?", $url)
            ->findOne();
        $prepare = new \justnyt\models\Recommendation();

        if (is_null($dupCheck)) {
            try {
                $prepare->setCurator($curator);
                $prepare->setCreatedOn(time());
                $prepare->setUrl($url);

                if (null != $hint) {
                    $prepare->setRecommendationHint($hint);
                }

                $prepare->save();
            } catch (\Exception $e) {
                throw new \glue\exceptions\http\E500Exception("Error saving recommendation candidate", 0, $e);
            }
        }

        $config = \glue\utils\Config::getDomain("recommendations");
        $delays = $config->getValue("delays");

        if (null != $mostRecent) {
            $earliestPubTime = $mostRecent->getApprovedOn()->add($config->getValue("minOnline"));
            $delays = array_filter(
                $config->getValue("delays"),
                function ($delay) use ($earliestPubTime) {
                    return (
                        $earliestPubTime <
                        \DateTime::createFromFormat("U", $_SERVER["REQUEST_TIME"])->add($delay)
                    );
                }
            );
        }

        // Add scrape job to queue, include job ID in response
        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "recommendation/prepare",
                array(
                    "title" => "Tarkista suosituksen tiedot",
                    "delays" => $delays,
                    "curator" => $curator,
                    "dupCheck" => $dupCheck,
                    "candidateId" => $prepare->getRecommendationId(),
                    "url" => $url,
                    "quote" => $quote,
                    "upcoming" => $upcoming,
                    "currentTime" => new \DateTime(),
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

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "recommendation/remove",
                array(
                    "title" => "Suositus poistettiin",
                    "curator" => $curator,
                    "token" => $curator->getToken()
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
            $pending->setTitle(strip_tags(trim($this->request->POST->title)));
            $pending->setUrl(strip_tags(trim($this->request->POST->url)));
            $pending->setQuote(strip_tags(trim($this->request->POST->quote)));
            // TODO: check that this is indeed within configured boundaries
            $pending->setApprovedOn(time() + max(0, min(intval($this->request->POST->delay), 43200)));
            $pending->save();
        } catch (\Exception $e) {
            throw new \glue\exceptions\http\E500Exception("Error saving recommendation candidate", 0, $e);
        }

        if (preg_match("/application\/json/", $this->request->getHeader("Accept"))) {
            return $this->response->setJSONContent($pending->toJSON());
        }

        $this->response->setContent(
            \justnyt\views\JustNytLayout::quickRender(
                "recommendation/approve",
                array(
                    "title" => "Suosituksesi on lisätty",
                    "curator" => $curator,
                    "recommendation" => $pending
                    )
                )
        );
    }
}
