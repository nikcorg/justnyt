<?php
namespace justnyt\controllers;

class RecommendationController extends \glue\Controller
{
    public function create($token) {
        $curator = \justnyt\models\CuratorQuery::create()->getActiveCuratorByToken($token);

        if (is_null($curator)) {
            throw new \glue\exceptions\http\E403Exception();
        }

        $url = $this->request->GET->url ?: "no url given";
        $this->response->setContentType("text/plain; charset=utf-8");
        $this->response->setContent("Add url: " . ($url ?: "none"));
    }
}
