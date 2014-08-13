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
use justnyt\models\Candidate as ChildCandidate;
use justnyt\models\CandidateQuery as ChildCandidateQuery;
use justnyt\models\Map\CandidateTableMap;

/**
 * Base class that represents a query for the 'candidate' table.
 *
 *
 *
 * @method     ChildCandidateQuery orderByCandidateId($order = Criteria::ASC) Order by the candidate_id column
 * @method     ChildCandidateQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method     ChildCandidateQuery orderByEmail($order = Criteria::ASC) Order by the email column
 *
 * @method     ChildCandidateQuery groupByCandidateId() Group by the candidate_id column
 * @method     ChildCandidateQuery groupByCreatedOn() Group by the created_on column
 * @method     ChildCandidateQuery groupByEmail() Group by the email column
 *
 * @method     ChildCandidateQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCandidateQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCandidateQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCandidateQuery leftJoinCurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Curator relation
 * @method     ChildCandidateQuery rightJoinCurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Curator relation
 * @method     ChildCandidateQuery innerJoinCurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Curator relation
 *
 * @method     \justnyt\models\CuratorQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCandidate findOne(ConnectionInterface $con = null) Return the first ChildCandidate matching the query
 * @method     ChildCandidate findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCandidate matching the query, or a new ChildCandidate object populated from the query conditions when no match is found
 *
 * @method     ChildCandidate findOneByCandidateId(int $candidate_id) Return the first ChildCandidate filtered by the candidate_id column
 * @method     ChildCandidate findOneByCreatedOn(string $created_on) Return the first ChildCandidate filtered by the created_on column
 * @method     ChildCandidate findOneByEmail(string $email) Return the first ChildCandidate filtered by the email column
 *
 * @method     ChildCandidate[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCandidate objects based on current ModelCriteria
 * @method     ChildCandidate[]|ObjectCollection findByCandidateId(int $candidate_id) Return ChildCandidate objects filtered by the candidate_id column
 * @method     ChildCandidate[]|ObjectCollection findByCreatedOn(string $created_on) Return ChildCandidate objects filtered by the created_on column
 * @method     ChildCandidate[]|ObjectCollection findByEmail(string $email) Return ChildCandidate objects filtered by the email column
 * @method     ChildCandidate[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CandidateQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\CandidateQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\Candidate', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCandidateQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCandidateQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCandidateQuery) {
            return $criteria;
        }
        $query = new ChildCandidateQuery();
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
     * @return ChildCandidate|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CandidateTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CandidateTableMap::DATABASE_NAME);
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
     * @return ChildCandidate A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `CANDIDATE_ID`, `CREATED_ON`, `EMAIL` FROM `candidate` WHERE `CANDIDATE_ID` = :p0';
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
            /** @var ChildCandidate $obj */
            $obj = new ChildCandidate();
            $obj->hydrate($row);
            CandidateTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCandidate|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the candidate_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCandidateId(1234); // WHERE candidate_id = 1234
     * $query->filterByCandidateId(array(12, 34)); // WHERE candidate_id IN (12, 34)
     * $query->filterByCandidateId(array('min' => 12)); // WHERE candidate_id > 12
     * </code>
     *
     * @param     mixed $candidateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByCandidateId($candidateId = null, $comparison = null)
    {
        if (is_array($candidateId)) {
            $useMinMax = false;
            if (isset($candidateId['min'])) {
                $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $candidateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($candidateId['max'])) {
                $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $candidateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $candidateId, $comparison);
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
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(CandidateTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(CandidateTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CandidateTableMap::COL_CREATED_ON, $createdOn, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CandidateTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Curator object
     *
     * @param \justnyt\models\Curator|ObjectCollection $curator  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCandidateQuery The current query, for fluid interface
     */
    public function filterByCurator($curator, $comparison = null)
    {
        if ($curator instanceof \justnyt\models\Curator) {
            return $this
                ->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $curator->getCandidateId(), $comparison);
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
     * @return $this|ChildCandidateQuery The current query, for fluid interface
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
     * @param   ChildCandidate $candidate Object to remove from the list of results
     *
     * @return $this|ChildCandidateQuery The current query, for fluid interface
     */
    public function prune($candidate = null)
    {
        if ($candidate) {
            $this->addUsingAlias(CandidateTableMap::COL_CANDIDATE_ID, $candidate->getCandidateId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the candidate table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CandidateTableMap::clearInstancePool();
            CandidateTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CandidateTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CandidateTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CandidateTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CandidateQuery
