<?php
namespace justnyt\controllers;

class RedirectController extends \glue\Controller
{
    protected function redirectTo($url) {
        throw new \glue\exceptions\http\E303Exception($url);
    }

    public function redirect() {
        $newestRecommendation = \justnyt\models\RecommendationQuery::create()
            ->orderByCreated(\Propel\Runtime\ActiveQuery\Criteria::DESC)
            ->findOne();

        if (! $newestRecommendation) {
            throw new \glue\exceptions\http\E404Exception();
        }

        $this->redirectTo($newestRecommendation->getUrl());
    }
}
