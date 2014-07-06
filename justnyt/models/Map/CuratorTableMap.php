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
use justnyt\models\Curator;
use justnyt\models\CuratorQuery;


/**
 * This class defines the structure of the 'curator' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CuratorTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'justnyt.models.Map.CuratorTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'justnyt';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'curator';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\justnyt\\models\\Curator';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'justnyt.models.Curator';

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
     * the column name for the CURATOR_ID field
     */
    const COL_CURATOR_ID = 'curator.CURATOR_ID';

    /**
     * the column name for the CANDIDATE_ID field
     */
    const COL_CANDIDATE_ID = 'curator.CANDIDATE_ID';

    /**
     * the column name for the PROFILE_ID field
     */
    const COL_PROFILE_ID = 'curator.PROFILE_ID';

    /**
     * the column name for the TOKEN field
     */
    const COL_TOKEN = 'curator.TOKEN';

    /**
     * the column name for the CREATED_ON field
     */
    const COL_CREATED_ON = 'curator.CREATED_ON';

    /**
     * the column name for the ACTIVATED_ON field
     */
    const COL_ACTIVATED_ON = 'curator.ACTIVATED_ON';

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
        self::TYPE_PHPNAME       => array('CuratorId', 'CandidateId', 'ProfileId', 'Token', 'CreatedOn', 'ActivatedOn', ),
        self::TYPE_STUDLYPHPNAME => array('curatorId', 'candidateId', 'profileId', 'token', 'createdOn', 'activatedOn', ),
        self::TYPE_COLNAME       => array(CuratorTableMap::COL_CURATOR_ID, CuratorTableMap::COL_CANDIDATE_ID, CuratorTableMap::COL_PROFILE_ID, CuratorTableMap::COL_TOKEN, CuratorTableMap::COL_CREATED_ON, CuratorTableMap::COL_ACTIVATED_ON, ),
        self::TYPE_RAW_COLNAME   => array('COL_CURATOR_ID', 'COL_CANDIDATE_ID', 'COL_PROFILE_ID', 'COL_TOKEN', 'COL_CREATED_ON', 'COL_ACTIVATED_ON', ),
        self::TYPE_FIELDNAME     => array('curator_id', 'candidate_id', 'profile_id', 'token', 'created_on', 'activated_on', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('CuratorId' => 0, 'CandidateId' => 1, 'ProfileId' => 2, 'Token' => 3, 'CreatedOn' => 4, 'ActivatedOn' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('curatorId' => 0, 'candidateId' => 1, 'profileId' => 2, 'token' => 3, 'createdOn' => 4, 'activatedOn' => 5, ),
        self::TYPE_COLNAME       => array(CuratorTableMap::COL_CURATOR_ID => 0, CuratorTableMap::COL_CANDIDATE_ID => 1, CuratorTableMap::COL_PROFILE_ID => 2, CuratorTableMap::COL_TOKEN => 3, CuratorTableMap::COL_CREATED_ON => 4, CuratorTableMap::COL_ACTIVATED_ON => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_CURATOR_ID' => 0, 'COL_CANDIDATE_ID' => 1, 'COL_PROFILE_ID' => 2, 'COL_TOKEN' => 3, 'COL_CREATED_ON' => 4, 'COL_ACTIVATED_ON' => 5, ),
        self::TYPE_FIELDNAME     => array('curator_id' => 0, 'candidate_id' => 1, 'profile_id' => 2, 'token' => 3, 'created_on' => 4, 'activated_on' => 5, ),
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
        $this->setName('curator');
        $this->setPhpName('Curator');
        $this->setClassName('\\justnyt\\models\\Curator');
        $this->setPackage('justnyt.models');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('CURATOR_ID', 'CuratorId', 'INTEGER', true, 10, null);
        $this->addForeignKey('CANDIDATE_ID', 'CandidateId', 'INTEGER', 'candidate', 'CANDIDATE_ID', false, 10, null);
        $this->addForeignKey('PROFILE_ID', 'ProfileId', 'INTEGER', 'profile', 'PROFILE_ID', false, 10, null);
        $this->addColumn('TOKEN', 'Token', 'VARCHAR', true, 32, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('ACTIVATED_ON', 'ActivatedOn', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Candidate', '\\justnyt\\models\\Candidate', RelationMap::MANY_TO_ONE, array('candidate_id' => 'candidate_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('Profile', '\\justnyt\\models\\Profile', RelationMap::MANY_TO_ONE, array('profile_id' => 'profile_id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('Recommendation', '\\justnyt\\models\\Recommendation', RelationMap::ONE_TO_MANY, array('curator_id' => 'curator_id', ), 'SET NULL', 'CASCADE', 'Recommendations');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to curator     * by a foreign key with ON DELETE CASCADE
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CuratorId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CuratorId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('CuratorId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CuratorTableMap::CLASS_DEFAULT : CuratorTableMap::OM_CLASS;
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
     * @return array           (Curator object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CuratorTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CuratorTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CuratorTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CuratorTableMap::OM_CLASS;
            /** @var Curator $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CuratorTableMap::addInstanceToPool($obj, $key);
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
            $key = CuratorTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CuratorTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Curator $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CuratorTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CuratorTableMap::COL_CURATOR_ID);
            $criteria->addSelectColumn(CuratorTableMap::COL_CANDIDATE_ID);
            $criteria->addSelectColumn(CuratorTableMap::COL_PROFILE_ID);
            $criteria->addSelectColumn(CuratorTableMap::COL_TOKEN);
            $criteria->addSelectColumn(CuratorTableMap::COL_CREATED_ON);
            $criteria->addSelectColumn(CuratorTableMap::COL_ACTIVATED_ON);
        } else {
            $criteria->addSelectColumn($alias . '.CURATOR_ID');
            $criteria->addSelectColumn($alias . '.CANDIDATE_ID');
            $criteria->addSelectColumn($alias . '.PROFILE_ID');
            $criteria->addSelectColumn($alias . '.TOKEN');
            $criteria->addSelectColumn($alias . '.CREATED_ON');
            $criteria->addSelectColumn($alias . '.ACTIVATED_ON');
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
        return Propel::getServiceContainer()->getDatabaseMap(CuratorTableMap::DATABASE_NAME)->getTable(CuratorTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CuratorTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CuratorTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CuratorTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Curator or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Curator object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CuratorTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \justnyt\models\Curator) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CuratorTableMap::DATABASE_NAME);
            $criteria->add(CuratorTableMap::COL_CURATOR_ID, (array) $values, Criteria::IN);
        }

        $query = CuratorQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CuratorTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CuratorTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the curator table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CuratorQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Curator or Criteria object.
     *
     * @param mixed               $criteria Criteria or Curator object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CuratorTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Curator object
        }


        // Set the correct dbName
        $query = CuratorQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CuratorTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CuratorTableMap::buildTableMap();
