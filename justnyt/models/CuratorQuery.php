<?php

namespace justnyt\models;

use justnyt\models\Base\CuratorQuery as BaseCuratorQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'curator' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class CuratorQuery extends BaseCuratorQuery
{
    public function getActiveCuratorByToken($token, \Propel\Runtime\Connection\ConnectionInterface $con = null) {
        if ($con === null) {
            $con = \Propel\Runtime\Propel::getServiceContainer()
                ->getReadConnection(\justnyt\models\Map\CuratorTableMap::DATABASE_NAME);
        }

        $sql = <<<EOQ
SELECT `curator_id`, `candidate_id`, `profile_id`, `token`, `created_on`, `activated_on`, `deactivated_on`
FROM `curator`
INNER JOIN (
    SELECT MAX(`activated_on`) AS `most_recent_activation` FROM `curator`
) `check`
WHERE `token`=:p0 AND `activated_on` = `check`.`most_recent_activation`
GROUP BY `curator_id`
LIMIT 100
EOQ;

        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $token, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            \Propel\Runtime\Propel::log($e->getMessage(), \Propel::LOG_ERR);
            throw new \Propel\Runtime\Exception\PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }

        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new \justnyt\models\Curator();
            $obj->hydrate($row);
        }
        $stmt->closeCursor();

        return $obj;
    }
} // CuratorQuery
