<?php

namespace justnyt\models;

use justnyt\models\Base\RecommendationHint as BaseRecommendationHint;


/**
 * Skeleton subclass for representing a row from the 'recommendation_hint' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class RecommendationHint extends BaseRecommendationHint
{
    public function preInsert(\Propel\Runtime\Connection\ConnectionInterface $con = null) {
        $this->setCreatedOn(time());
        return true;
    }
}
