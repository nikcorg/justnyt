<?php

namespace justnyt\models\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use justnyt\models\Recommendation;
use justnyt\models\RecommendationQuery;


/**
 * This class defines the structure of the 'recommendation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RecommendationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'justnyt.models.Map.RecommendationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'justnyt';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'recommendation';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\justnyt\\models\\Recommendation';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'justnyt.models.Recommendation';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the RECOMMENDATION_ID field
     */
    const COL_RECOMMENDATION_ID = 'recommendation.RECOMMENDATION_ID';

    /**
     * the column name for the CURATOR_ID field
     */
    const COL_CURATOR_ID = 'recommendation.CURATOR_ID';

    /**
     * the column name for the RECOMMENDATION_HINT_ID field
     */
    const COL_RECOMMENDATION_HINT_ID = 'recommendation.RECOMMENDATION_HINT_ID';

    /**
     * the column name for the CREATED_ON field
     */
    const COL_CREATED_ON = 'recommendation.CREATED_ON';

    /**
     * the column name for the SCRAPED_ON field
     */
    const COL_SCRAPED_ON = 'recommendation.SCRAPED_ON';

    /**
     * the column name for the APPROVED_ON field
     */
    const COL_APPROVED_ON = 'recommendation.APPROVED_ON';

    /**
     * the column name for the GRAPHIC_CONTENT field
     */
    const COL_GRAPHIC_CONTENT = 'recommendation.GRAPHIC_CONTENT';

    /**
     * the column name for the SHORTLINK field
     */
    const COL_SHORTLINK = 'recommendation.SHORTLINK';

    /**
     * the column name for the URL field
     */
    const COL_URL = 'recommendation.URL';

    /**
     * the column name for the TITLE field
     */
    const COL_TITLE = 'recommendation.TITLE';

    /**
     * the column name for the QUOTE field
     */
    const COL_QUOTE = 'recommendation.QUOTE';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('RecommendationId', 'CuratorId', 'RecommendationHintId', 'CreatedOn', 'ScrapedOn', 'ApprovedOn', 'GraphicContent', 'Shortlink', 'Url', 'Title', 'Quote', ),
        self::TYPE_STUDLYPHPNAME => array('recommendationId', 'curatorId', 'recommendationHintId', 'createdOn', 'scrapedOn', 'approvedOn', 'graphicContent', 'shortlink', 'url', 'title', 'quote', ),
        self::TYPE_COLNAME       => array(RecommendationTableMap::COL_RECOMMENDATION_ID, RecommendationTableMap::COL_CURATOR_ID, RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, RecommendationTableMap::COL_CREATED_ON, RecommendationTableMap::COL_SCRAPED_ON, RecommendationTableMap::COL_APPROVED_ON, RecommendationTableMap::COL_GRAPHIC_CONTENT, RecommendationTableMap::COL_SHORTLINK, RecommendationTableMap::COL_URL, RecommendationTableMap::COL_TITLE, RecommendationTableMap::COL_QUOTE, ),
        self::TYPE_RAW_COLNAME   => array('COL_RECOMMENDATION_ID', 'COL_CURATOR_ID', 'COL_RECOMMENDATION_HINT_ID', 'COL_CREATED_ON', 'COL_SCRAPED_ON', 'COL_APPROVED_ON', 'COL_GRAPHIC_CONTENT', 'COL_SHORTLINK', 'COL_URL', 'COL_TITLE', 'COL_QUOTE', ),
        self::TYPE_FIELDNAME     => array('recommendation_id', 'curator_id', 'recommendation_hint_id', 'created_on', 'scraped_on', 'approved_on', 'graphic_content', 'shortlink', 'url', 'title', 'quote', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('RecommendationId' => 0, 'CuratorId' => 1, 'RecommendationHintId' => 2, 'CreatedOn' => 3, 'ScrapedOn' => 4, 'ApprovedOn' => 5, 'GraphicContent' => 6, 'Shortlink' => 7, 'Url' => 8, 'Title' => 9, 'Quote' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('recommendationId' => 0, 'curatorId' => 1, 'recommendationHintId' => 2, 'createdOn' => 3, 'scrapedOn' => 4, 'approvedOn' => 5, 'graphicContent' => 6, 'shortlink' => 7, 'url' => 8, 'title' => 9, 'quote' => 10, ),
        self::TYPE_COLNAME       => array(RecommendationTableMap::COL_RECOMMENDATION_ID => 0, RecommendationTableMap::COL_CURATOR_ID => 1, RecommendationTableMap::COL_RECOMMENDATION_HINT_ID => 2, RecommendationTableMap::COL_CREATED_ON => 3, RecommendationTableMap::COL_SCRAPED_ON => 4, RecommendationTableMap::COL_APPROVED_ON => 5, RecommendationTableMap::COL_GRAPHIC_CONTENT => 6, RecommendationTableMap::COL_SHORTLINK => 7, RecommendationTableMap::COL_URL => 8, RecommendationTableMap::COL_TITLE => 9, RecommendationTableMap::COL_QUOTE => 10, ),
        self::TYPE_RAW_COLNAME   => array('COL_RECOMMENDATION_ID' => 0, 'COL_CURATOR_ID' => 1, 'COL_RECOMMENDATION_HINT_ID' => 2, 'COL_CREATED_ON' => 3, 'COL_SCRAPED_ON' => 4, 'COL_APPROVED_ON' => 5, 'COL_GRAPHIC_CONTENT' => 6, 'COL_SHORTLINK' => 7, 'COL_URL' => 8, 'COL_TITLE' => 9, 'COL_QUOTE' => 10, ),
        self::TYPE_FIELDNAME     => array('recommendation_id' => 0, 'curator_id' => 1, 'recommendation_hint_id' => 2, 'created_on' => 3, 'scraped_on' => 4, 'approved_on' => 5, 'graphic_content' => 6, 'shortlink' => 7, 'url' => 8, 'title' => 9, 'quote' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('recommendation');
        $this->setPhpName('Recommendation');
        $this->setClassName('\\justnyt\\models\\Recommendation');
        $this->setPackage('justnyt.models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('RECOMMENDATION_ID', 'RecommendationId', 'INTEGER', true, 10, null);
        $this->addForeignKey('CURATOR_ID', 'CuratorId', 'INTEGER', 'curator', 'CURATOR_ID', false, 10, null);
        $this->addForeignKey('RECOMMENDATION_HINT_ID', 'RecommendationHintId', 'INTEGER', 'recommendation_hint', 'RECOMMENDATION_HINT_ID', false, 10, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('SCRAPED_ON', 'ScrapedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('APPROVED_ON', 'ApprovedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('GRAPHIC_CONTENT', 'GraphicContent', 'BOOLEAN', false, 1, false);
        $this->addColumn('SHORTLINK', 'Shortlink', 'VARCHAR', false, 32, null);
        $this->addColumn('URL', 'Url', 'VARCHAR', false, 1024, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', false, 512, null);
        $this->addColumn('QUOTE', 'Quote', 'VARCHAR', false, 512, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Curator', '\\justnyt\\models\\Curator', RelationMap::MANY_TO_ONE, array('curator_id' => 'curator_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('RecommendationHint', '\\justnyt\\models\\RecommendationHint', RelationMap::MANY_TO_ONE, array('recommendation_hint_id' => 'recommendation_hint_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('Visit', '\\justnyt\\models\\Visit', RelationMap::ONE_TO_MANY, array('recommendation_id' => 'recommendation_id', ), 'CASCADE', 'CASCADE', 'Visits');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to recommendation     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        VisitTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RecommendationId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RecommendationId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('RecommendationId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RecommendationTableMap::CLASS_DEFAULT : RecommendationTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Recommendation object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RecommendationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RecommendationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RecommendationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RecommendationTableMap::OM_CLASS;
            /** @var Recommendation $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RecommendationTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RecommendationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RecommendationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Recommendation $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RecommendationTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RecommendationTableMap::COL_RECOMMENDATION_ID);
            $criteria->addSelectColumn(RecommendationTableMap::COL_CURATOR_ID);
            $criteria->addSelectColumn(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID);
            $criteria->addSelectColumn(RecommendationTableMap::COL_CREATED_ON);
            $criteria->addSelectColumn(RecommendationTableMap::COL_SCRAPED_ON);
            $criteria->addSelectColumn(RecommendationTableMap::COL_APPROVED_ON);
            $criteria->addSelectColumn(RecommendationTableMap::COL_GRAPHIC_CONTENT);
            $criteria->addSelectColumn(RecommendationTableMap::COL_SHORTLINK);
            $criteria->addSelectColumn(RecommendationTableMap::COL_URL);
            $criteria->addSelectColumn(RecommendationTableMap::COL_TITLE);
            $criteria->addSelectColumn(RecommendationTableMap::COL_QUOTE);
        } else {
            $criteria->addSelectColumn($alias . '.RECOMMENDATION_ID');
            $criteria->addSelectColumn($alias . '.CURATOR_ID');
            $criteria->addSelectColumn($alias . '.RECOMMENDATION_HINT_ID');
            $criteria->addSelectColumn($alias . '.CREATED_ON');
            $criteria->addSelectColumn($alias . '.SCRAPED_ON');
            $criteria->addSelectColumn($alias . '.APPROVED_ON');
            $criteria->addSelectColumn($alias . '.GRAPHIC_CONTENT');
            $criteria->addSelectColumn($alias . '.SHORTLINK');
            $criteria->addSelectColumn($alias . '.URL');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.QUOTE');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RecommendationTableMap::DATABASE_NAME)->getTable(RecommendationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RecommendationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RecommendationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RecommendationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Recommendation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Recommendation object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \justnyt\models\Recommendation) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RecommendationTableMap::DATABASE_NAME);
            $criteria->add(RecommendationTableMap::COL_RECOMMENDATION_ID, (array) $values, Criteria::IN);
        }

        $query = RecommendationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RecommendationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RecommendationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the recommendation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RecommendationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Recommendation or Criteria object.
     *
     * @param mixed               $criteria Criteria or Recommendation object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Recommendation object
        }

        if ($criteria->containsKey(RecommendationTableMap::COL_RECOMMENDATION_ID) && $criteria->keyContainsValue(RecommendationTableMap::COL_RECOMMENDATION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RecommendationTableMap::COL_RECOMMENDATION_ID.')');
        }


        // Set the correct dbName
        $query = RecommendationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RecommendationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RecommendationTableMap::buildTableMap();
