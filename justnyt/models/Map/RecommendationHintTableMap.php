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
use justnyt\models\RecommendationHint;
use justnyt\models\RecommendationHintQuery;


/**
 * This class defines the structure of the 'recommendation_hint' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RecommendationHintTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'justnyt.models.Map.RecommendationHintTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'justnyt';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'recommendation_hint';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\justnyt\\models\\RecommendationHint';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'justnyt.models.RecommendationHint';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the RECOMMENDATION_HINT_ID field
     */
    const COL_RECOMMENDATION_HINT_ID = 'recommendation_hint.RECOMMENDATION_HINT_ID';

    /**
     * the column name for the CREATED_ON field
     */
    const COL_CREATED_ON = 'recommendation_hint.CREATED_ON';

    /**
     * the column name for the DROPPED_ON field
     */
    const COL_DROPPED_ON = 'recommendation_hint.DROPPED_ON';

    /**
     * the column name for the DROPPED_BY field
     */
    const COL_DROPPED_BY = 'recommendation_hint.DROPPED_BY';

    /**
     * the column name for the URL field
     */
    const COL_URL = 'recommendation_hint.URL';

    /**
     * the column name for the ALIAS field
     */
    const COL_ALIAS = 'recommendation_hint.ALIAS';

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
        self::TYPE_PHPNAME       => array('RecommendationHintId', 'CreatedOn', 'DroppedOn', 'DroppedBy', 'Url', 'Alias', ),
        self::TYPE_STUDLYPHPNAME => array('recommendationHintId', 'createdOn', 'droppedOn', 'droppedBy', 'url', 'alias', ),
        self::TYPE_COLNAME       => array(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, RecommendationHintTableMap::COL_CREATED_ON, RecommendationHintTableMap::COL_DROPPED_ON, RecommendationHintTableMap::COL_DROPPED_BY, RecommendationHintTableMap::COL_URL, RecommendationHintTableMap::COL_ALIAS, ),
        self::TYPE_RAW_COLNAME   => array('COL_RECOMMENDATION_HINT_ID', 'COL_CREATED_ON', 'COL_DROPPED_ON', 'COL_DROPPED_BY', 'COL_URL', 'COL_ALIAS', ),
        self::TYPE_FIELDNAME     => array('recommendation_hint_id', 'created_on', 'dropped_on', 'dropped_by', 'url', 'alias', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('RecommendationHintId' => 0, 'CreatedOn' => 1, 'DroppedOn' => 2, 'DroppedBy' => 3, 'Url' => 4, 'Alias' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('recommendationHintId' => 0, 'createdOn' => 1, 'droppedOn' => 2, 'droppedBy' => 3, 'url' => 4, 'alias' => 5, ),
        self::TYPE_COLNAME       => array(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID => 0, RecommendationHintTableMap::COL_CREATED_ON => 1, RecommendationHintTableMap::COL_DROPPED_ON => 2, RecommendationHintTableMap::COL_DROPPED_BY => 3, RecommendationHintTableMap::COL_URL => 4, RecommendationHintTableMap::COL_ALIAS => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_RECOMMENDATION_HINT_ID' => 0, 'COL_CREATED_ON' => 1, 'COL_DROPPED_ON' => 2, 'COL_DROPPED_BY' => 3, 'COL_URL' => 4, 'COL_ALIAS' => 5, ),
        self::TYPE_FIELDNAME     => array('recommendation_hint_id' => 0, 'created_on' => 1, 'dropped_on' => 2, 'dropped_by' => 3, 'url' => 4, 'alias' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('recommendation_hint');
        $this->setPhpName('RecommendationHint');
        $this->setClassName('\\justnyt\\models\\RecommendationHint');
        $this->setPackage('justnyt.models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('RECOMMENDATION_HINT_ID', 'RecommendationHintId', 'INTEGER', true, 10, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('DROPPED_ON', 'DroppedOn', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('DROPPED_BY', 'DroppedBy', 'INTEGER', 'curator', 'CURATOR_ID', false, 10, null);
        $this->addColumn('URL', 'Url', 'VARCHAR', true, 1024, null);
        $this->addColumn('ALIAS', 'Alias', 'VARCHAR', false, 50, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Curator', '\\justnyt\\models\\Curator', RelationMap::MANY_TO_ONE, array('dropped_by' => 'curator_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('Recommendation', '\\justnyt\\models\\Recommendation', RelationMap::ONE_TO_MANY, array('recommendation_hint_id' => 'recommendation_hint_id', ), 'SET NULL', 'CASCADE', 'Recommendations');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to recommendation_hint     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RecommendationTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RecommendationHintId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('RecommendationHintId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('RecommendationHintId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? RecommendationHintTableMap::CLASS_DEFAULT : RecommendationHintTableMap::OM_CLASS;
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
     * @return array           (RecommendationHint object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RecommendationHintTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RecommendationHintTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RecommendationHintTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RecommendationHintTableMap::OM_CLASS;
            /** @var RecommendationHint $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RecommendationHintTableMap::addInstanceToPool($obj, $key);
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
            $key = RecommendationHintTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RecommendationHintTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RecommendationHint $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RecommendationHintTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID);
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_CREATED_ON);
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_DROPPED_ON);
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_DROPPED_BY);
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_URL);
            $criteria->addSelectColumn(RecommendationHintTableMap::COL_ALIAS);
        } else {
            $criteria->addSelectColumn($alias . '.RECOMMENDATION_HINT_ID');
            $criteria->addSelectColumn($alias . '.CREATED_ON');
            $criteria->addSelectColumn($alias . '.DROPPED_ON');
            $criteria->addSelectColumn($alias . '.DROPPED_BY');
            $criteria->addSelectColumn($alias . '.URL');
            $criteria->addSelectColumn($alias . '.ALIAS');
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
        return Propel::getServiceContainer()->getDatabaseMap(RecommendationHintTableMap::DATABASE_NAME)->getTable(RecommendationHintTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RecommendationHintTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RecommendationHintTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RecommendationHintTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RecommendationHint or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RecommendationHint object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \justnyt\models\RecommendationHint) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RecommendationHintTableMap::DATABASE_NAME);
            $criteria->add(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, (array) $values, Criteria::IN);
        }

        $query = RecommendationHintQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RecommendationHintTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RecommendationHintTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the recommendation_hint table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RecommendationHintQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RecommendationHint or Criteria object.
     *
     * @param mixed               $criteria Criteria or RecommendationHint object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RecommendationHint object
        }

        if ($criteria->containsKey(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID) && $criteria->keyContainsValue(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID.')');
        }


        // Set the correct dbName
        $query = RecommendationHintQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RecommendationHintTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RecommendationHintTableMap::buildTableMap();
