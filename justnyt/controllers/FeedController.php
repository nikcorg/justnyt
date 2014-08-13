<?php
namespace justnyt\controllers;

class FeedController extends \glue\Controller
{
    public function index() {
        $this->rss();
    }

    public function rss() {
        $recommendations = \justnyt\models\RecommendationQuery::create("r")
            ->latestApproved()
            ->find();

        $this->response->setHeader("Content-Type", "application/rss+xml; charset=utf-8");
        $this->response->setContent(\glue\ui\View::quickRender(
            "feed/rss", array(
                "host" => $_SERVER["HTTP_HOST"],
                "items" => $recommendations
                )
            )
        );
    }
}
