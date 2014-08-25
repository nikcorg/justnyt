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
use justnyt\models\Curator as ChildCurator;
use justnyt\models\CuratorQuery as ChildCuratorQuery;
use justnyt\models\Map\CuratorTableMap;

/**
 * Base class that represents a query for the 'curator' table.
 *
 *
 *
 * @method     ChildCuratorQuery orderByCuratorId($order = Criteria::ASC) Order by the curator_id column
 * @method     ChildCuratorQuery orderByCandidateId($order = Criteria::ASC) Order by the candidate_id column
 * @method     ChildCuratorQuery orderByProfileId($order = Criteria::ASC) Order by the profile_id column
 * @method     ChildCuratorQuery orderByToken($order = Criteria::ASC) Order by the token column
 * @method     ChildCuratorQuery orderByInviteToken($order = Criteria::ASC) Order by the invite_token column
 * @method     ChildCuratorQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method     ChildCuratorQuery orderByActivatedOn($order = Criteria::ASC) Order by the activated_on column
 * @method     ChildCuratorQuery orderByDeactivatedOn($order = Criteria::ASC) Order by the deactivated_on column
 *
 * @method     ChildCuratorQuery groupByCuratorId() Group by the curator_id column
 * @method     ChildCuratorQuery groupByCandidateId() Group by the candidate_id column
 * @method     ChildCuratorQuery groupByProfileId() Group by the profile_id column
 * @method     ChildCuratorQuery groupByToken() Group by the token column
 * @method     ChildCuratorQuery groupByInviteToken() Group by the invite_token column
 * @method     ChildCuratorQuery groupByCreatedOn() Group by the created_on column
 * @method     ChildCuratorQuery groupByActivatedOn() Group by the activated_on column
 * @method     ChildCuratorQuery groupByDeactivatedOn() Group by the deactivated_on column
 *
 * @method     ChildCuratorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCuratorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCuratorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCuratorQuery leftJoinCandidate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Candidate relation
 * @method     ChildCuratorQuery rightJoinCandidate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Candidate relation
 * @method     ChildCuratorQuery innerJoinCandidate($relationAlias = null) Adds a INNER JOIN clause to the query using the Candidate relation
 *
 * @method     ChildCuratorQuery leftJoinProfile($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profile relation
 * @method     ChildCuratorQuery rightJoinProfile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profile relation
 * @method     ChildCuratorQuery innerJoinProfile($relationAlias = null) Adds a INNER JOIN clause to the query using the Profile relation
 *
 * @method     ChildCuratorQuery leftJoinRecommendation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recommendation relation
 * @method     ChildCuratorQuery rightJoinRecommendation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recommendation relation
 * @method     ChildCuratorQuery innerJoinRecommendation($relationAlias = null) Adds a INNER JOIN clause to the query using the Recommendation relation
 *
 * @method     \justnyt\models\CandidateQuery|\justnyt\models\ProfileQuery|\justnyt\models\RecommendationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCurator findOne(ConnectionInterface $con = null) Return the first ChildCurator matching the query
 * @method     ChildCurator findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCurator matching the query, or a new ChildCurator object populated from the query conditions when no match is found
 *
 * @method     ChildCurator findOneByCuratorId(int $curator_id) Return the first ChildCurator filtered by the curator_id column
 * @method     ChildCurator findOneByCandidateId(int $candidate_id) Return the first ChildCurator filtered by the candidate_id column
 * @method     ChildCurator findOneByProfileId(int $profile_id) Return the first ChildCurator filtered by the profile_id column
 * @method     ChildCurator findOneByToken(string $token) Return the first ChildCurator filtered by the token column
 * @method     ChildCurator findOneByInviteToken(string $invite_token) Return the first ChildCurator filtered by the invite_token column
 * @method     ChildCurator findOneByCreatedOn(string $created_on) Return the first ChildCurator filtered by the created_on column
 * @method     ChildCurator findOneByActivatedOn(string $activated_on) Return the first ChildCurator filtered by the activated_on column
 * @method     ChildCurator findOneByDeactivatedOn(string $deactivated_on) Return the first ChildCurator filtered by the deactivated_on column
 *
 * @method     ChildCurator[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCurator objects based on current ModelCriteria
 * @method     ChildCurator[]|ObjectCollection findByCuratorId(int $curator_id) Return ChildCurator objects filtered by the curator_id column
 * @method     ChildCurator[]|ObjectCollection findByCandidateId(int $candidate_id) Return ChildCurator objects filtered by the candidate_id column
 * @method     ChildCurator[]|ObjectCollection findByProfileId(int $profile_id) Return ChildCurator objects filtered by the profile_id column
 * @method     ChildCurator[]|ObjectCollection findByToken(string $token) Return ChildCurator objects filtered by the token column
 * @method     ChildCurator[]|ObjectCollection findByInviteToken(string $invite_token) Return ChildCurator objects filtered by the invite_token column
 * @method     ChildCurator[]|ObjectCollection findByCreatedOn(string $created_on) Return ChildCurator objects filtered by the created_on column
 * @method     ChildCurator[]|ObjectCollection findByActivatedOn(string $activated_on) Return ChildCurator objects filtered by the activated_on column
 * @method     ChildCurator[]|ObjectCollection findByDeactivatedOn(string $deactivated_on) Return ChildCurator objects filtered by the deactivated_on column
 * @method     ChildCurator[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CuratorQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\CuratorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\Curator', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCuratorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCuratorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCuratorQuery) {
            return $criteria;
        }
        $query = new ChildCuratorQuery();
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
     * @return ChildCurator|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CuratorTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CuratorTableMap::DATABASE_NAME);
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
     * @return ChildCurator A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `CURATOR_ID`, `CANDIDATE_ID`, `PROFILE_ID`, `TOKEN`, `INVITE_TOKEN`, `CREATED_ON`, `ACTIVATED_ON`, `DEACTIVATED_ON` FROM `curator` WHERE `CURATOR_ID` = :p0';
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
            /** @var ChildCurator $obj */
            $obj = new ChildCurator();
            $obj->hydrate($row);
            CuratorTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCurator|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the curator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCuratorId(1234); // WHERE curator_id = 1234
     * $query->filterByCuratorId(array(12, 34)); // WHERE curator_id IN (12, 34)
     * $query->filterByCuratorId(array('min' => 12)); // WHERE curator_id > 12
     * </code>
     *
     * @param     mixed $curatorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByCuratorId($curatorId = null, $comparison = null)
    {
        if (is_array($curatorId)) {
            $useMinMax = false;
            if (isset($curatorId['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $curatorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($curatorId['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $curatorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $curatorId, $comparison);
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
     * @see       filterByCandidate()
     *
     * @param     mixed $candidateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByCandidateId($candidateId = null, $comparison = null)
    {
        if (is_array($candidateId)) {
            $useMinMax = false;
            if (isset($candidateId['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CANDIDATE_ID, $candidateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($candidateId['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CANDIDATE_ID, $candidateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_CANDIDATE_ID, $candidateId, $comparison);
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
     * @see       filterByProfile()
     *
     * @param     mixed $profileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByProfileId($profileId = null, $comparison = null)
    {
        if (is_array($profileId)) {
            $useMinMax = false;
            if (isset($profileId['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_PROFILE_ID, $profileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($profileId['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_PROFILE_ID, $profileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_PROFILE_ID, $profileId, $comparison);
    }

    /**
     * Filter the query on the token column
     *
     * Example usage:
     * <code>
     * $query->filterByToken('fooValue');   // WHERE token = 'fooValue'
     * $query->filterByToken('%fooValue%'); // WHERE token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $token The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByToken($token = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($token)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $token)) {
                $token = str_replace('*', '%', $token);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_TOKEN, $token, $comparison);
    }

    /**
     * Filter the query on the invite_token column
     *
     * Example usage:
     * <code>
     * $query->filterByInviteToken('fooValue');   // WHERE invite_token = 'fooValue'
     * $query->filterByInviteToken('%fooValue%'); // WHERE invite_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $inviteToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByInviteToken($inviteToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($inviteToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $inviteToken)) {
                $inviteToken = str_replace('*', '%', $inviteToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_INVITE_TOKEN, $inviteToken, $comparison);
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
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_CREATED_ON, $createdOn, $comparison);
    }

    /**
     * Filter the query on the activated_on column
     *
     * Example usage:
     * <code>
     * $query->filterByActivatedOn('2011-03-14'); // WHERE activated_on = '2011-03-14'
     * $query->filterByActivatedOn('now'); // WHERE activated_on = '2011-03-14'
     * $query->filterByActivatedOn(array('max' => 'yesterday')); // WHERE activated_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $activatedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByActivatedOn($activatedOn = null, $comparison = null)
    {
        if (is_array($activatedOn)) {
            $useMinMax = false;
            if (isset($activatedOn['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_ACTIVATED_ON, $activatedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activatedOn['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_ACTIVATED_ON, $activatedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_ACTIVATED_ON, $activatedOn, $comparison);
    }

    /**
     * Filter the query on the deactivated_on column
     *
     * Example usage:
     * <code>
     * $query->filterByDeactivatedOn('2011-03-14'); // WHERE deactivated_on = '2011-03-14'
     * $query->filterByDeactivatedOn('now'); // WHERE deactivated_on = '2011-03-14'
     * $query->filterByDeactivatedOn(array('max' => 'yesterday')); // WHERE deactivated_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $deactivatedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByDeactivatedOn($deactivatedOn = null, $comparison = null)
    {
        if (is_array($deactivatedOn)) {
            $useMinMax = false;
            if (isset($deactivatedOn['min'])) {
                $this->addUsingAlias(CuratorTableMap::COL_DEACTIVATED_ON, $deactivatedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deactivatedOn['max'])) {
                $this->addUsingAlias(CuratorTableMap::COL_DEACTIVATED_ON, $deactivatedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CuratorTableMap::COL_DEACTIVATED_ON, $deactivatedOn, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Candidate object
     *
     * @param \justnyt\models\Candidate|ObjectCollection $candidate The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByCandidate($candidate, $comparison = null)
    {
        if ($candidate instanceof \justnyt\models\Candidate) {
            return $this
                ->addUsingAlias(CuratorTableMap::COL_CANDIDATE_ID, $candidate->getCandidateId(), $comparison);
        } elseif ($candidate instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CuratorTableMap::COL_CANDIDATE_ID, $candidate->toKeyValue('PrimaryKey', 'CandidateId'), $comparison);
        } else {
            throw new PropelException('filterByCandidate() only accepts arguments of type \justnyt\models\Candidate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Candidate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function joinCandidate($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Candidate');

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
            $this->addJoinObject($join, 'Candidate');
        }

        return $this;
    }

    /**
     * Use the Candidate relation Candidate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\CandidateQuery A secondary query class using the current class as primary query
     */
    public function useCandidateQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCandidate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Candidate', '\justnyt\models\CandidateQuery');
    }

    /**
     * Filter the query by a related \justnyt\models\Profile object
     *
     * @param \justnyt\models\Profile|ObjectCollection $profile The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByProfile($profile, $comparison = null)
    {
        if ($profile instanceof \justnyt\models\Profile) {
            return $this
                ->addUsingAlias(CuratorTableMap::COL_PROFILE_ID, $profile->getProfileId(), $comparison);
        } elseif ($profile instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CuratorTableMap::COL_PROFILE_ID, $profile->toKeyValue('PrimaryKey', 'ProfileId'), $comparison);
        } else {
            throw new PropelException('filterByProfile() only accepts arguments of type \justnyt\models\Profile or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Profile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function joinProfile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Profile');

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
            $this->addJoinObject($join, 'Profile');
        }

        return $this;
    }

    /**
     * Use the Profile relation Profile object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\ProfileQuery A secondary query class using the current class as primary query
     */
    public function useProfileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProfile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Profile', '\justnyt\models\ProfileQuery');
    }

    /**
     * Filter the query by a related \justnyt\models\Recommendation object
     *
     * @param \justnyt\models\Recommendation|ObjectCollection $recommendation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCuratorQuery The current query, for fluid interface
     */
    public function filterByRecommendation($recommendation, $comparison = null)
    {
        if ($recommendation instanceof \justnyt\models\Recommendation) {
            return $this
                ->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $recommendation->getCuratorId(), $comparison);
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
     * @return $this|ChildCuratorQuery The current query, for fluid interface
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
     * @param   ChildCurator $curator Object to remove from the list of results
     *
     * @return $this|ChildCuratorQuery The current query, for fluid interface
     */
    public function prune($curator = null)
    {
        if ($curator) {
            $this->addUsingAlias(CuratorTableMap::COL_CURATOR_ID, $curator->getCuratorId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the curator table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CuratorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CuratorTableMap::clearInstancePool();
            CuratorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CuratorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CuratorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CuratorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CuratorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CuratorQuery
