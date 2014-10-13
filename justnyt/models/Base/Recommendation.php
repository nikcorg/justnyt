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
use justnyt\models\Visit as ChildVisit;
use justnyt\models\VisitQuery as ChildVisitQuery;
use justnyt\models\Map\RecommendationTableMap;

/**
 * Base class that represents a row from the 'recommendation' table.
 *
 *
 *
* @package    propel.generator.justnyt.models.Base
*/
abstract class Recommendation implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\justnyt\\models\\Map\\RecommendationTableMap';


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
     * The value for the recommendation_id field.
     * @var        int
     */
    protected $recommendation_id;

    /**
     * The value for the curator_id field.
     * @var        int
     */
    protected $curator_id;

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
     * The value for the scraped_on field.
     * @var        \DateTime
     */
    protected $scraped_on;

    /**
     * The value for the approved_on field.
     * @var        \DateTime
     */
    protected $approved_on;

    /**
     * The value for the graphic_content field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $graphic_content;

    /**
     * The value for the shortlink field.
     * @var        string
     */
    protected $shortlink;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the quote field.
     * @var        string
     */
    protected $quote;

    /**
     * @var        ChildCurator
     */
    protected $aCurator;

    /**
     * @var        ChildRecommendationHint
     */
    protected $aRecommendationHint;

    /**
     * @var        ObjectCollection|ChildVisit[] Collection to store aggregation of ChildVisit objects.
     */
    protected $collVisits;
    protected $collVisitsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVisit[]
     */
    protected $visitsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->graphic_content = false;
    }

    /**
     * Initializes internal state of justnyt\models\Base\Recommendation object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Recommendation</code> instance.  If
     * <code>obj</code> is an instance of <code>Recommendation</code>, delegates to
     * <code>equals(Recommendation)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Recommendation The current object, for fluid interface
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
     * Get the [recommendation_id] column value.
     *
     * @return int
     */
    public function getRecommendationId()
    {
        return $this->recommendation_id;
    }

    /**
     * Get the [curator_id] column value.
     *
     * @return int
     */
    public function getCuratorId()
    {
        return $this->curator_id;
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
     * Get the [optionally formatted] temporal [scraped_on] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getScrapedOn($format = NULL)
    {
        if ($format === null) {
            return $this->scraped_on;
        } else {
            return $this->scraped_on instanceof \DateTime ? $this->scraped_on->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [approved_on] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getApprovedOn($format = NULL)
    {
        if ($format === null) {
            return $this->approved_on;
        } else {
            return $this->approved_on instanceof \DateTime ? $this->approved_on->format($format) : null;
        }
    }

    /**
     * Get the [graphic_content] column value.
     *
     * @return boolean
     */
    public function getGraphicContent()
    {
        return $this->graphic_content;
    }

    /**
     * Get the [graphic_content] column value.
     *
     * @return boolean
     */
    public function isGraphicContent()
    {
        return $this->getGraphicContent();
    }

    /**
     * Get the [shortlink] column value.
     *
     * @return string
     */
    public function getShortlink()
    {
        return $this->shortlink;
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
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [quote] column value.
     *
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
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
            if ($this->graphic_content !== false) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RecommendationTableMap::translateFieldName('RecommendationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->recommendation_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RecommendationTableMap::translateFieldName('CuratorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->curator_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RecommendationTableMap::translateFieldName('RecommendationHintId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->recommendation_hint_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RecommendationTableMap::translateFieldName('CreatedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RecommendationTableMap::translateFieldName('ScrapedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->scraped_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RecommendationTableMap::translateFieldName('ApprovedOn', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->approved_on = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : RecommendationTableMap::translateFieldName('GraphicContent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->graphic_content = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : RecommendationTableMap::translateFieldName('Shortlink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shortlink = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : RecommendationTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : RecommendationTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : RecommendationTableMap::translateFieldName('Quote', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quote = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = RecommendationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\justnyt\\models\\Recommendation'), 0, $e);
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
        if ($this->aCurator !== null && $this->curator_id !== $this->aCurator->getCuratorId()) {
            $this->aCurator = null;
        }
        if ($this->aRecommendationHint !== null && $this->recommendation_hint_id !== $this->aRecommendationHint->getRecommendationHintId()) {
            $this->aRecommendationHint = null;
        }
    } // ensureConsistency

    /**
     * Set the value of [recommendation_id] column.
     *
     * @param  int $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setRecommendationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->recommendation_id !== $v) {
            $this->recommendation_id = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_RECOMMENDATION_ID] = true;
        }

        return $this;
    } // setRecommendationId()

    /**
     * Set the value of [curator_id] column.
     *
     * @param  int $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setCuratorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->curator_id !== $v) {
            $this->curator_id = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_CURATOR_ID] = true;
        }

        if ($this->aCurator !== null && $this->aCurator->getCuratorId() !== $v) {
            $this->aCurator = null;
        }

        return $this;
    } // setCuratorId()

    /**
     * Set the value of [recommendation_hint_id] column.
     *
     * @param  int $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setRecommendationHintId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->recommendation_hint_id !== $v) {
            $this->recommendation_hint_id = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_RECOMMENDATION_HINT_ID] = true;
        }

        if ($this->aRecommendationHint !== null && $this->aRecommendationHint->getRecommendationHintId() !== $v) {
            $this->aRecommendationHint = null;
        }

        return $this;
    } // setRecommendationHintId()

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            if ($dt !== $this->created_on) {
                $this->created_on = $dt;
                $this->modifiedColumns[RecommendationTableMap::COL_CREATED_ON] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedOn()

    /**
     * Sets the value of [scraped_on] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setScrapedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->scraped_on !== null || $dt !== null) {
            if ($dt !== $this->scraped_on) {
                $this->scraped_on = $dt;
                $this->modifiedColumns[RecommendationTableMap::COL_SCRAPED_ON] = true;
            }
        } // if either are not null

        return $this;
    } // setScrapedOn()

    /**
     * Sets the value of [approved_on] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setApprovedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->approved_on !== null || $dt !== null) {
            if ($dt !== $this->approved_on) {
                $this->approved_on = $dt;
                $this->modifiedColumns[RecommendationTableMap::COL_APPROVED_ON] = true;
            }
        } // if either are not null

        return $this;
    } // setApprovedOn()

    /**
     * Sets the value of the [graphic_content] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setGraphicContent($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->graphic_content !== $v) {
            $this->graphic_content = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_GRAPHIC_CONTENT] = true;
        }

        return $this;
    } // setGraphicContent()

    /**
     * Set the value of [shortlink] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setShortlink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shortlink !== $v) {
            $this->shortlink = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_SHORTLINK] = true;
        }

        return $this;
    } // setShortlink()

    /**
     * Set the value of [url] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Set the value of [title] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [quote] column.
     *
     * @param  string $v new value
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function setQuote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->quote !== $v) {
            $this->quote = $v;
            $this->modifiedColumns[RecommendationTableMap::COL_QUOTE] = true;
        }

        return $this;
    } // setQuote()

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
            $con = Propel::getServiceContainer()->getReadConnection(RecommendationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRecommendationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCurator = null;
            $this->aRecommendationHint = null;
            $this->collVisits = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Recommendation::setDeleted()
     * @see Recommendation::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRecommendationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RecommendationTableMap::DATABASE_NAME);
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
                RecommendationTableMap::addInstanceToPool($this);
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

            if ($this->aRecommendationHint !== null) {
                if ($this->aRecommendationHint->isModified() || $this->aRecommendationHint->isNew()) {
                    $affectedRows += $this->aRecommendationHint->save($con);
                }
                $this->setRecommendationHint($this->aRecommendationHint);
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

            if ($this->visitsScheduledForDeletion !== null) {
                if (!$this->visitsScheduledForDeletion->isEmpty()) {
                    \justnyt\models\VisitQuery::create()
                        ->filterByPrimaryKeys($this->visitsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->visitsScheduledForDeletion = null;
                }
            }

            if ($this->collVisits !== null) {
                foreach ($this->collVisits as $referrerFK) {
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

        $this->modifiedColumns[RecommendationTableMap::COL_RECOMMENDATION_ID] = true;
        if (null !== $this->recommendation_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RecommendationTableMap::COL_RECOMMENDATION_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RecommendationTableMap::COL_RECOMMENDATION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`RECOMMENDATION_ID`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_CURATOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '`CURATOR_ID`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`RECOMMENDATION_HINT_ID`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_ON`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_SCRAPED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`SCRAPED_ON`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_APPROVED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`APPROVED_ON`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_GRAPHIC_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`GRAPHIC_CONTENT`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_SHORTLINK)) {
            $modifiedColumns[':p' . $index++]  = '`SHORTLINK`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = '`URL`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`TITLE`';
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_QUOTE)) {
            $modifiedColumns[':p' . $index++]  = '`QUOTE`';
        }

        $sql = sprintf(
            'INSERT INTO `recommendation` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`RECOMMENDATION_ID`':
                        $stmt->bindValue($identifier, $this->recommendation_id, PDO::PARAM_INT);
                        break;
                    case '`CURATOR_ID`':
                        $stmt->bindValue($identifier, $this->curator_id, PDO::PARAM_INT);
                        break;
                    case '`RECOMMENDATION_HINT_ID`':
                        $stmt->bindValue($identifier, $this->recommendation_hint_id, PDO::PARAM_INT);
                        break;
                    case '`CREATED_ON`':
                        $stmt->bindValue($identifier, $this->created_on ? $this->created_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`SCRAPED_ON`':
                        $stmt->bindValue($identifier, $this->scraped_on ? $this->scraped_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`APPROVED_ON`':
                        $stmt->bindValue($identifier, $this->approved_on ? $this->approved_on->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case '`GRAPHIC_CONTENT`':
                        $stmt->bindValue($identifier, (int) $this->graphic_content, PDO::PARAM_INT);
                        break;
                    case '`SHORTLINK`':
                        $stmt->bindValue($identifier, $this->shortlink, PDO::PARAM_STR);
                        break;
                    case '`URL`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case '`TITLE`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`QUOTE`':
                        $stmt->bindValue($identifier, $this->quote, PDO::PARAM_STR);
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
        $this->setRecommendationId($pk);

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
        $pos = RecommendationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRecommendationId();
                break;
            case 1:
                return $this->getCuratorId();
                break;
            case 2:
                return $this->getRecommendationHintId();
                break;
            case 3:
                return $this->getCreatedOn();
                break;
            case 4:
                return $this->getScrapedOn();
                break;
            case 5:
                return $this->getApprovedOn();
                break;
            case 6:
                return $this->getGraphicContent();
                break;
            case 7:
                return $this->getShortlink();
                break;
            case 8:
                return $this->getUrl();
                break;
            case 9:
                return $this->getTitle();
                break;
            case 10:
                return $this->getQuote();
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

        if (isset($alreadyDumpedObjects['Recommendation'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Recommendation'][$this->hashCode()] = true;
        $keys = RecommendationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getRecommendationId(),
            $keys[1] => $this->getCuratorId(),
            $keys[2] => $this->getRecommendationHintId(),
            $keys[3] => $this->getCreatedOn(),
            $keys[4] => $this->getScrapedOn(),
            $keys[5] => $this->getApprovedOn(),
            $keys[6] => $this->getGraphicContent(),
            $keys[7] => $this->getShortlink(),
            $keys[8] => $this->getUrl(),
            $keys[9] => $this->getTitle(),
            $keys[10] => $this->getQuote(),
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
            if (null !== $this->aRecommendationHint) {

                switch ($keyType) {
                    case TableMap::TYPE_STUDLYPHPNAME:
                        $key = 'recommendationHint';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'recommendation_hint';
                        break;
                    default:
                        $key = 'RecommendationHint';
                }

                $result[$key] = $this->aRecommendationHint->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collVisits) {

                switch ($keyType) {
                    case TableMap::TYPE_STUDLYPHPNAME:
                        $key = 'visits';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'visits';
                        break;
                    default:
                        $key = 'Visits';
                }

                $result[$key] = $this->collVisits->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\justnyt\models\Recommendation
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RecommendationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\justnyt\models\Recommendation
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setRecommendationId($value);
                break;
            case 1:
                $this->setCuratorId($value);
                break;
            case 2:
                $this->setRecommendationHintId($value);
                break;
            case 3:
                $this->setCreatedOn($value);
                break;
            case 4:
                $this->setScrapedOn($value);
                break;
            case 5:
                $this->setApprovedOn($value);
                break;
            case 6:
                $this->setGraphicContent($value);
                break;
            case 7:
                $this->setShortlink($value);
                break;
            case 8:
                $this->setUrl($value);
                break;
            case 9:
                $this->setTitle($value);
                break;
            case 10:
                $this->setQuote($value);
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
        $keys = RecommendationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setRecommendationId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCuratorId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRecommendationHintId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedOn($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setScrapedOn($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setApprovedOn($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setGraphicContent($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setShortlink($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUrl($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setTitle($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setQuote($arr[$keys[10]]);
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
     * @return $this|\justnyt\models\Recommendation The current object, for fluid interface
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
        $criteria = new Criteria(RecommendationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RecommendationTableMap::COL_RECOMMENDATION_ID)) {
            $criteria->add(RecommendationTableMap::COL_RECOMMENDATION_ID, $this->recommendation_id);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_CURATOR_ID)) {
            $criteria->add(RecommendationTableMap::COL_CURATOR_ID, $this->curator_id);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID)) {
            $criteria->add(RecommendationTableMap::COL_RECOMMENDATION_HINT_ID, $this->recommendation_hint_id);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_CREATED_ON)) {
            $criteria->add(RecommendationTableMap::COL_CREATED_ON, $this->created_on);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_SCRAPED_ON)) {
            $criteria->add(RecommendationTableMap::COL_SCRAPED_ON, $this->scraped_on);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_APPROVED_ON)) {
            $criteria->add(RecommendationTableMap::COL_APPROVED_ON, $this->approved_on);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_GRAPHIC_CONTENT)) {
            $criteria->add(RecommendationTableMap::COL_GRAPHIC_CONTENT, $this->graphic_content);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_SHORTLINK)) {
            $criteria->add(RecommendationTableMap::COL_SHORTLINK, $this->shortlink);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_URL)) {
            $criteria->add(RecommendationTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_TITLE)) {
            $criteria->add(RecommendationTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(RecommendationTableMap::COL_QUOTE)) {
            $criteria->add(RecommendationTableMap::COL_QUOTE, $this->quote);
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
        $criteria = new Criteria(RecommendationTableMap::DATABASE_NAME);
        $criteria->add(RecommendationTableMap::COL_RECOMMENDATION_ID, $this->recommendation_id);

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
        $validPk = null !== $this->getRecommendationId();

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
        return $this->getRecommendationId();
    }

    /**
     * Generic method to set the primary key (recommendation_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setRecommendationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getRecommendationId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \justnyt\models\Recommendation (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCuratorId($this->getCuratorId());
        $copyObj->setRecommendationHintId($this->getRecommendationHintId());
        $copyObj->setCreatedOn($this->getCreatedOn());
        $copyObj->setScrapedOn($this->getScrapedOn());
        $copyObj->setApprovedOn($this->getApprovedOn());
        $copyObj->setGraphicContent($this->getGraphicContent());
        $copyObj->setShortlink($this->getShortlink());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setQuote($this->getQuote());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVisits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVisit($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setRecommendationId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \justnyt\models\Recommendation Clone of current object.
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
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurator(ChildCurator $v = null)
    {
        if ($v === null) {
            $this->setCuratorId(NULL);
        } else {
            $this->setCuratorId($v->getCuratorId());
        }

        $this->aCurator = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCurator object, it will not be re-added.
        if ($v !== null) {
            $v->addRecommendation($this);
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
        if ($this->aCurator === null && ($this->curator_id !== null)) {
            $this->aCurator = ChildCuratorQuery::create()->findPk($this->curator_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCurator->addRecommendations($this);
             */
        }

        return $this->aCurator;
    }

    /**
     * Declares an association between this object and a ChildRecommendationHint object.
     *
     * @param  ChildRecommendationHint $v
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRecommendationHint(ChildRecommendationHint $v = null)
    {
        if ($v === null) {
            $this->setRecommendationHintId(NULL);
        } else {
            $this->setRecommendationHintId($v->getRecommendationHintId());
        }

        $this->aRecommendationHint = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildRecommendationHint object, it will not be re-added.
        if ($v !== null) {
            $v->addRecommendation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildRecommendationHint object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildRecommendationHint The associated ChildRecommendationHint object.
     * @throws PropelException
     */
    public function getRecommendationHint(ConnectionInterface $con = null)
    {
        if ($this->aRecommendationHint === null && ($this->recommendation_hint_id !== null)) {
            $this->aRecommendationHint = ChildRecommendationHintQuery::create()->findPk($this->recommendation_hint_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRecommendationHint->addRecommendations($this);
             */
        }

        return $this->aRecommendationHint;
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
        if ('Visit' == $relationName) {
            return $this->initVisits();
        }
    }

    /**
     * Clears out the collVisits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVisits()
     */
    public function clearVisits()
    {
        $this->collVisits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVisits collection loaded partially.
     */
    public function resetPartialVisits($v = true)
    {
        $this->collVisitsPartial = $v;
    }

    /**
     * Initializes the collVisits collection.
     *
     * By default this just sets the collVisits collection to an empty array (like clearcollVisits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVisits($overrideExisting = true)
    {
        if (null !== $this->collVisits && !$overrideExisting) {
            return;
        }
        $this->collVisits = new ObjectCollection();
        $this->collVisits->setModel('\justnyt\models\Visit');
    }

    /**
     * Gets an array of ChildVisit objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRecommendation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVisit[] List of ChildVisit objects
     * @throws PropelException
     */
    public function getVisits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVisitsPartial && !$this->isNew();
        if (null === $this->collVisits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVisits) {
                // return empty collection
                $this->initVisits();
            } else {
                $collVisits = ChildVisitQuery::create(null, $criteria)
                    ->filterByRecommendation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVisitsPartial && count($collVisits)) {
                        $this->initVisits(false);

                        foreach ($collVisits as $obj) {
                            if (false == $this->collVisits->contains($obj)) {
                                $this->collVisits->append($obj);
                            }
                        }

                        $this->collVisitsPartial = true;
                    }

                    return $collVisits;
                }

                if ($partial && $this->collVisits) {
                    foreach ($this->collVisits as $obj) {
                        if ($obj->isNew()) {
                            $collVisits[] = $obj;
                        }
                    }
                }

                $this->collVisits = $collVisits;
                $this->collVisitsPartial = false;
            }
        }

        return $this->collVisits;
    }

    /**
     * Sets a collection of ChildVisit objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $visits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRecommendation The current object (for fluent API support)
     */
    public function setVisits(Collection $visits, ConnectionInterface $con = null)
    {
        /** @var ChildVisit[] $visitsToDelete */
        $visitsToDelete = $this->getVisits(new Criteria(), $con)->diff($visits);


        $this->visitsScheduledForDeletion = $visitsToDelete;

        foreach ($visitsToDelete as $visitRemoved) {
            $visitRemoved->setRecommendation(null);
        }

        $this->collVisits = null;
        foreach ($visits as $visit) {
            $this->addVisit($visit);
        }

        $this->collVisits = $visits;
        $this->collVisitsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Visit objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Visit objects.
     * @throws PropelException
     */
    public function countVisits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVisitsPartial && !$this->isNew();
        if (null === $this->collVisits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVisits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVisits());
            }

            $query = ChildVisitQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRecommendation($this)
                ->count($con);
        }

        return count($this->collVisits);
    }

    /**
     * Method called to associate a ChildVisit object to this object
     * through the ChildVisit foreign key attribute.
     *
     * @param  ChildVisit $l ChildVisit
     * @return $this|\justnyt\models\Recommendation The current object (for fluent API support)
     */
    public function addVisit(ChildVisit $l)
    {
        if ($this->collVisits === null) {
            $this->initVisits();
            $this->collVisitsPartial = true;
        }

        if (!$this->collVisits->contains($l)) {
            $this->doAddVisit($l);
        }

        return $this;
    }

    /**
     * @param ChildVisit $visit The ChildVisit object to add.
     */
    protected function doAddVisit(ChildVisit $visit)
    {
        $this->collVisits[]= $visit;
        $visit->setRecommendation($this);
    }

    /**
     * @param  ChildVisit $visit The ChildVisit object to remove.
     * @return $this|ChildRecommendation The current object (for fluent API support)
     */
    public function removeVisit(ChildVisit $visit)
    {
        if ($this->getVisits()->contains($visit)) {
            $pos = $this->collVisits->search($visit);
            $this->collVisits->remove($pos);
            if (null === $this->visitsScheduledForDeletion) {
                $this->visitsScheduledForDeletion = clone $this->collVisits;
                $this->visitsScheduledForDeletion->clear();
            }
            $this->visitsScheduledForDeletion[]= $visit;
            $visit->setRecommendation(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCurator) {
            $this->aCurator->removeRecommendation($this);
        }
        if (null !== $this->aRecommendationHint) {
            $this->aRecommendationHint->removeRecommendation($this);
        }
        $this->recommendation_id = null;
        $this->curator_id = null;
        $this->recommendation_hint_id = null;
        $this->created_on = null;
        $this->scraped_on = null;
        $this->approved_on = null;
        $this->graphic_content = null;
        $this->shortlink = null;
        $this->url = null;
        $this->title = null;
        $this->quote = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collVisits) {
                foreach ($this->collVisits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVisits = null;
        $this->aCurator = null;
        $this->aRecommendationHint = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RecommendationTableMap::DEFAULT_STRING_FORMAT);
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
