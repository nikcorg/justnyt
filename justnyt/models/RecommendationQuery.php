<?php

namespace justnyt\models;

use justnyt\models\Base\RecommendationQuery as BaseRecommendationQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'recommendation' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class RecommendationQuery extends BaseRecommendationQuery
{
    public function upcomingApproved() {
        $modelAlias = $this->getModelAlias();

        return $this->where($modelAlias . ".ApprovedOn IS NOT NULL")
            ->where($modelAlias . ".ApprovedOn > ?", new \DateTime())
            ->orderByApprovedOn("ASC");
    }

    public function approved() {
        $modelAlias = $this->getModelAlias();

        return $this->where($modelAlias . ".ApprovedOn IS NOT NULL")
            ->joinRecommendationHint(null, \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
            ->with("RecommendationHint")
            ->where($modelAlias . ".ApprovedOn <= ?", new \DateTime());
    }

    public function latestApproved() {
        $modelAlias = $this->getModelAlias();

        return $this->approved()
            ->orderByApprovedOn("DESC");
    }

} // RecommendationQuery
