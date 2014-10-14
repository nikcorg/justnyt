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
use justnyt\models\Visit as ChildVisit;
use justnyt\models\VisitQuery as ChildVisitQuery;
use justnyt\models\Map\VisitTableMap;

/**
 * Base class that represents a query for the 'visit' table.
 *
 *
 *
 * @method     ChildVisitQuery orderByVisitId($order = Criteria::ASC) Order by the visit_id column
 * @method     ChildVisitQuery orderByRecordedOn($order = Criteria::ASC) Order by the recorded_on column
 * @method     ChildVisitQuery orderByVisitorId($order = Criteria::ASC) Order by the visitor_id column
 * @method     ChildVisitQuery orderByRecommendationId($order = Criteria::ASC) Order by the recommendation_id column
 * @method     ChildVisitQuery orderByReferrer($order = Criteria::ASC) Order by the referrer column
 *
 * @method     ChildVisitQuery groupByVisitId() Group by the visit_id column
 * @method     ChildVisitQuery groupByRecordedOn() Group by the recorded_on column
 * @method     ChildVisitQuery groupByVisitorId() Group by the visitor_id column
 * @method     ChildVisitQuery groupByRecommendationId() Group by the recommendation_id column
 * @method     ChildVisitQuery groupByReferrer() Group by the referrer column
 *
 * @method     ChildVisitQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVisitQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVisitQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVisitQuery leftJoinRecommendation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recommendation relation
 * @method     ChildVisitQuery rightJoinRecommendation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recommendation relation
 * @method     ChildVisitQuery innerJoinRecommendation($relationAlias = null) Adds a INNER JOIN clause to the query using the Recommendation relation
 *
 * @method     \justnyt\models\RecommendationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVisit findOne(ConnectionInterface $con = null) Return the first ChildVisit matching the query
 * @method     ChildVisit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVisit matching the query, or a new ChildVisit object populated from the query conditions when no match is found
 *
 * @method     ChildVisit findOneByVisitId(int $visit_id) Return the first ChildVisit filtered by the visit_id column
 * @method     ChildVisit findOneByRecordedOn(string $recorded_on) Return the first ChildVisit filtered by the recorded_on column
 * @method     ChildVisit findOneByVisitorId(string $visitor_id) Return the first ChildVisit filtered by the visitor_id column
 * @method     ChildVisit findOneByRecommendationId(int $recommendation_id) Return the first ChildVisit filtered by the recommendation_id column
 * @method     ChildVisit findOneByReferrer(string $referrer) Return the first ChildVisit filtered by the referrer column
 *
 * @method     ChildVisit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVisit objects based on current ModelCriteria
 * @method     ChildVisit[]|ObjectCollection findByVisitId(int $visit_id) Return ChildVisit objects filtered by the visit_id column
 * @method     ChildVisit[]|ObjectCollection findByRecordedOn(string $recorded_on) Return ChildVisit objects filtered by the recorded_on column
 * @method     ChildVisit[]|ObjectCollection findByVisitorId(string $visitor_id) Return ChildVisit objects filtered by the visitor_id column
 * @method     ChildVisit[]|ObjectCollection findByRecommendationId(int $recommendation_id) Return ChildVisit objects filtered by the recommendation_id column
 * @method     ChildVisit[]|ObjectCollection findByReferrer(string $referrer) Return ChildVisit objects filtered by the referrer column
 * @method     ChildVisit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VisitQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\VisitQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\Visit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVisitQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVisitQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVisitQuery) {
            return $criteria;
        }
        $query = new ChildVisitQuery();
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
     * @return ChildVisit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = VisitTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VisitTableMap::DATABASE_NAME);
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
     * @return ChildVisit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `VISIT_ID`, `RECORDED_ON`, `VISITOR_ID`, `RECOMMENDATION_ID`, `REFERRER` FROM `visit` WHERE `VISIT_ID` = :p0';
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
            /** @var ChildVisit $obj */
            $obj = new ChildVisit();
            $obj->hydrate($row);
            VisitTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildVisit|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the visit_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVisitId(1234); // WHERE visit_id = 1234
     * $query->filterByVisitId(array(12, 34)); // WHERE visit_id IN (12, 34)
     * $query->filterByVisitId(array('min' => 12)); // WHERE visit_id > 12
     * </code>
     *
     * @param     mixed $visitId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByVisitId($visitId = null, $comparison = null)
    {
        if (is_array($visitId)) {
            $useMinMax = false;
            if (isset($visitId['min'])) {
                $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $visitId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visitId['max'])) {
                $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $visitId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $visitId, $comparison);
    }

    /**
     * Filter the query on the recorded_on column
     *
     * Example usage:
     * <code>
     * $query->filterByRecordedOn('2011-03-14'); // WHERE recorded_on = '2011-03-14'
     * $query->filterByRecordedOn('now'); // WHERE recorded_on = '2011-03-14'
     * $query->filterByRecordedOn(array('max' => 'yesterday')); // WHERE recorded_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $recordedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByRecordedOn($recordedOn = null, $comparison = null)
    {
        if (is_array($recordedOn)) {
            $useMinMax = false;
            if (isset($recordedOn['min'])) {
                $this->addUsingAlias(VisitTableMap::COL_RECORDED_ON, $recordedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recordedOn['max'])) {
                $this->addUsingAlias(VisitTableMap::COL_RECORDED_ON, $recordedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VisitTableMap::COL_RECORDED_ON, $recordedOn, $comparison);
    }

    /**
     * Filter the query on the visitor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVisitorId('fooValue');   // WHERE visitor_id = 'fooValue'
     * $query->filterByVisitorId('%fooValue%'); // WHERE visitor_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $visitorId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByVisitorId($visitorId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($visitorId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $visitorId)) {
                $visitorId = str_replace('*', '%', $visitorId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(VisitTableMap::COL_VISITOR_ID, $visitorId, $comparison);
    }

    /**
     * Filter the query on the recommendation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRecommendationId(1234); // WHERE recommendation_id = 1234
     * $query->filterByRecommendationId(array(12, 34)); // WHERE recommendation_id IN (12, 34)
     * $query->filterByRecommendationId(array('min' => 12)); // WHERE recommendation_id > 12
     * </code>
     *
     * @see       filterByRecommendation()
     *
     * @param     mixed $recommendationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByRecommendationId($recommendationId = null, $comparison = null)
    {
        if (is_array($recommendationId)) {
            $useMinMax = false;
            if (isset($recommendationId['min'])) {
                $this->addUsingAlias(VisitTableMap::COL_RECOMMENDATION_ID, $recommendationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recommendationId['max'])) {
                $this->addUsingAlias(VisitTableMap::COL_RECOMMENDATION_ID, $recommendationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VisitTableMap::COL_RECOMMENDATION_ID, $recommendationId, $comparison);
    }

    /**
     * Filter the query on the referrer column
     *
     * Example usage:
     * <code>
     * $query->filterByReferrer('fooValue');   // WHERE referrer = 'fooValue'
     * $query->filterByReferrer('%fooValue%'); // WHERE referrer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $referrer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function filterByReferrer($referrer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($referrer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $referrer)) {
                $referrer = str_replace('*', '%', $referrer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(VisitTableMap::COL_REFERRER, $referrer, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Recommendation object
     *
     * @param \justnyt\models\Recommendation|ObjectCollection $recommendation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVisitQuery The current query, for fluid interface
     */
    public function filterByRecommendation($recommendation, $comparison = null)
    {
        if ($recommendation instanceof \justnyt\models\Recommendation) {
            return $this
                ->addUsingAlias(VisitTableMap::COL_RECOMMENDATION_ID, $recommendation->getRecommendationId(), $comparison);
        } elseif ($recommendation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VisitTableMap::COL_RECOMMENDATION_ID, $recommendation->toKeyValue('PrimaryKey', 'RecommendationId'), $comparison);
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
     * @return $this|ChildVisitQuery The current query, for fluid interface
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
     * @param   ChildVisit $visit Object to remove from the list of results
     *
     * @return $this|ChildVisitQuery The current query, for fluid interface
     */
    public function prune($visit = null)
    {
        if ($visit) {
            $this->addUsingAlias(VisitTableMap::COL_VISIT_ID, $visit->getVisitId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the visit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VisitTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VisitTableMap::clearInstancePool();
            VisitTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VisitTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VisitTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VisitTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VisitTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VisitQuery
