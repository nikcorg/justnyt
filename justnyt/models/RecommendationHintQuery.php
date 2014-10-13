<?php

namespace justnyt\models;

use justnyt\models\Base\RecommendationHintQuery as BaseRecommendationHintQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'recommendation_hint' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class RecommendationHintQuery extends BaseRecommendationHintQuery
{
    public function unreviewed() {
        $modelAlias = $this->getModelAlias();

        return $this->where($modelAlias . ".DroppedOn IS NULL")
            ->useRecommendationQuery("r")
                ->endUse()
            ->groupByRecommendationHintId()
            ->having("COUNT(r.RecommendationId) = 0");
    }
} // RecommendationHintQuery
