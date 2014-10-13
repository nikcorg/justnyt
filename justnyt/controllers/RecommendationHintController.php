<?php
namespace justnyt\controllers;

class RecommendationHintController extends \glue\Controller
{
    protected function getCurator($token, $throw = true) {
        $curator = \justnyt\models\CuratorQuery::create()->getActiveCuratorByToken($token);

        if ($throw && is_null($curator)) {
            throw new \glue\exceptions\http\E403Exception();
        }

        return $curator;
    }

    public function drop($token, $id) {
        $curator = $this->getCurator($token);

        $hint = \justnyt\models\RecommendationHintQuery::create()
            ->findOneByRecommendationHintId($id);

        if (! $hint) {
            throw new \glue\exceptions\http\E404Exception();
        }

        try {
            $hint->setDroppedOn($_SERVER["REQUEST_TIME"]);
            $hint->setCurator($curator); // Method name is misleading, but setDroppedBy expects an int
            $hint->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \glue\exceptions\http\E500Exception("Error updating hint", null, $e);
        }
    }
}
