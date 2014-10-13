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
use justnyt\models\Recommendation as ChildRecommendation;
use justnyt\models\RecommendationQuery as ChildRecommendationQuery;
use justnyt\models\Map\RecommendationTableMap;

/**
 * Base class that represents a query for the 'recommendation' table.
 *
 *
 *
 * @method     ChildRecommendationQuery orderByRecommendationId($order = Criteria::ASC) Order by the recommendation_id column
 * @method     ChildRecommendationQuery orderByCuratorId($order = Criteria::ASC) Order by the curator_id column
 * @method     ChildRecommendationQuery orderByRecommendationHintId($order = Criteria::ASC) Order by the recommendation_hint_id column
 * @method     ChildRecommendationQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method     ChildRecommendationQuery orderByScrapedOn($order = Criteria::ASC) Order by the scraped_on column
 * @method     ChildRecommendationQuery orderByApprovedOn($order = Criteria::ASC) Order by the approved_on column
 * @method     ChildRecommendationQuery orderByGraphicContent($order = Criteria::ASC) Order by the graphic_content column
 * @method     ChildRecommendationQuery orderByShortlink($order = Criteria::ASC) Order by the shortlink column
 * @method     ChildRecommendationQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildRecommendationQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildRecommendationQuery orderByQuote($order = Criteria::ASC) Order by the quote column
 *
 * @method     ChildRecommendationQuery groupByRecommendationId() Group by the recommendation_id column
 * @method     ChildRecommendationQuery groupByCuratorId() Group by the curator_id column
 * @method     ChildRecommendationQuery groupByRecommendationHintId() Group by the recommendation_hint_id column
 * @method     ChildRecommendationQuery groupByCreatedOn() Group by the created_on column
 * @method     ChildRecommendationQuery groupByScrapedOn() Group by the scraped_on column
 * @method     ChildRecommendationQuery groupByApprovedOn() Group by the approved_on column
 * @method     ChildRecommendationQuery groupByGraphicContent() Group by the graphic_content column
 * @method     ChildRecommendationQuery groupByShortlink() Group by the shortlink column
 * @method     ChildRecommendationQuery groupByUrl() Group by the url column
 * @method     ChildRecommendationQuery groupByTitle() Group by the title column
 * @method     ChildRecommendationQuery groupByQuote() Group by the quote column
 *
 * @method     ChildRecommendationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRecommendationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRecommendationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRecommendationQuery leftJoinCurator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Curator relation
 * @method     ChildRecommendationQuery rightJoinCurator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Curator relation
 * @method     ChildRecommendationQuery innerJoinCurator($relationAlias = null) Adds a INNER JOIN clause to the query using the Curator relation
 *
 * @method     ChildRecommendationQuery leftJoinRecommendationHint($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecommendationHint relation
 * @method     ChildRecommendationQuery rightJoinRecommendationHint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecommendationHint relation
 * @method     ChildRecommendationQuery innerJoinRecommendationHint($relationAlias = null) Adds a INNER JOIN clause to the query using the RecommendationHint relation
 *
 * @method     ChildRecommendationQuery leftJoinVisit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Visit relation
 * @method     ChildRecommendationQuery rightJoinVisit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Visit relation
 * @method     ChildRecommendationQuery innerJoinVisit($relationAlias = null) Adds a INNER JOIN clause to the query using the Visit relation
 *
 * @method     \justnyt\models\CuratorQuery|\justnyt\models\RecommendationHintQuery|\justnyt\models\VisitQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRecommendation findOne(ConnectionInterface $con = null) Return the first ChildRecommendation matching the query
 * @method     ChildRecommendation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRecommendation matching the query, or a new ChildRecommendation object populated from the query conditions when no match is found
 *
 * @method     ChildRecommendation findOneByRecommendationId(int $recommendation_id) Return the first ChildRecommendation filtered by the recommendation_id column
 * @method     ChildRecommendation findOneByCuratorId(int $curator_id) Return the first ChildRecommendation filtered by the curator_id column
 * @method     ChildRecommendation findOneByRecommendationHintId(int $recommendation_hint_id) Return the first ChildRecommendation filtered by the recommendation_hint_id column
 * @method     ChildRecommendation findOneByCreatedOn(string $created_on) Return the first ChildRecommendation filtered by the created_on column
 * @method     ChildRecommendation findOneByScrapedOn(string $scraped_on) Return the first ChildRecommendation filtered by the scraped_on column
 * @method     ChildRecommendation findOneByApprovedOn(string $approved_on) Return the first ChildRecommendation filtered by the approved_on column
 * @method     ChildRecommendation findOneByGraphicContent(boolean $graphic_content) Return the first ChildRecommendation filtered by the graphic_content column
 * @method     ChildRecommendation findOneByShortlink(string $shortlink) Return the first ChildRecommendation filtered by the shortlink column
 * @method     ChildRecommendation findOneByUrl(string $url) Return the first ChildRecommendation filtered by the url column
 * @method     ChildRecommendation findOneByTitle(string $title) Return the first ChildRecommendation filtered by the title column
 * @method     ChildRecommendation findOneByQuote(string $quote) Return the first ChildRecommendation filtered by the quote column
 *
 * @method     ChildRecommendation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRecommendation objects based on current ModelCriteria
 * @method     ChildRecommendation[]|ObjectCollection findByRecommendationId(int $recommendation_id) Return ChildRecommendation objects filtered by the recommendation_id column
 * @method     ChildRecommendation[]|ObjectCollection findByCuratorId(int $curator_id) Return ChildRecommendation objects filtered by the curator_id column
 * @method     ChildRecommendation[]|ObjectCollection findByRecommendationHintId(int $recommendation_hint_id) Return ChildRecommendation objects filtered by the recommendation_hint_id column
 * @method     ChildRecommendation[]|ObjectCollection findByCreatedOn(string $created_on) Return ChildRecommendation objects filtered by the created_on column
 * @method     ChildRecommendation[]|ObjectCollection findByScrapedOn(string $scraped_on) Return ChildRecommendation objects filtered by the scraped_on column
 * @method     ChildRecommendation[]|ObjectCollection findByApprovedOn(string $approved_on) Return ChildRecommendation objects filtered by the approved_on column
 * @method     ChildRecommendation[]|ObjectCollection findByGraphicContent(boolean $graphic_content) Return ChildRecommendation objects filtered by the graphic_content column
 * @method     ChildRecommendation[]|ObjectCollection findByShortlink(string $shortlink) Return ChildRecommendation objects filtered by the shortlink column
 * @method     ChildRecommendation[]|ObjectCollection findByUrl(string $url) Return ChildRecommendation objects filtered by the url column
 * @method     ChildRecommendation[]|ObjectCollection findByTitle(string $title) Return ChildRecommendation objects filtered by the title column
 * @method     ChildRecommendation[]|ObjectCollection findByQuote(string $quote) Return ChildRecommendation objects filtered by the quote column
 * @method     ChildRecommendation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RecommendationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \justnyt\models\Base\RecommendationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'justnyt', $modelName = '\\justnyt\\models\\Recommendation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRecommendationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRecommendationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRecommendationQuery) {
            return $criteria;
        }
        $query = new ChildRecommendationQuery();
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
     * @return ChildRecommendation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RecommendationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RecommendationTableMap::DATABASE_NAME);
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
     * @return ChildRecommendation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `RECOMMENDATION_ID`, `CURATOR_ID`, `RECOMMENDATION_HINT_ID`, `CREATED_ON`, `SCRAPED_ON`, `APPROVED_ON`, `GRAPHIC_CONTENT`, `SHORTLINK`, `URL`, `TITLE`, `QUOTE` FROM `recommendation` WHERE `RECOMMENDATION_ID` = :p0';
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
            /** @var ChildRecommendation $obj */
            $obj = new ChildRecommendation();
            $obj->hydrate($row);
            RecommendationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRecommendation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $keys, Criteria::IN);
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
     * @param     mixed $recommendationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByRecommendationId($recommendationId = null, $comparison = null)
    {
        if (is_array($recommendationId)) {
            $useMinMax = false;
            if (isset($recommendationId['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $recommendationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recommendationId['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $recommendationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $recommendationId, $comparison);
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
     * @see       filterByCurator()
     *
     * @param     mixed $curatorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByCuratorId($curatorId = null, $comparison = null)
    {
        if (is_array($curatorId)) {
            $useMinMax = false;
            if (isset($curatorId['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_CURATOR_ID, $curatorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($curatorId['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_CURATOR_ID, $curatorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_CURATOR_ID, $curatorId, $comparison);
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
     * @see       filterByRecommendationHint()
     *
     * @param     mixed $recommendationHintId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByRecommendationHintId($recommendationHintId = null, $comparison = null)
    {
        if (is_array($recommendationHintId)) {
            $useMinMax = false;
            if (isset($recommendationHintId['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recommendationHintId['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHintId, $comparison);
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
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_CREATED_ON, $createdOn, $comparison);
    }

    /**
     * Filter the query on the scraped_on column
     *
     * Example usage:
     * <code>
     * $query->filterByScrapedOn('2011-03-14'); // WHERE scraped_on = '2011-03-14'
     * $query->filterByScrapedOn('now'); // WHERE scraped_on = '2011-03-14'
     * $query->filterByScrapedOn(array('max' => 'yesterday')); // WHERE scraped_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $scrapedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByScrapedOn($scrapedOn = null, $comparison = null)
    {
        if (is_array($scrapedOn)) {
            $useMinMax = false;
            if (isset($scrapedOn['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_SCRAPED_ON, $scrapedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($scrapedOn['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_SCRAPED_ON, $scrapedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_SCRAPED_ON, $scrapedOn, $comparison);
    }

    /**
     * Filter the query on the approved_on column
     *
     * Example usage:
     * <code>
     * $query->filterByApprovedOn('2011-03-14'); // WHERE approved_on = '2011-03-14'
     * $query->filterByApprovedOn('now'); // WHERE approved_on = '2011-03-14'
     * $query->filterByApprovedOn(array('max' => 'yesterday')); // WHERE approved_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $approvedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByApprovedOn($approvedOn = null, $comparison = null)
    {
        if (is_array($approvedOn)) {
            $useMinMax = false;
            if (isset($approvedOn['min'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_APPROVED_ON, $approvedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($approvedOn['max'])) {
                $this->addUsingAlias(RecommendationTableMap::COL_APPROVED_ON, $approvedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_APPROVED_ON, $approvedOn, $comparison);
    }

    /**
     * Filter the query on the graphic_content column
     *
     * Example usage:
     * <code>
     * $query->filterByGraphicContent(true); // WHERE graphic_content = true
     * $query->filterByGraphicContent('yes'); // WHERE graphic_content = true
     * </code>
     *
     * @param     boolean|string $graphicContent The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByGraphicContent($graphicContent = null, $comparison = null)
    {
        if (is_string($graphicContent)) {
            $graphicContent = in_array(strtolower($graphicContent), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_GRAPHIC_CONTENT, $graphicContent, $comparison);
    }

    /**
     * Filter the query on the shortlink column
     *
     * Example usage:
     * <code>
     * $query->filterByShortlink('fooValue');   // WHERE shortlink = 'fooValue'
     * $query->filterByShortlink('%fooValue%'); // WHERE shortlink LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shortlink The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByShortlink($shortlink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shortlink)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shortlink)) {
                $shortlink = str_replace('*', '%', $shortlink);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_SHORTLINK, $shortlink, $comparison);
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
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RecommendationTableMap::COL_URL, $url, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the quote column
     *
     * Example usage:
     * <code>
     * $query->filterByQuote('fooValue');   // WHERE quote = 'fooValue'
     * $query->filterByQuote('%fooValue%'); // WHERE quote LIKE '%fooValue%'
     * </code>
     *
     * @param     string $quote The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByQuote($quote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($quote)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $quote)) {
                $quote = str_replace('*', '%', $quote);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RecommendationTableMap::COL_QUOTE, $quote, $comparison);
    }

    /**
     * Filter the query by a related \justnyt\models\Curator object
     *
     * @param \justnyt\models\Curator|ObjectCollection $curator The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByCurator($curator, $comparison = null)
    {
        if ($curator instanceof \justnyt\models\Curator) {
            return $this
                ->addUsingAlias(RecommendationTableMap::COL_CURATOR_ID, $curator->getCuratorId(), $comparison);
        } elseif ($curator instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RecommendationTableMap::COL_CURATOR_ID, $curator->toKeyValue('PrimaryKey', 'CuratorId'), $comparison);
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
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
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
     * Filter the query by a related \justnyt\models\RecommendationHint object
     *
     * @param \justnyt\models\RecommendationHint|ObjectCollection $recommendationHint The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByRecommendationHint($recommendationHint, $comparison = null)
    {
        if ($recommendationHint instanceof \justnyt\models\RecommendationHint) {
            return $this
                ->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHint->getRecommendationHintId(), $comparison);
        } elseif ($recommendationHint instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $recommendationHint->toKeyValue('PrimaryKey', 'RecommendationHintId'), $comparison);
        } else {
            throw new PropelException('filterByRecommendationHint() only accepts arguments of type \justnyt\models\RecommendationHint or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RecommendationHint relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function joinRecommendationHint($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RecommendationHint');

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
            $this->addJoinObject($join, 'RecommendationHint');
        }

        return $this;
    }

    /**
     * Use the RecommendationHint relation RecommendationHint object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\RecommendationHintQuery A secondary query class using the current class as primary query
     */
    public function useRecommendationHintQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRecommendationHint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RecommendationHint', '\justnyt\models\RecommendationHintQuery');
    }

    /**
     * Filter the query by a related \justnyt\models\Visit object
     *
     * @param \justnyt\models\Visit|ObjectCollection $visit  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRecommendationQuery The current query, for fluid interface
     */
    public function filterByVisit($visit, $comparison = null)
    {
        if ($visit instanceof \justnyt\models\Visit) {
            return $this
                ->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $visit->getRecommendationId(), $comparison);
        } elseif ($visit instanceof ObjectCollection) {
            return $this
                ->useVisitQuery()
                ->filterByPrimaryKeys($visit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVisit() only accepts arguments of type \justnyt\models\Visit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Visit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function joinVisit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Visit');

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
            $this->addJoinObject($join, 'Visit');
        }

        return $this;
    }

    /**
     * Use the Visit relation Visit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \justnyt\models\VisitQuery A secondary query class using the current class as primary query
     */
    public function useVisitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVisit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Visit', '\justnyt\models\VisitQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRecommendation $recommendation Object to remove from the list of results
     *
     * @return $this|ChildRecommendationQuery The current query, for fluid interface
     */
    public function prune($recommendation = null)
    {
        if ($recommendation) {
            $this->addUsingAlias(RecommendationTableMap::COL_RECOMMENDATION_ID, $recommendation->getRecommendationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the recommendation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RecommendationTableMap::clearInstancePool();
            RecommendationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RecommendationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RecommendationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RecommendationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RecommendationQuery
