<?php

namespace justnyt\models\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use justnyt\models\Profile as ChildProfile;
use justnyt\models\ProfileQuery as ChildProfileQuery;
use justnyt\models\Map\ProfileTableMap;

/**
 * Base class that represents a query for the 'profile' table.
 *
 *
 *
 * @method     ChildProfileQuery orderByProfileId($order = Criteria::ASC) Order by the profile_id column
 * @method     ChildProfileQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method     ChildProfileQuery orderByHomepage($order = Criteria::ASC) Order by the homepage column
 * @method     ChildProfileQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildProfileQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildProfileQuery groupByProfileId() Group by the profile_id column
 * @method     ChildProfileQuery groupByAlias() Group by the alias column
 * @method     ChildProfileQuery groupByHomepage() Group by the homepage column
 * @method     ChildProfileQuery groupByImage() Group by the image column
 * @method     ChildProfileQuery groupByDescription() Group by the description column
 *
 * @method     ChildProfileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProfileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProfileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProfileQuery leftJoinCurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Curator relation
 * @method     ChildProfileQuery rightJoinCurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Curator relation
 * @method     ChildProfileQuery innerJoinCurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Curator relation
 *
 * @method     \justnyt\models\CuratorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProfile findOne(ConnectionInterface $con = null) Return the first ChildProfile matching the query
 * @method     ChildProfile findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProfile matching the query, or a new ChildProfile object populated from the query conditions when no match is found
 *
 * @method     ChildProfile findOneByProfileId(int $profile_id) Return the first ChildProfile filtered by the profile_id column
 * @method     ChildProfile findOneByAlias(string $alias) Return the first ChildProfile filtered by the alias column
 * @method     ChildProfile findOneByHomepage(string $homepage) Return the first ChildProfile filtered by the homepage column
 * @method     ChildProfile findOneByImage(string $image) Return the first ChildProfile filtered by the image column
 * @method     ChildProfile findOneByDescription(string $description) Return the first ChildProfile filtered by the description column
 *
 * @method     ChildProfile[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProfile objects based on current ModelCriteria
 * @method     ChildProfile[]|ObjectCollection findByProfileId(int $profile_id) Return ChildProfile objects filtered by the profile_id column
 * @method     ChildProfile[]|ObjectCollection findByAlias(string $alias) Return ChildProfile objects filtered by the alias column
 * @method     ChildProfile[]|ObjectCollection findByHomepage(string $homepage) Return ChildProfile objects filtered by the homepage column
 * @method     ChildProfile[]|ObjectCollection findByImage(string $image) Return ChildProfile objects filtered by the image column
 * @method     ChildProfile[]|ObjectCollection findByDescription(string $description) Return ChildProfile objects filtered by the description column
 * @method     ChildProfile[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProfileQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\ProfileQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\Profile', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProfileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProfileQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProfileQuery) {
            return $criteria;
        }
        $query = new ChildProfileQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProfile|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProfileTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProfileTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildProfile A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT PROFILE_ID, ALIAS, HOMEPAGE, IMAGE, DESCRIPTION FROM profile WHERE PROFILE_ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildProfile $obj */
            $obj = new ChildProfile();
            $obj->hydrate($row);
            ProfileTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildProfile|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the profile_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProfileId(1234); // WHERE profile_id = 1234
     * $query->filterByProfileId(array(12, 34)); // WHERE profile_id IN (12, 34)
     * $query->filterByProfileId(array('min' => 12)); // WHERE profile_id > 12
     * </code>
     *
     * @param     mixed $profileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByProfileId($profileId = null, $comparison = null)
    {
        if (is_array($profileId)) {
            $useMinMax = false;
            if (isset($profileId['min'])) {
                $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $profileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profileId['max'])) {
                $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $profileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $profileId, $comparison);
    }

    /**
     * Filter the query on the alias column
     *
     * Example usage:
     * <code>
     * $query->filterByAlias('fooValue');   // WHERE alias = 'fooValue'
     * $query->filterByAlias('%fooValue%'); // WHERE alias LIKE '%fooValue%'
     * </code>
     *
     * @param     string $alias The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByAlias($alias = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($alias)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $alias)) {
                $alias = str_replace('*', '%', $alias);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProfileTableMap::COL_ALIAS, $alias, $comparison);
    }

    /**
     * Filter the query on the homepage column
     *
     * Example usage:
     * <code>
     * $query->filterByHomepage('fooValue');   // WHERE homepage = 'fooValue'
     * $query->filterByHomepage('%fooValue%'); // WHERE homepage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $homepage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByHomepage($homepage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($homepage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $homepage)) {
                $homepage = str_replace('*', '%', $homepage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProfileTableMap::COL_HOMEPAGE, $homepage, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%'); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $image)) {
                $image = str_replace('*', '%', $image);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProfileTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProfileTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Curator object
     *
     * @param \justnyt\models\Curator|ObjectCollection $curator  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProfileQuery The current query, for fluid interface
     */
    public function filterByCurator($curator, $comparison = null)
    {
        if ($curator instanceof \justnyt\models\Curator) {
            return $this
                ->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $curator->getProfileId(), $comparison);
        } elseif ($curator instanceof ObjectCollection) {
            return $this
                ->useCuratorQuery()
                ->filterByPrimaryKeys($curator->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCurator() only accepts arguments of type \justnyt\models\Curator or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Curator relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function joinCurator($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Curator');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Curator');
        }

        return $this;
    }

    /**
     * Use the Curator relation Curator object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\CuratorQuery A secondary query class using the current class as primary query
     */
    public function useCuratorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCurator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Curator', '\justnyt\models\CuratorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProfile $profile Object to remove from the list of results
     *
     * @return $this|ChildProfileQuery The current query, for fluid interface
     */
    public function prune($profile = null)
    {
        if ($profile) {
            $this->addUsingAlias(ProfileTableMap::COL_PROFILE_ID, $profile->getProfileId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the profile table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfileTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProfileTableMap::clearInstancePool();
            ProfileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfileTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProfileTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProfileTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProfileTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProfileQuery
