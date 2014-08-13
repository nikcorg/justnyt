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
use justnyt\models\Profile;
use justnyt\models\ProfileQuery;


/**
 * This class defines the structure of the 'profile' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProfileTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'justnyt.models.Map.ProfileTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'justnyt';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'profile';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\justnyt\\models\\Profile';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'justnyt.models.Profile';

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
     * the column name for the PROFILE_ID field
     */
    const COL_PROFILE_ID = 'profile.PROFILE_ID';

    /**
     * the column name for the ALIAS field
     */
    const COL_ALIAS = 'profile.ALIAS';

    /**
     * the column name for the HOMEPAGE field
     */
    const COL_HOMEPAGE = 'profile.HOMEPAGE';

    /**
     * the column name for the EMAIL field
     */
    const COL_EMAIL = 'profile.EMAIL';

    /**
     * the column name for the IMAGE field
     */
    const COL_IMAGE = 'profile.IMAGE';

    /**
     * the column name for the DESCRIPTION field
     */
    const COL_DESCRIPTION = 'profile.DESCRIPTION';

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
        self::TYPE_PHPNAME       => array('ProfileId', 'Alias', 'Homepage', 'Email', 'Image', 'Description', ),
        self::TYPE_STUDLYPHPNAME => array('profileId', 'alias', 'homepage', 'email', 'image', 'description', ),
        self::TYPE_COLNAME       => array(ProfileTableMap::COL_PROFILE_ID, ProfileTableMap::COL_ALIAS, ProfileTableMap::COL_HOMEPAGE, ProfileTableMap::COL_EMAIL, ProfileTableMap::COL_IMAGE, ProfileTableMap::COL_DESCRIPTION, ),
        self::TYPE_RAW_COLNAME   => array('COL_PROFILE_ID', 'COL_ALIAS', 'COL_HOMEPAGE', 'COL_EMAIL', 'COL_IMAGE', 'COL_DESCRIPTION', ),
        self::TYPE_FIELDNAME     => array('profile_id', 'alias', 'homepage', 'email', 'image', 'description', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ProfileId' => 0, 'Alias' => 1, 'Homepage' => 2, 'Email' => 3, 'Image' => 4, 'Description' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('profileId' => 0, 'alias' => 1, 'homepage' => 2, 'email' => 3, 'image' => 4, 'description' => 5, ),
        self::TYPE_COLNAME       => array(ProfileTableMap::COL_PROFILE_ID => 0, ProfileTableMap::COL_ALIAS => 1, ProfileTableMap::COL_HOMEPAGE => 2, ProfileTableMap::COL_EMAIL => 3, ProfileTableMap::COL_IMAGE => 4, ProfileTableMap::COL_DESCRIPTION => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_PROFILE_ID' => 0, 'COL_ALIAS' => 1, 'COL_HOMEPAGE' => 2, 'COL_EMAIL' => 3, 'COL_IMAGE' => 4, 'COL_DESCRIPTION' => 5, ),
        self::TYPE_FIELDNAME     => array('profile_id' => 0, 'alias' => 1, 'homepage' => 2, 'email' => 3, 'image' => 4, 'description' => 5, ),
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
        $this->setName('profile');
        $this->setPhpName('Profile');
        $this->setClassName('\\justnyt\\models\\Profile');
        $this->setPackage('justnyt.models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PROFILE_ID', 'ProfileId', 'INTEGER', true, 10, null);
        $this->addColumn('ALIAS', 'Alias', 'VARCHAR', true, 80, null);
        $this->addColumn('HOMEPAGE', 'Homepage', 'VARCHAR', false, 255, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('IMAGE', 'Image', 'VARCHAR', false, 40, null);
        $this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Curator', '\\justnyt\\models\\Curator', RelationMap::ONE_TO_MANY, array('profile_id' => 'profile_id', ), 'SET NULL', 'CASCADE', 'Curators');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to profile     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CuratorTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProfileId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProfileId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('ProfileId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ProfileTableMap::CLASS_DEFAULT : ProfileTableMap::OM_CLASS;
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
     * @return array           (Profile object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProfileTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProfileTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProfileTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProfileTableMap::OM_CLASS;
            /** @var Profile $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProfileTableMap::addInstanceToPool($obj, $key);
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
            $key = ProfileTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProfileTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Profile $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProfileTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProfileTableMap::COL_PROFILE_ID);
            $criteria->addSelectColumn(ProfileTableMap::COL_ALIAS);
            $criteria->addSelectColumn(ProfileTableMap::COL_HOMEPAGE);
            $criteria->addSelectColumn(ProfileTableMap::COL_EMAIL);
            $criteria->addSelectColumn(ProfileTableMap::COL_IMAGE);
            $criteria->addSelectColumn(ProfileTableMap::COL_DESCRIPTION);
        } else {
            $criteria->addSelectColumn($alias . '.PROFILE_ID');
            $criteria->addSelectColumn($alias . '.ALIAS');
            $criteria->addSelectColumn($alias . '.HOMEPAGE');
            $criteria->addSelectColumn($alias . '.EMAIL');
            $criteria->addSelectColumn($alias . '.IMAGE');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProfileTableMap::DATABASE_NAME)->getTable(ProfileTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProfileTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ProfileTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ProfileTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Profile or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Profile object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProfileTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \justnyt\models\Profile) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProfileTableMap::DATABASE_NAME);
            $criteria->add(ProfileTableMap::COL_PROFILE_ID, (array) $values, Criteria::IN);
        }

        $query = ProfileQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ProfileTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ProfileTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the profile table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProfileQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Profile or Criteria object.
     *
     * @param mixed               $criteria Criteria or Profile object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProfileTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Profile object
        }

        if ($criteria->containsKey(ProfileTableMap::COL_PROFILE_ID) && $criteria->keyContainsValue(ProfileTableMap::COL_PROFILE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProfileTableMap::COL_PROFILE_ID.')');
        }


        // Set the correct dbName
        $query = ProfileQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ProfileTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProfileTableMap::buildTableMap();
