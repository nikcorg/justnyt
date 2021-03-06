<?php

namespace justnyt\models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use justnyt\models\Curator as ChildCurator;
use justnyt\models\CuratorQuery as ChildCuratorQuery;
use justnyt\models\Recommendation as ChildRecommendation;
use justnyt\models\RecommendationHint as ChildRecommendationHint;
use justnyt\models\RecommendationHintQuery as ChildRecommendationHintQuery;
use justnyt\models\RecommendationQuery as ChildRecommendationQuery;
use justnyt\models\Map\RecommendationHintTableMap;

/**
 * Base class that represents a row from the 'recommendation_hint' table.
 *
 *
 *
* @package    propel.generator.justnyt.models.Base
*/
abstract class RecommendationHint implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\justnyt\\models\\Map\\RecommendationHintTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the recommendation_hint_id field.
     * @var        int
     */
    protected $recommendation_hint_id;

    /**
     * The value for the created_on field.
     * @var        \DateTime
     */
    protected $created_on;

    /**
     * The value for the dropped_on field.
     * @var        \DateTime
     */
    protected $dropped_on;

    /**
     * The value for the dropped_by field.
     * @var        int
     */
    protected $dropped_by;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the alias field.
     * @var        string
     */
    protected $alias;

    /**
     * @var        ChildCurator
     */
    protected $aCurator;

    /**
     * @var        ObjectCollection|ChildRecommendation[] Collection to store aggregation of ChildRecommendation objects.
     */
    protected $collRecommendations;
    protected $collRecommendationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRecommendation[]
     */
    protected $recommendationsScheduledForDeletion = null;

    /**
     * Initializes internal state of justnyt\models\Base\RecommendationHint object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>RecommendationHint</code> instance.  If
     * <code>obj</code> is an instance of <code>RecommendationHint</code>, delegates to
     * <code>equals(RecommendationHint)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|RecommendationHint The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [recommendation_hint_id] column value.
     *
     * @return int
     */
    public function getRecommendationHintId()
    {
        return $this->recommendation_hint_id;
    }

    /**
     * Get the [optionally formatted] temporal [created_on] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedOn($format = NULL)
    {
        if ($format === null) {
            return $this->created_on;
        } else {
            return $this->created_on instanceof \DateTime ? $this->created_on->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dropped_on] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDroppedOn($format = NULL)
    {
        if ($format === null) {
            return $this->dropped_on;
        } else {
            return $this->dropped_on instanceof \DateTime ? $this->dropped_on->format($format) : null;
        }
    }

    /**
     * Get the [dropped_by] column value.
     *
     * @return int
     */
    public function getDroppedBy()
    {
        return $this->dropped_by;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [alias] column value.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RecommendationHintTableMap::translateFieldName('RecommendationHintId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->recommendation_hint_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RecommendationHintTableMap::translateFieldName('CreatedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RecommendationHintTableMap::translateFieldName('DroppedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dropped_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RecommendationHintTableMap::translateFieldName('DroppedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dropped_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RecommendationHintTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RecommendationHintTableMap::translateFieldName('Alias', TableMap::TYPE_PHPNAME, $indexType)];
            $this->alias = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = RecommendationHintTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\justnyt\\models\\RecommendationHint'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aCurator !== null && $this->dropped_by !== $this->aCurator->getCuratorId()) {
            $this->aCurator = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [recommendation_hint_id] column.
     *
     * @param  int $v new value
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setRecommendationHintId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->recommendation_hint_id !== $v) {
            $this->recommendation_hint_id = $v;
            $this->modifiedColumns[RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID] = true;
        }

        return $this;
    } // setRecommendationHintId()

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            if ($dt !== $this->created_on) {
                $this->created_on = $dt;
                $this->modifiedColumns[RecommendationHintTableMap::COL_CREATED_ON] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedOn()

    /**
     * Sets the value of [dropped_on] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setDroppedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dropped_on !== null || $dt !== null) {
            if ($dt !== $this->dropped_on) {
                $this->dropped_on = $dt;
                $this->modifiedColumns[RecommendationHintTableMap::COL_DROPPED_ON] = true;
            }
        } // if either are not null

        return $this;
    } // setDroppedOn()

    /**
     * Set the value of [dropped_by] column.
     *
     * @param  int $v new value
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setDroppedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->dropped_by !== $v) {
            $this->dropped_by = $v;
            $this->modifiedColumns[RecommendationHintTableMap::COL_DROPPED_BY] = true;
        }

        if ($this->aCurator !== null && $this->aCurator->getCuratorId() !== $v) {
            $this->aCurator = null;
        }

        return $this;
    } // setDroppedBy()

    /**
     * Set the value of [url] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[RecommendationHintTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[RecommendationHintTableMap::COL_ALIAS] = true;
        }

        return $this;
    } // setAlias()

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRecommendationHintQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCurator = null;
            $this->collRecommendations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see RecommendationHint::setDeleted()
     * @see RecommendationHint::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRecommendationHintQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationHintTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                RecommendationHintTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCurator !== null) {
                if ($this->aCurator->isModified() || $this->aCurator->isNew()) {
                    $affectedRows += $this->aCurator->save($con);
                }
                $this->setCurator($this->aCurator);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->recommendationsScheduledForDeletion !== null) {
                if (!$this->recommendationsScheduledForDeletion->isEmpty()) {
                    foreach ($this->recommendationsScheduledForDeletion as $recommendation) {
                        // need to save related object because we set the relation to null
                        $recommendation->save($con);
                    }
                    $this->recommendationsScheduledForDeletion = null;
                }
            }

            if ($this->collRecommendations !== null) {
                foreach ($this->collRecommendations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID] = true;
        if (null !== $this->recommendation_hint_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`RECOMMENDATION_HINT_ID`';
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_ON`';
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_DROPPED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`DROPPED_ON`';
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_DROPPED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`DROPPED_BY`';
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = '`URL`';
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`ALIAS`';
        }

        $sql = sprintf(
            'INSERT INTO `recommendation_hint` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`RECOMMENDATION_HINT_ID`':
                        $stmt->bindValue($identifier, $this->recommendation_hint_id, PDO::PARAM_INT);
                        break;
                    case '`CREATED_ON`':
                        $stmt->bindValue($identifier, $this->created_on ? $this->created_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`DROPPED_ON`':
                        $stmt->bindValue($identifier, $this->dropped_on ? $this->dropped_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`DROPPED_BY`':
                        $stmt->bindValue($identifier, $this->dropped_by, PDO::PARAM_INT);
                        break;
                    case '`URL`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case '`ALIAS`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setRecommendationHintId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RecommendationHintTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getRecommendationHintId();
                break;
            case 1:
                return $this->getCreatedOn();
                break;
            case 2:
                return $this->getDroppedOn();
                break;
            case 3:
                return $this->getDroppedBy();
                break;
            case 4:
                return $this->getUrl();
                break;
            case 5:
                return $this->getAlias();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['RecommendationHint'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['RecommendationHint'][$this->hashCode()] = true;
        $keys = RecommendationHintTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getRecommendationHintId(),
            $keys[1] => $this->getCreatedOn(),
            $keys[2] => $this->getDroppedOn(),
            $keys[3] => $this->getDroppedBy(),
            $keys[4] => $this->getUrl(),
            $keys[5] => $this->getAlias(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCurator) {

                switch ($keyType) {
                    case TableMap::TYPE_STUDLYPHPNAME:
                        $key = 'curator';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'curator';
                        break;
                    default:
                        $key = 'Curator';
                }

                $result[$key] = $this->aCurator->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRecommendations) {

                switch ($keyType) {
                    case TableMap::TYPE_STUDLYPHPNAME:
                        $key = 'recommendations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'recommendations';
                        break;
                    default:
                        $key = 'Recommendations';
                }

                $result[$key] = $this->collRecommendations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\justnyt\models\RecommendationHint
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RecommendationHintTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\justnyt\models\RecommendationHint
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setRecommendationHintId($value);
                break;
            case 1:
                $this->setCreatedOn($value);
                break;
            case 2:
                $this->setDroppedOn($value);
                break;
            case 3:
                $this->setDroppedBy($value);
                break;
            case 4:
                $this->setUrl($value);
                break;
            case 5:
                $this->setAlias($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = RecommendationHintTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setRecommendationHintId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCreatedOn($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDroppedOn($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDroppedBy($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUrl($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAlias($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\justnyt\models\RecommendationHint The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RecommendationHintTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID)) {
            $criteria->add(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $this->recommendation_hint_id);
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_CREATED_ON)) {
            $criteria->add(RecommendationHintTableMap::COL_CREATED_ON, $this->created_on);
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_DROPPED_ON)) {
            $criteria->add(RecommendationHintTableMap::COL_DROPPED_ON, $this->dropped_on);
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_DROPPED_BY)) {
            $criteria->add(RecommendationHintTableMap::COL_DROPPED_BY, $this->dropped_by);
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_URL)) {
            $criteria->add(RecommendationHintTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(RecommendationHintTableMap::COL_ALIAS)) {
            $criteria->add(RecommendationHintTableMap::COL_ALIAS, $this->alias);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(RecommendationHintTableMap::DATABASE_NAME);
        $criteria->add(RecommendationHintTableMap::COL_RECOMMENDATION_HINT_ID, $this->recommendation_hint_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getRecommendationHintId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getRecommendationHintId();
    }

    /**
     * Generic method to set the primary key (recommendation_hint_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setRecommendationHintId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getRecommendationHintId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \justnyt\models\RecommendationHint (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCreatedOn($this->getCreatedOn());
        $copyObj->setDroppedOn($this->getDroppedOn());
        $copyObj->setDroppedBy($this->getDroppedBy());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setAlias($this->getAlias());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRecommendations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRecommendation($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setRecommendationHintId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \justnyt\models\RecommendationHint Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildCurator object.
     *
     * @param  ChildCurator $v
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurator(ChildCurator $v = null)
    {
        if ($v === null) {
            $this->setDroppedBy(NULL);
        } else {
            $this->setDroppedBy($v->getCuratorId());
        }

        $this->aCurator = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCurator object, it will not be re-added.
        if ($v !== null) {
            $v->addRecommendationHint($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCurator object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCurator The associated ChildCurator object.
     * @throws PropelException
     */
    public function getCurator(ConnectionInterface $con = null)
    {
        if ($this->aCurator === null && ($this->dropped_by !== null)) {
            $this->aCurator = ChildCuratorQuery::create()->findPk($this->dropped_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCurator->addRecommendationHints($this);
             */
        }

        return $this->aCurator;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Recommendation' == $relationName) {
            return $this->initRecommendations();
        }
    }

    /**
     * Clears out the collRecommendations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRecommendations()
     */
    public function clearRecommendations()
    {
        $this->collRecommendations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRecommendations collection loaded partially.
     */
    public function resetPartialRecommendations($v = true)
    {
        $this->collRecommendationsPartial = $v;
    }

    /**
     * Initializes the collRecommendations collection.
     *
     * By default this just sets the collRecommendations collection to an empty array (like clearcollRecommendations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRecommendations($overrideExisting = true)
    {
        if (null !== $this->collRecommendations && !$overrideExisting) {
            return;
        }
        $this->collRecommendations = new ObjectCollection();
        $this->collRecommendations->setModel('\justnyt\models\Recommendation');
    }

    /**
     * Gets an array of ChildRecommendation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRecommendationHint is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRecommendation[] List of ChildRecommendation objects
     * @throws PropelException
     */
    public function getRecommendations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRecommendationsPartial && !$this->isNew();
        if (null === $this->collRecommendations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRecommendations) {
                // return empty collection
                $this->initRecommendations();
            } else {
                $collRecommendations = ChildRecommendationQuery::create(null, $criteria)
                    ->filterByRecommendationHint($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRecommendationsPartial && count($collRecommendations)) {
                        $this->initRecommendations(false);

                        foreach ($collRecommendations as $obj) {
                            if (false == $this->collRecommendations->contains($obj)) {
                                $this->collRecommendations->append($obj);
                            }
                        }

                        $this->collRecommendationsPartial = true;
                    }

                    return $collRecommendations;
                }

                if ($partial && $this->collRecommendations) {
                    foreach ($this->collRecommendations as $obj) {
                        if ($obj->isNew()) {
                            $collRecommendations[] = $obj;
                        }
                    }
                }

                $this->collRecommendations = $collRecommendations;
                $this->collRecommendationsPartial = false;
            }
        }

        return $this->collRecommendations;
    }

    /**
     * Sets a collection of ChildRecommendation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $recommendations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRecommendationHint The current object (for fluent API support)
     */
    public function setRecommendations(Collection $recommendations, ConnectionInterface $con = null)
    {
        /** @var ChildRecommendation[] $recommendationsToDelete */
        $recommendationsToDelete = $this->getRecommendations(new Criteria(), $con)->diff($recommendations);


        $this->recommendationsScheduledForDeletion = $recommendationsToDelete;

        foreach ($recommendationsToDelete as $recommendationRemoved) {
            $recommendationRemoved->setRecommendationHint(null);
        }

        $this->collRecommendations = null;
        foreach ($recommendations as $recommendation) {
            $this->addRecommendation($recommendation);
        }

        $this->collRecommendations = $recommendations;
        $this->collRecommendationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Recommendation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Recommendation objects.
     * @throws PropelException
     */
    public function countRecommendations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRecommendationsPartial && !$this->isNew();
        if (null === $this->collRecommendations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRecommendations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRecommendations());
            }

            $query = ChildRecommendationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRecommendationHint($this)
                ->count($con);
        }

        return count($this->collRecommendations);
    }

    /**
     * Method called to associate a ChildRecommendation object to this object
     * through the ChildRecommendation foreign key attribute.
     *
     * @param  ChildRecommendation $l ChildRecommendation
     * @return $this|\justnyt\models\RecommendationHint The current object (for fluent API support)
     */
    public function addRecommendation(ChildRecommendation $l)
    {
        if ($this->collRecommendations === null) {
            $this->initRecommendations();
            $this->collRecommendationsPartial = true;
        }

        if (!$this->collRecommendations->contains($l)) {
            $this->doAddRecommendation($l);
        }

        return $this;
    }

    /**
     * @param ChildRecommendation $recommendation The ChildRecommendation object to add.
     */
    protected function doAddRecommendation(ChildRecommendation $recommendation)
    {
        $this->collRecommendations[]= $recommendation;
        $recommendation->setRecommendationHint($this);
    }

    /**
     * @param  ChildRecommendation $recommendation The ChildRecommendation object to remove.
     * @return $this|ChildRecommendationHint The current object (for fluent API support)
     */
    public function removeRecommendation(ChildRecommendation $recommendation)
    {
        if ($this->getRecommendations()->contains($recommendation)) {
            $pos = $this->collRecommendations->search($recommendation);
            $this->collRecommendations->remove($pos);
            if (null === $this->recommendationsScheduledForDeletion) {
                $this->recommendationsScheduledForDeletion = clone $this->collRecommendations;
                $this->recommendationsScheduledForDeletion->clear();
            }
            $this->recommendationsScheduledForDeletion[]= $recommendation;
            $recommendation->setRecommendationHint(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this RecommendationHint is new, it will return
     * an empty collection; or if this RecommendationHint has previously
     * been saved, it will retrieve related Recommendations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in RecommendationHint.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRecommendation[] List of ChildRecommendation objects
     */
    public function getRecommendationsJoinCurator(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRecommendationQuery::create(null, $criteria);
        $query->joinWith('Curator', $joinBehavior);

        return $this->getRecommendations($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCurator) {
            $this->aCurator->removeRecommendationHint($this);
        }
        $this->recommendation_hint_id = null;
        $this->created_on = null;
        $this->dropped_on = null;
        $this->dropped_by = null;
        $this->url = null;
        $this->alias = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRecommendations) {
                foreach ($this->collRecommendations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRecommendations = null;
        $this->aCurator = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RecommendationHintTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
