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
use justnyt\models\RecommendationHint as ChildRecommendationHint;
use justnyt\models\RecommendationHintQuery as ChildRecommendationHintQuery;
use justnyt\models\Map\RecommendationHintTableMap;

/**
 * Base class that represents a query for the 'recommendation_hint' table.
 *
 *
 *
 * @method     ChildRecommendationHintQuery orderByRecommendationHintId($order = Criteria::ASC) Order by the recommendation_hint_id column
 * @method     ChildRecommendationHintQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method     ChildRecommendationHintQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildRecommendationHintQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 *
 * @method     ChildRecommendationHintQuery groupByRecommendationHintId() Group by the recommendation_hint_id column
 * @method     ChildRecommendationHintQuery groupByCreatedOn() Group by the created_on column
 * @method     ChildRecommendationHintQuery groupByUrl() Group by the url column
 * @method     ChildRecommendationHintQuery groupByAlias() Group by the alias column
 *
 * @method     ChildRecommendationHintQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRecommendationHintQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRecommendationHintQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRecommendationHintQuery leftJoinRecommendation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recommendation relation
 * @method     ChildRecommendationHintQuery rightJoinRecommendation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recommendation relation
 * @method     ChildRecommendationHintQuery innerJoinRecommendation($relationAlias = null) Adds a INNER JOIN clause to the query using the Recommendation relation
 *
 * @method     \justnyt\models\RecommendationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRecommendationHint findOne(ConnectionInterface $con = null) Return the first ChildRecommendationHint matching the query
 * @method     ChildRecommendationHint findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRecommendationHint matching the query, or a new ChildRecommendationHint object populated from the query conditions when no match is found
 *
 * @method     ChildRecommendationHint findOneByRecommendationHintId(int $recommendation_hint_id) Return the first ChildRecommendationHint filtered by the recommendation_hint_id column
 * @method     ChildRecommendationHint findOneByCreatedOn(string $created_on) Return the first ChildRecommendationHint filtered by the created_on column
 * @method     ChildRecommendationHint findOneByUrl(string $url) Return the first ChildRecommendationHint filtered by the url column
 * @method     ChildRecommendationHint findOneByAlias(string $alias) Return the first ChildRecommendationHint filtered by the alias column
 *
 * @method     ChildRecommendationHint[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRecommendationHint objects based on current ModelCriteria
 * @method     ChildRecommendationHint[]|ObjectCollection findByRecommendationHintId(int $recommendation_hint_id) Return ChildRecommendationHint objects filtered by the recommendation_hint_id column
 * @method     ChildRecommendationHint[]|ObjectCollection findByCreatedOn(string $created_on) Return ChildRecommendationHint objects filtered by the created_on column
 * @method     ChildRecommendationHint[]|ObjectCollection findByUrl(string $url) Return ChildRecommendationHint objects filtered by the url column
 * @method     ChildRecommendationHint[]|ObjectCollection findByAlias(string $alias) Return ChildRecommendationHint objects filtered by the alias column
 * @method     ChildRecommendationHint[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RecommendationHintQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\RecommendationHintQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\RecommendationHint', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRecommendationHintQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRecommendationHintQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRecommendationHintQuery) {
            return $criteria;
        }
        $query = new ChildRecommendationHintQuery();
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
     * @return ChildRecommendationHint|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RecommendationHintTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RecommendationHintTableMap::DATABASE_NAME);
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
     * @return ChildRecommendationHint A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `RECOMMENDATION_HINT_ID`, `CREATED_ON`, `URL`, `ALIAS` FROM `recommendation_hint` WHERE `RECOMMENDATION_HINT_ID` = :p0';
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
            /** @var ChildRecommendationHint $obj */
            $obj = new ChildRecommendationHint();
            $obj->hydrate($row);
            RecommendationHintTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRecommendationHint|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the recommendation_hint_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRecommendationHintId(1234); // WHERE recommendation_hint_id = 1234
     * $query->filterByRecommendationHintId(array(12, 34)); // WHERE recommendation_hint_id IN (12, 34)
     * $query->filterByRecommendationHintId(array('min' => 12)); // WHERE recommendation_hint_id > 12
     * </code>
     *
     * @param     mixed $recommendationHintId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByRecommendationHintId($recommendationHintId = null, $comparison = null)
    {
        if (is_array($recommendationHintId)) {
            $useMinMax = false;
            if (isset($recommendationHintId['min'])) {
                $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recommendationHintId['max'])) {
                $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId, $comparison);
    }

    /**
     * Filter the query on the created_on column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedOn('2011-03-14'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn('now'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn(array('max' => 'yesterday')); // WHERE created_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(RecommendationHintTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(RecommendationHintTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationHintTableMap::COL_CREATED_ON, $createdOn, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RecommendationHintTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RecommendationHintTableMap::COL_ALIAS, $alias, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Recommendation object
     *
     * @param \justnyt\models\Recommendation|ObjectCollection $recommendation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function filterByRecommendation($recommendation, $comparison = null)
    {
        if ($recommendation instanceof \justnyt\models\Recommendation) {
            return $this
                ->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $recommendation->getRecommendationHintId(), $comparison);
        } elseif ($recommendation instanceof ObjectCollection) {
            return $this
                ->useRecommendationQuery()
                ->filterByPrimaryKeys($recommendation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRecommendation() only accepts arguments of type \justnyt\models\Recommendation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Recommendation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function joinRecommendation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Recommendation');

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
            $this->addJoinObject($join, 'Recommendation');
        }

        return $this;
    }

    /**
     * Use the Recommendation relation Recommendation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\RecommendationQuery A secondary query class using the current class as primary query
     */
    public function useRecommendationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRecommendation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Recommendation', '\justnyt\models\RecommendationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRecommendationHint $recommendationHint Object to remove from the list of results
     *
     * @return $this|ChildRecommendationHintQuery The current query, for fluid interface
     */
    public function prune($recommendationHint = null)
    {
        if ($recommendationHint) {
            $this->addUsingAlias(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHint->getRecommendationHintId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the recommendation_hint table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RecommendationHintTableMap::clearInstancePool();
            RecommendationHintTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RecommendationHintTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RecommendationHintTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RecommendationHintTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RecommendationHintQuery
