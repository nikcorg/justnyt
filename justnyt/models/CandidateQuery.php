<?php

namespace justnyt\models;

use justnyt\models\Base\CandidateQuery as BaseCandidateQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'candidate' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class CandidateQuery extends BaseCandidateQuery
{
    public function nextFree() {
        $modelAlias = $this->getModelAlias();

        return $this->where($modelAlias . ".InvitedOn IS NULL")
            ->where($modelAlias . ".InviteRedactedOn IS NULL")
            ->orderByCreatedOn("ASC");
    }

    public function invitePending() {
        $modelAlias = $this->getModelAlias();

        return $this->where($modelAlias . ".InvitedOn IS NOT NULL")
            ->where($modelAlias . ".InviteRedactedOn IS NULL")
            ->orderByCreatedOn("ASC");
    }
} // CandidateQuery
