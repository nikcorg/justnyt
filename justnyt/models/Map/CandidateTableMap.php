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
use justnyt\models\Candidate;
use justnyt\models\CandidateQuery;


/**
 * This class defines the structure of the 'candidate' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CandidateTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'justnyt.models.Map.CandidateTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'justnyt';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'candidate';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\justnyt\\models\\Candidate';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'justnyt.models.Candidate';

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
     * the column name for the CANDIDATE_ID field
     */
    const COL_CANDIDATE_ID = 'candidate.CANDIDATE_ID';

    /**
     * the column name for the CREATED_ON field
     */
    const COL_CREATED_ON = 'candidate.CREATED_ON';

    /**
     * the column name for the INVITED_ON field
     */
    const COL_INVITED_ON = 'candidate.INVITED_ON';

    /**
     * the column name for the INVITE_REDACTED_ON field
     */
    const COL_INVITE_REDACTED_ON = 'candidate.INVITE_REDACTED_ON';

    /**
     * the column name for the INVITES_SENT field
     */
    const COL_INVITES_SENT = 'candidate.INVITES_SENT';

    /**
     * the column name for the EMAIL field
     */
    const COL_EMAIL = 'candidate.EMAIL';

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
        self::TYPE_PHPNAME       => array('CandidateId', 'CreatedOn', 'InvitedOn', 'InviteRedactedOn', 'InvitesSent', 'Email', ),
        self::TYPE_STUDLYPHPNAME => array('candidateId', 'createdOn', 'invitedOn', 'inviteRedactedOn', 'invitesSent', 'email', ),
        self::TYPE_COLNAME       => array(CandidateTableMap::COL_CANDIDATE_ID, CandidateTableMap::COL_CREATED_ON, CandidateTableMap::COL_INVITED_ON, CandidateTableMap::COL_INVITE_REDACTED_ON, CandidateTableMap::COL_INVITES_SENT, CandidateTableMap::COL_EMAIL, ),
        self::TYPE_RAW_COLNAME   => array('COL_CANDIDATE_ID', 'COL_CREATED_ON', 'COL_INVITED_ON', 'COL_INVITE_REDACTED_ON', 'COL_INVITES_SENT', 'COL_EMAIL', ),
        self::TYPE_FIELDNAME     => array('candidate_id', 'created_on', 'invited_on', 'invite_redacted_on', 'invites_sent', 'email', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('CandidateId' => 0, 'CreatedOn' => 1, 'InvitedOn' => 2, 'InviteRedactedOn' => 3, 'InvitesSent' => 4, 'Email' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('candidateId' => 0, 'createdOn' => 1, 'invitedOn' => 2, 'inviteRedactedOn' => 3, 'invitesSent' => 4, 'email' => 5, ),
        self::TYPE_COLNAME       => array(CandidateTableMap::COL_CANDIDATE_ID => 0, CandidateTableMap::COL_CREATED_ON => 1, CandidateTableMap::COL_INVITED_ON => 2, CandidateTableMap::COL_INVITE_REDACTED_ON => 3, CandidateTableMap::COL_INVITES_SENT => 4, CandidateTableMap::COL_EMAIL => 5, ),
        self::TYPE_RAW_COLNAME   => array('COL_CANDIDATE_ID' => 0, 'COL_CREATED_ON' => 1, 'COL_INVITED_ON' => 2, 'COL_INVITE_REDACTED_ON' => 3, 'COL_INVITES_SENT' => 4, 'COL_EMAIL' => 5, ),
        self::TYPE_FIELDNAME     => array('candidate_id' => 0, 'created_on' => 1, 'invited_on' => 2, 'invite_redacted_on' => 3, 'invites_sent' => 4, 'email' => 5, ),
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
        $this->setName('candidate');
        $this->setPhpName('Candidate');
        $this->setClassName('\\justnyt\\models\\Candidate');
        $this->setPackage('justnyt.models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('CANDIDATE_ID', 'CandidateId', 'INTEGER', true, 10, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', true, null, null);
        $this->addColumn('INVITED_ON', 'InvitedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('INVITE_REDACTED_ON', 'InviteRedactedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('INVITES_SENT', 'InvitesSent', 'INTEGER', false, 10, 0);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', true, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Curator', '\\justnyt\\models\\Curator', RelationMap::ONE_TO_MANY, array('candidate_id' => 'candidate_id', ), 'SET NULL', 'CASCADE', 'Curators');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to candidate     * by a foreign key with ON DELETE CASCADE
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CandidateId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CandidateId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('CandidateId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CandidateTableMap::CLASS_DEFAULT : CandidateTableMap::OM_CLASS;
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
     * @return array           (Candidate object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CandidateTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CandidateTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CandidateTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CandidateTableMap::OM_CLASS;
            /** @var Candidate $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CandidateTableMap::addInstanceToPool($obj, $key);
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
            $key = CandidateTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CandidateTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Candidate $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CandidateTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CandidateTableMap::COL_CANDIDATE_ID);
            $criteria->addSelectColumn(CandidateTableMap::COL_CREATED_ON);
            $criteria->addSelectColumn(CandidateTableMap::COL_INVITED_ON);
            $criteria->addSelectColumn(CandidateTableMap::COL_INVITE_REDACTED_ON);
            $criteria->addSelectColumn(CandidateTableMap::COL_INVITES_SENT);
            $criteria->addSelectColumn(CandidateTableMap::COL_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.CANDIDATE_ID');
            $criteria->addSelectColumn($alias . '.CREATED_ON');
            $criteria->addSelectColumn($alias . '.INVITED_ON');
            $criteria->addSelectColumn($alias . '.INVITE_REDACTED_ON');
            $criteria->addSelectColumn($alias . '.INVITES_SENT');
            $criteria->addSelectColumn($alias . '.EMAIL');
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
        return Propel::getServiceContainer()->getDatabaseMap(CandidateTableMap::DATABASE_NAME)->getTable(CandidateTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CandidateTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CandidateTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CandidateTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Candidate or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Candidate object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \justnyt\models\Candidate) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CandidateTableMap::DATABASE_NAME);
            $criteria->add(CandidateTableMap::COL_CANDIDATE_ID, (array) $values, Criteria::IN);
        }

        $query = CandidateQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CandidateTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CandidateTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the candidate table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CandidateQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Candidate or Criteria object.
     *
     * @param mixed               $criteria Criteria or Candidate object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CandidateTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Candidate object
        }

        if ($criteria->containsKey(CandidateTableMap::COL_CANDIDATE_ID) && $criteria->keyContainsValue(CandidateTableMap::COL_CANDIDATE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CandidateTableMap::COL_CANDIDATE_ID.')');
        }


        // Set the correct dbName
        $query = CandidateQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CandidateTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CandidateTableMap::buildTableMap();
