<?php
/**
 * EMongoDocument.php
 *
 * PHP version 5.2+
 *
 * @author		Dariusz Górecki <darek.krk@gmail.com>
 * @author		Invenzzia Group, open-source division of CleverIT company http://www.invenzzia.org
 * @copyright	2011 CleverIT http://www.cleverit.com.pl
 * @license		http://www.yiiframework.com/license/ BSD license
 * @version		1.3
 * @category	ext
 * @package		ext.YiiMongoDbSuite
 * @since		v1.0
 */

/**
 * EMongoDocument
 *
 * @property-read MongoDB $db
 * @since v1.0
 */
abstract class EMongoDocument extends EMongoEmbeddedDocument
{



	/// magic methods ////////////////////////





	/////////////////////////////////////////////////////

	public static function s_identity($mongoId){
		return $mongoId->__toString();
	}

	public  function identity(){
		return $this->_id->__toString();
	}
	//extensions
	private $_doc;

	public function getDoc(){
		return  $this->_doc;
	}

	public $doc;


	private $_signatureMap;

	public function getSignatureMap(){
		return $_signatureMap;
	}

	public function setSignatureMap($signatureMap){
		$this->_signatureMap = $signatureMap;
	}

	public function getTargetSignature(){
		if(!$this->message['target'])return null;

		return $this->_signatureMap[$this->message['target']];
	}
	 
	public function getActorSignature(){
		if(!$this->message['actor'])return null;

		return $this->_signatureMap[$this->message['actor']];
	}
	 


	//////////////////////////////////////

	private					$_new			= false;		// whether this instance is new or not
	private					$_criteria		= null;			// query criteria (used by finder only)

	/**
	 * Static array that holds mongo collection object instances,
	 * protected access since v1.3
	 *
	 * @var array $_collections static array of loaded collection objects
	 * @since v1.3
	 */
	protected	static		$_collections	= array();		// MongoCollection object

	private		static		$_models		= array();
	private		static		$_indexes		= array();		// Hold collection indexes array

	private 				$_fsyncFlag		= null;			// Object level FSync flag
	private 				$_safeFlag		= null;			// Object level Safe flag

	protected				$useCursor		= null;			// Whatever to return cursor instead on raw array

	/**
	 * @var boolean $ensureIndexes whatever to check and create non existing indexes of collection
	 * @since v1.1
	 */
	protected				$ensureIndexes	= true;			// Whatever to ensure indexes

	/**
	 * EMongoDB component static instance
	 * @var EMongoDB $_emongoDb;
	 * @since v1.0
	 */
	protected static $_emongoDb;

	/**
	 * MongoDB special field, every document has to have this
	 *
	 * @var mixed $_id
	 * @since v1.0
	 */
	public $_id;

	/**
	 * Add scopes functionality
	 * @see CComponent::__call()
	 * @since v1.0
	 */
	public function __call($name, $parameters)
	{
		$scopes=$this->scopes();
		if(isset($scopes[$name]))
		{
			$this->getDbCriteria()->mergeWith($scopes[$name]);
			return $this;
		}

		return parent::__call($name,$parameters);
	}

	/**
	 * Constructor {@see setScenario()}
	 *
	 * @param string $scenario
	 * @since v1.0
	 */
	public function __construct($scenario='insert')
	{
		if($scenario==null) // internally used by populateRecord() and model()
		return;

		$this->setScenario($scenario);
		$this->setIsNewRecord(true);

		$this->init();

		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();

		$this->initEmbeddedDocuments();
	}

	/**
	 * Return the primary key field for this collection, defaults to '_id'
	 * @return string|array field name, or array of fields for composite primary key
	 * @since v1.2.2
	 */
	public function primaryKey()
	{
		return '_id';
	}


	/**
	 * @since v1.2.2
	 */
	public function getPrimaryKey()
	{
		$pk = $this->primaryKey();
		if(is_string($pk))
		return $this->{$pk};
		else
		{
			$return = array();
			foreach($pk as $pkFiled)
			$return[] = $this->{$pkFiled};

			return $return;
		}
	}

	/**
	 * Get EMongoDB component instance
	 * By default it is mongodb application component
	 *
	 * @return EMongoDB
	 * @since v1.0
	 */
	public function getMongoDBComponent()
	{
		if(self::$_emongoDb===null)
		self::$_emongoDb = Yii::app()->getComponent('mongodb');

		return self::$_emongoDb;
	}

	/**
	 * Set EMongoDB component instance
	 * @param EMongoDB $component
	 * @since v1.0
	 */
	public function setMongoDBComponent(EMongoDB $component)
	{
		self::$_emongoDb = $component;
	}

	/**
	 * Get raw MongoDB instance
	 * @return MongoDB
	 * @since v1.0
	 */
	public function getDb()
	{
		return $this->getMongoDBComponent()->getDbInstance();
	}

	/**
	 * This method must return collection name for use with this model
	 * this must be implemented in child classes
	 *
	 * this is read-only defined only at class define
	 * if you whant to set different colection during run-time
	 * use {@see setCollection()}
	 *
	 * @return string collection name
	 * @since v1.0
	 */
	abstract public function getCollectionName();

	/**
	 * Returns current MongoCollection object
	 * By default this method use {@see getCollectionName()}
	 * @return MongoCollection
	 * @since v1.0
	 */
	public function getCollection()
	{
		if(!isset(self::$_collections[$this->getCollectionName()]))
		self::$_collections[$this->getCollectionName()] = $this->getDb()->selectCollection($this->getCollectionName());

		return self::$_collections[$this->getCollectionName()];
	}

	/**
	 * Set current MongoCollection object
	 * @param MongoCollection $collection
	 * @since v1.0
	 */
	public function setCollection(MongoCollection $collection)
	{
		self::$_collections[$this->getCollectionName()] = $collection;
	}

	/**
	 * Returns if the current record is new.
	 * @return boolean whether the record is new and should be inserted when calling {@link save}.
	 * This property is automatically set in constructor and {@link populateRecord}.
	 * Defaults to false, but it will be set to true if the instance is created using
	 * the new operator.
	 * @since v1.0
	 */
	public function getIsNewRecord()
	{
		return $this->_new;
	}

	/**
	 * Sets if the record is new.
	 * @param boolean $value whether the record is new and should be inserted when calling {@link save}.
	 * @see getIsNewRecord
	 * @since v1.0
	 */
	public function setIsNewRecord($value)
	{
		$this->_new=$value;
	}

	/**
	 * Returns the mongo criteria associated with this model.
	 * @param boolean $createIfNull whether to create a criteria instance if it does not exist. Defaults to true.
	 * @return EMongoCriteria the query criteria that is associated with this model.
	 * This criteria is mainly used by {@link scopes named scope} feature to accumulate
	 * different criteria specifications.
	 * @since v1.0
	 */
	public function getDbCriteria($createIfNull=true)
	{
		if($this->_criteria===null)
		if(($c = $this->defaultScope()) !== array() || $createIfNull)
		$this->_criteria = new EMongoCriteria($c);
		return $this->_criteria;
	}

	/**
	 * Set girrent object, this will override proevious criteria
	 *
	 * @param EMongoCriteria $criteria
	 * @since v1.0
	 */
	public function setDbCriteria($criteria)
	{
		if(is_array($criteria))
		$this->_criteria = new EMongoCriteria($criteria);
		else if($criteria instanceof EMongoCriteria)
		$this->_criteria = $criteria;
		else
		$this->_criteria = new EMongoCriteria();
	}

	/**
	 * Get FSync flag
	 *
	 * It will return the nearest not null value in order:
	 * - Object level
	 * - Model level
	 * - Glopal level (always set)
	 * @return boolean
	 */
	public function getFsyncFlag()
	{
		if($this->_fsyncFlag !== null)
		return $this->_fsyncFlag; // We have flag set, return it
		if((isset(self::$_models[get_class($this)]) === true) && (self::$_models[get_class($this)]->_fsyncFlag !== null))
		return self::$_models[get_class($this)]->_fsyncFlag; // Model have flag set, return it
		return $this->getMongoDBComponent()->fsyncFlag;
	}

	/**
	 * Set object level FSync flag
	 * @param boolean $flag true|false value for FSync flag
	 */
	public function setFsyncFlag($flag)
	{
		$this->_fsyncFlag = ($flag == true);
		if($this->_fsyncFlag)
		$this->setSafeFlag(true); // Setting FSync flag to true will implicit set safe to true
	}

	/**
	 * Get Safe flag
	 *
	 * It will return the nearest not null value in order:
	 * - Object level
	 * - Model level
	 * - Glopal level (always set)
	 * @return boolean
	 */
	public function getSafeFlag()
	{
		if($this->_safeFlag !== null)
		return $this->_safeFlag; // We have flag set, return it
		if((isset(self::$_models[get_class($this)]) === true) && (self::$_models[get_class($this)]->_safeFlag !== null))
		return self::$_models[get_class($this)]->_safeFlag; // Model have flag set, return it
		return $this->getMongoDBComponent()->safeFlag;
	}

	/**
	 * Set object level Safe flag
	 * @param boolean $flag true|false value for Safe flag
	 */
	public function setSafeFlag($flag)
	{
		$this->_safeFlag = ($flag == true);
	}

	/**
	 * Get value of use cursor flag
	 *
	 * It will return the nearest not null value in order:
	 * - Object level
	 * - Model level
	 * - Glopal level (always set)
	 * @return boolean
	 */
	public function getUseCursor()
	{
		if($this->useCursor !== null)
		return $this->useCursor; // We have flag set, return it
		if((isset(self::$_models[get_class($this)]) === true) && (self::$_models[get_class($this)]->useCursor !== null))
		return self::$_models[get_class($this)]->useCursor; // Model have flag set, return it
		return $this->getMongoDBComponent()->useCursor;
	}

	/**
	 * Set object level value of use cursor flag
	 * @param boolean $useCursor true|false value for use cursor flag
	 */
	public function setUseCursor($useCursor)
	{
		$this->useCursor = ($useCursor == true);
	}

	/**
	 * Sets the attribute values in a massive way.
	 * @param array $values attribute values (name=>value) to be set.
	 * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
	 * A safe attribute is one that is associated with a validation rule in the current {@link scenario}.
	 * @see getSafeAttributeNames
	 * @see attributeNames
	 * @since v1.3.1
	 */
	public function setAttributes($values, $safeOnly=true)
	{
		if(!is_array($values))
		return;

		if($this->hasEmbeddedDocuments())
		{
			$attributes=array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());

			foreach($this->embeddedDocuments() as $fieldName => $className)
			if(isset($values[$fieldName]) && isset($attributes[$fieldName]))
			{
				$this->$fieldName->setAttributes($values[$fieldName], $safeOnly);
				unset($values[$fieldName]);
			}
		}

		parent::setAttributes($values, $safeOnly);
	}

	/**
	 * This function check indexes and applies them to the collection if needed
	 * see CModel::init()
	 *
	 * @see EMongoEmbeddedDocument::init()
	 * @since v1.1
	 */
	public function init()
	{
		parent::init();

		if($this->ensureIndexes && !isset(self::$_indexes[$this->getCollectionName()]))
		{
			$indexInfo = $this->getCollection()->getIndexInfo();
			array_shift($indexInfo); // strip out default _id index

			$indexes = array();
			foreach($indexInfo as $index)
			{
				$indexes[$index['name']] = array(
					'key'=>$index['key'],
					'unique'=>isset($index['unique']) ? $index['unique'] : false,
				);
			}
			self::$_indexes[$this->getCollectionName()] = $indexes;

			$this->ensureIndexes();
		}
	}

	/**
	 * This function may return array of indexes for this collection
	 * array sytntax is:
	 * return array(
	 * 	'index_name'=>array('key'=>array('fieldName1'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
	 * 	'index2_name'=>array('key'=>array('fieldName3'=>EMongoCriteria::SORT_ASC, 'unique'=>true),
	 * );
	 * @return array list of indexes for this collection
	 * @since v1.1
	 */
	public function indexes()
	{
		return array();
	}

	/**
	 * @since v1.1
	 */
	private function ensureIndexes()
	{
		$indexNames = array_keys(self::$_indexes[$this->getCollectionName()]);
		foreach($this->indexes() as $name=>$index)
		{
			if(!in_array($name, $indexNames))
			{
				if(version_compare(Mongo::VERSION, '1.0.2','>=') === true)
				{
					$this->getCollection()->ensureIndex(
					$index['key'],
					array('unique'=>isset($index['unique']) ? $index['unique'] : false, 'name'=>$name)
					);
				} else {
					$this->getCollection()->ensureIndex(
					$index['key'],
					isset($index['unique']) ? $index['unique'] : false
					);
				}
				self::$_indexes[$this->getCollectionName()][$name] = $index;
			}
		}
	}

	/**
	 * Returns the declaration of named scopes.
	 * A named scope represents a query criteria that can be chained together with
	 * other named scopes and applied to a query. This method should be overridden
	 * by child classes to declare named scopes for the particular document classes.
	 * For example, the following code declares two named scopes: 'recently' and
	 * 'published'.
	 * <pre>
	 * return array(
	 *     'published'=>array(
	 *           'conditions'=>array(
	 *                 'status'=>array('==', 1),
	 *           ),
	 *     ),
	 *     'recently'=>array(
	 *           'sort'=>array('create_time'=>EMongoCriteria::SORT_DESC),
	 *           'limit'=>5,
	 *     ),
	 * );
	 * </pre>
	 * If the above scopes are declared in a 'Post' model, we can perform the following
	 * queries:
	 * <pre>
	 * $posts=Post::model()->published()->findAll();
	 * $posts=Post::model()->published()->recently()->findAll();
	 * $posts=Post::model()->published()->published()->recently()->find();
	 * </pre>
	 *
	 * @return array the scope definition. The array keys are scope names; the array
	 * values are the corresponding scope definitions. Each scope definition is represented
	 * as an array whose keys must be properties of {@link EMongoCriteria}.
	 * @since v1.0
	 */
	public function scopes()
	{
		return array();
	}

	/**
	 * Returns the default named scope that should be implicitly applied to all queries for this model.
	 * Note, default scope only applies to SELECT queries. It is ignored for INSERT, UPDATE and DELETE queries.
	 * The default implementation simply returns an empty array. You may override this method
	 * if the model needs to be queried with some default criteria (e.g. only active records should be returned).
	 * @return array the mongo criteria. This will be used as the parameter to the constructor
	 * of {@link EMongoCriteria}.
	 * @since v1.2.2
	 */
	public function defaultScope()
	{
		return array();
	}

	/**
	 * Resets all scopes and criterias applied including default scope.
	 *
	 * @return EMongoDocument
	 * @since v1.0
	 */
	public function resetScope()
	{
		$this->_criteria = new EMongoCriteria();
		return $this;
	}

	/**
	 * Applies the query scopes to the given criteria.
	 * This method merges {@link dbCriteria} with the given criteria parameter.
	 * It then resets {@link dbCriteria} to be null.
	 * @param EMongoCriteria|array $criteria the query criteria. This parameter may be modified by merging {@link dbCriteria}.
	 * @since v1.2.2
	 */
	public function applyScopes(&$criteria)
	{
		if($criteria === null)
		{
			$criteria = new EMongoCriteria();
		}
		else if(is_array($criteria))
		{
			$criteria = new EMongoCriteria($criteria);
		}
		else if(!($criteria instanceof EMongoCriteria))
		throw new EMongoException('Cannot apply scopes to criteria');

		if(($c=$this->getDbCriteria(false))!==null)
		{
			$c->mergeWith($criteria);
			$criteria=$c;
			$this->_criteria=null;
		}
	}

	/**
	 * Saves the current record.
	 *
	 * The record is inserted as a row into the database table if its {@link isNewRecord}
	 * property is true (usually the case when the record is created using the 'new'
	 * operator). Otherwise, it will be used to update the corresponding row in the table
	 * (usually the case if the record is obtained using one of those 'find' methods.)
	 *
	 * Validation will be performed before saving the record. If the validation fails,
	 * the record will not be saved. You can call {@link getErrors()} to retrieve the
	 * validation errors.
	 *
	 * If the record is saved via insertion, its {@link isNewRecord} property will be
	 * set false, and its {@link scenario} property will be set to be 'update'.
	 * And if its primary key is auto-incremental and is not set before insertion,
	 * the primary key will be populated with the automatically generated key value.
	 *
	 * @param boolean $runValidation whether to perform validation before saving the record.
	 * If the validation fails, the record will not be saved to database.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the saving succeeds
	 * @since v1.0
	 */
	public function save($runValidation=true,$attributes=null)
	{
		if(!$runValidation || $this->validate($attributes))
		return $this->getIsNewRecord() ? $this->insert($attributes) : $this->update($attributes);
		else
		return false;
	}

	/**
	 * Inserts a row into the table based on this active record attributes.
	 * If the table's primary key is auto-incremental and is null before insertion,
	 * it will be populated with the actual value after insertion.
	 * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
	 * After the record is inserted to DB successfully, its {@link isNewRecord} property will be set false,
	 * and its {@link scenario} property will be set to be 'update'.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @return boolean whether the attributes are valid and the record is inserted successfully.
	 * @throws CException if the record is not new
	 * @throws EMongoException on fail of insert or insert of empty document
	 * @throws MongoCursorException on fail of insert, when safe flag is set to true
	 * @throws MongoCursorTimeoutException on timeout of db operation , when safe flag is set to true
	 * @since v1.0
	 */
	public function insert(array $attributes=null)
	{
		if(!$this->getIsNewRecord())
		throw new CDbException(Yii::t('yii','The EMongoDocument cannot be inserted to database because it is not new.'));
		if($this->beforeSave())
		{
			Yii::trace(get_class($this).'.insert()','ext.MongoDb.EMongoDocument');
			$rawData = $this->toArray();
			// free the '_id' container if empty, mongo will not populate it if exists
			if(empty($rawData['_id']))
			unset($rawData['_id']);
			// filter attributes if set in param
			if($attributes!==null)
			{
				foreach($rawData as $key=>$value)
				{
					if(!in_array($key, $attributes))
					unset($rawData[$key]);
				}
			}

			if(version_compare(Mongo::VERSION, '1.0.5','>=') === true)
			$result = $this->getCollection()->insert($rawData, array(
					'fsync'	=> $this->getFsyncFlag(),
					'safe'	=> $this->getSafeFlag()
			));
			else
			$result = $this->getCollection()->insert($rawData, CPropertyValue::ensureBoolean($this->getSafeFlag()));
				
			Yii::log("signatureNew $result::".CVarDumper::dumpAsString($result), CLogger::LEVEL_INFO);

			if($result !== false) // strict comparison needed
			{
				$this->_id = $rawData['_id'];
				$this->setIsNewRecord(false);
				$this->setScenario('update');
				$this->afterSave();

				return true;
			}

			throw new EMongoException(Yii::t('yii', 'Can\t save document to disk, or try to save empty document!'));
		}
		return false;
	}

	/**
	 * Updates the row represented by this active record.
	 * All loaded attributes will be saved to the database.
	 * Note, validation is not performed in this method. You may call {@link validate} to perform the validation.
	 * @param array $attributes list of attributes that need to be saved. Defaults to null,
	 * meaning all attributes that are loaded from DB will be saved.
	 * @param boolean modify if set true only selected attributes will be replaced, and not
	 * the whole document
	 * @return boolean whether the update is successful
	 * @throws CException if the record is new
	 * @throws EMongoException on fail of update
	 * @throws MongoCursorException on fail of update, when safe flag is set to true
	 * @throws MongoCursorTimeoutException on timeout of db operation , when safe flag is set to true
	 * @since v1.0
	 */
	public function update(array $attributes=null, $modify = false)
	{
		if($this->getIsNewRecord())
		throw new CDbException(Yii::t('yii','The EMongoDocument cannot be updated because it is new.'));
		if($this->beforeSave())
		{
			Yii::trace(get_class($this).'.update()','ext.MongoDb.EMongoDocument');
			$rawData = $this->toArray();
			// filter attributes if set in param
			if($attributes!==null)
			{
				if (!in_array('_id', $attributes) && !$modify) $attributes[] = '_id'; // This is very easy to forget

				foreach($rawData as $key=>$value)
				{
					if(!in_array($key, $attributes))
					unset($rawData[$key]);
				}
			}

			if($modify)
			{
				if(isset($rawData['_id']) === true)
				unset($rawData['_id']);
				$result = $this->getCollection()->update(
				array('_id' => $this->_id),
				array('$set' => $rawData),
				array(
						'fsync'=>$this->getFsyncFlag(),
						'safe'=>$this->getSafeFlag(),
						'multiple'=>false
				)
				);
			} else {
				if(version_compare(Mongo::VERSION, '1.0.5','>=') === true)
				$result = $this->getCollection()->save($rawData, array(
						'fsync'=>$this->getFsyncFlag(),
						'safe'=>$this->getSafeFlag()
				));
				else
				$result = $this->getCollection()->save($rawData);
			}

			if($result !== false) // strict comparison needed
			{
				$this->afterSave();

				return true;
			}

			throw new CException(Yii::t('yii', 'Can\t save document to disk, or try to save empty document!'));
		}
	}
	/**
	 * Atomic, in-place update method.
	 *
	 * @since v1.3.6
	 * @param EMongoModifier $modifier updating rules to apply
	 * @param EMongoCriteria $criteria condition to limit updating rules
	 * @return bool
	 */
	public function updateAll($modifier, $criteria=null) {
		Yii::trace(get_class($this).'.updateAll()','ext.MongoDb.EMongoDocument');
		if($modifier->canApply === true)
		{
			$this->applyScopes($criteria);
			if(version_compare(Mongo::VERSION, '1.0.5','>=') === true)
			$result = $this->getCollection()->update($criteria->getConditions(), $modifier->getModifiers(), array(
					'fsync'=>$this->getFsyncFlag(),
					'safe'=>$this->getSafeFlag(),
					'upsert'=>false,
					'multiple'=>true
			));
			else
			$result = $this->getCollection()->update($criteria->getConditions(), $modifier->getModifiers(), array(
					'upsert'=>false,
					'multiple'=>true
			));
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * Deletes the row corresponding to this EMongoDocument.
	 * @return boolean whether the deletion is successful.
	 * @throws CException if the record is new
	 * @since v1.0
	 */
	public function delete()
	{
		if(!$this->getIsNewRecord())
		{
			Yii::trace(get_class($this).'.delete()','ext.MongoDb.EMongoDocument');
			if($this->beforeDelete())
			{
				$result = $this->deleteByPk($this->getPrimaryKey());

				if($result !== false)
				{
					$this->afterDelete();
					$this->setIsNewRecord(true);
					return true;
				}
				else
				return false;
			}
			else
			return false;
		}
		else
		throw new CDbException(Yii::t('yii','The EMongoDocument cannot be deleted because it is new.'));
	}

	/**
	 * Deletes document with the specified primary key.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @since v1.0
	 */
	public function deleteByPk($pk, $criteria=null)
	{
		Yii::trace(get_class($this).'.deleteByPk()','ext.MongoDb.EMongoDocument');
		if($this->beforeDelete())
		{
			$this->applyScopes($criteria);
			$criteria->mergeWith($this->createPkCriteria($pk));

			if(version_compare(Mongo::VERSION, '1.0.5','>=') === true)
			$result = $this->getCollection()->remove($criteria->getConditions(), array(
					'justOne'=>true,
					'fsync'=>$this->getFsyncFlag(),
					'safe'=>$this->getSafeFlag()
			));
			else
			$result = $this->getCollection()->remove($criteria->getConditions(), true);

			$this->afterDelete();
			return $result;
		}
		return false;
	}


	/**
	 * Repopulates this active record with the latest data.
	 * @return boolean whether the row still exists in the database. If true, the latest data will be populated to this active record.
	 * @since v1.0
	 */
	public function refresh()
	{
		Yii::trace(get_class($this).'.refresh()','ext.MongoDb.EMongoDocument');
		if(!$this->getIsNewRecord() && $this->getCollection()->count(array('_id'=>$this->_id))==1)
		{
			$this->setAttributes($this->getCollection()->find(array('_id'=>$this->_id)), false);
			return true;
		}
		else
		return false;
	}

	/**
	 * Finds a single EMongoDocument with the specified condition.
	 * @param array|EMongoCriteria $condition query criteria.
	 *
	 * If an array, it is treated as the initial values for constructing a {@link EMongoCriteria} object;
	 * Otherwise, it should be an instance of {@link EMongoCriteria}.
	 *
	 * @return EMongoDocument the record found. Null if no record is found.
	 * @since v1.0
	 */
	public function find($criteria=null)
	{
		Yii::trace(get_class($this).'.find()','ext.MongoDb.EMongoDocument');

		if($this->beforeFind())
		{
			$this->applyScopes($criteria);

			$this->doc = $this->getCollection()->findOne($criteria->getConditions(), $criteria->getSelect());

			return $this->populateRecord($this->doc);
		}
		return null;
	}


	public function findByNative($criteria=null)
	{
		Yii::trace(get_class($this).'.find()','ext.MongoDb.EMongoDocument');

		if($this->beforeFind())
		{
				
			$this->doc = $this->getCollection()->findOne($criteria);

			return $this->populateRecord($this->doc);
		}
		return null;
	}
	public function findNative($criteria=null)
	{
		Yii::trace(get_class($this).'.find()','ext.MongoDb.EMongoDocument');

		if($this->beforeFind())
		{
				
			$this->doc = $this->getCollection()->findOne($criteria);

			return $this->populateRecord($this->doc);
		}
		return null;
	}

	/**
	 * Finds all documents satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return array list of documents satisfying the specified condition. An empty array is returned if none is found.
	 * @since v1.0
	 */
	public function findAll($criteria=null)
	{
		Yii::log(get_class($this).'.findAll()1'.CVarDumper::dumpAsString($criteria),CLogger::LEVEL_ERROR);
		Yii::trace(get_class($this).'.findAll()','ext.MongoDb.EMongoDocument');

		if(!$criteria)$criteria= new EMongoCriteria();

		if($this->beforeFind())
		{
			if($criteria->native){
				//$this->applyScopes($criteria);
				Yii::log("findAll.criteria.native :".CVarDumper::dumpAsString($criteria->native) , CLogger::LEVEL_INFO);
				Yii::log("findAll.criteria.getSort :".CVarDumper::dumpAsString($criteria->getSort()) , CLogger::LEVEL_INFO);
				Yii::log("findAll.criteria.getLimit :".CVarDumper::dumpAsString($criteria->getLimit()), CLogger::LEVEL_INFO );
				Yii::log("findAll.criteria.getOffset :".CVarDumper::dumpAsString($criteria->getOffset()), CLogger::LEVEL_INFO );

				Yii::log(get_class($this)."Mongo Native Query....",CLogger::LEVEL_ERROR);
					
				$cursor = $this->getCollection()->find($criteria->native);

				if($criteria->getSort() !== null)
				$cursor->sort($criteria->getSort());
				if($criteria->getLimit() !== null)
				$cursor->limit($criteria->getLimit());
				if($criteria->getOffset() !== null)
				$cursor->skip($criteria->getOffset());

				/**
				 if($criteria->getSelect())
				 $cursor->fields($criteria->getSelect(true));
				 **/


				if($this->getUseCursor())
				return new EMongoCursor($cursor, $this->model());
				else
				return $this->populateRecords($cursor);


			}else{

				Yii::log("findAll.criteria.native - non-native:".CVarDumper::dumpAsString($criteria->native) , CLogger::LEVEL_INFO);


				$this->applyScopes($criteria);
				//var_dump($criteria->getConditions());
					

				$conditions = $criteria->getConditions();


				if($conditions){

					//@patch:op
					if($conditions['locations']){
						$filters = array('country','region','city','locality','zip');
						foreach ($conditions['locations'] as $index=> $location){
							unset($conditions['locations'][$index]['name']);

							foreach ($filters as $filter){
								if($conditions['locations'][$index][$filter]==''){
									unset($conditions['locations'][$index][$filter]);
								}else{
									$conditions['locations.'.$filter]=$conditions['locations'][$index][$filter];
									unset($conditions['locations'][$index][$filter]);
								}
							}

						}

						unset($conditions['locations']);
					}
				}

				Yii::log(get_class($this).CVarDumper::dumpAsString($conditions),CLogger::LEVEL_ERROR);
					
				$cursor = $this->getCollection()->find($conditions);

				if($criteria->getSort() !== null)
				$cursor->sort($criteria->getSort());
				if($criteria->getLimit() !== null)
				$cursor->limit($criteria->getLimit());
				if($criteria->getOffset() !== null)
				$cursor->skip($criteria->getOffset());
				if($criteria->getSelect())
				$cursor->fields($criteria->getSelect(true));


				Yii::log("findAll.criteria.native - non-native :".get_class($this).CVarDumper::dumpAsString($criteria->native) , CLogger::LEVEL_INFO);
				Yii::log("findAll.criteria.getSort :".CVarDumper::dumpAsString($criteria->getSort()) , CLogger::LEVEL_INFO);
				Yii::log("findAll.criteria.getLimit :".CVarDumper::dumpAsString($criteria->getLimit()), CLogger::LEVEL_INFO );
				Yii::log("findAll.criteria.getOffset :".CVarDumper::dumpAsString($criteria->getOffset()), CLogger::LEVEL_INFO );
					

				if($this->getUseCursor())
				return new EMongoCursor($cursor, $this->model());
				else
				return $this->populateRecords($cursor);
			}
		}
		return array();
	}


	/**
	 * Finds all documents satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return array list of documents satisfying the specified condition. An empty array is returned if none is found.
	 * @since v1.0
	 */
	public function findAllByNative($criteria=array(), $options=null)
	{
		Yii::log(get_class($this).'.findAllByNative()',CLogger::LEVEL_ERROR);
		Yii::trace(get_class($this).'.findAllByNative()','ext.MongoDb.EMongoDocument');

		if($this->beforeFind())
		{
			Yii::log(get_class($this)."Mongo Native Query....",CLogger::LEVEL_ERROR);
				
			$cursor = $this->getCollection()->find($criteria);

			if($options!=null){
				if(isset($options['sort'])){
					$cursor->sort($options['sort']);
				}
					
				if(isset($options['limit'])){
					$cursor->limit($options['limit']);
				}
					
				if(isset($options['offset'])){
					$cursor->limit($options['offset']);
				}
			}

			 

			if($this->getUseCursor())
			return new EMongoCursor($cursor, $this->model());
			else
			return $this->populateRecords($cursor);


				
		}
		return array();
	}

	/**
	 * Finds document with the specified primary key.
	 * In MongoDB world every document has '_id' unique field, so with this method that
	 * field is in use as PK!
	 * See {@link find()} for detailed explanation about $condition.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return the document found. An null is returned if none is found.
	 * @since v1.0
	 */
	public function findByPk($pk, $criteria=null)
	{
		Yii::log(get_class($this).'.findByPk()','ext.MongoDb.EMongoDocument');
		$criteria = new EMongoCriteria($criteria);
		$criteria->mergeWith($this->createPkCriteria($pk));

		return $this->find($criteria);
	}

	/**
	 * Finds all documents with the specified primary keys.
	 * In MongoDB world every document has '_id' unique field, so with this method that
	 * field is in use as PK by default.
	 * See {@link find()} for detailed explanation about $condition.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return the document found. An null is returned if none is found.
	 * @since v1.0
	 */
	public function findAllByPk($pk, $criteria=null)
	{
		Yii::trace(get_class($this).'.findAllByPk()','ext.MongoDb.EMongoDocument');
		$criteria = new EMongoCriteria($criteria);
		$criteria->mergeWith($this->createPkCriteria($pk, true));

		return $this->findAll($criteria);
	}

	/**
	 * Finds document with the specified attributes.
	 *
	 * See {@link find()} for detailed explanation about $condition.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return the document found. An null is returned if none is found.
	 * @since v1.0
	 */
	public function findByAttributes(array $attributes)
	{
		$criteria = new EMongoCriteria();
		foreach($attributes as $name=>$value)
		{
			$criteria->$name('==', $value);
		}

		return $this->find($criteria);
	}

	/**
	 * Finds all documents with the specified attributes.
	 *
	 * See {@link find()} for detailed explanation about $condition.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return the document found. An null is returned if none is found.
	 * @since v1.0
	 */
	public function findAllByAttributes(array $attributes)
	{
		$criteria = new EMongoCriteria();
		foreach($attributes as $name=>$value)
		{
			$criteria->$name('==', $value);
		}

		return $this->findAll($criteria);
	}

	public function countByNative($conditions=array())
	{
		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;

		return $this->count($criteria);

	}
	/**
	 *
	 *  native criteria ::
	 *  $criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;
		$model = EMongoDocument::model($modelClass);
		$model->count($criteria);

	 * Counts all documents satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return integer Count of all documents satisfying the specified condition.
	 * @since v1.0
	 */
	public function count($criteria=null)
	{
		Yii::trace(get_class($this).'.count()','ext.MongoDb.EMongoDocument');

		$this->applyScopes($criteria);


		if($criteria->native){
			return $this->getCollection()->count($criteria->native);
				

		}

		return $this->getCollection()->count($criteria->getConditions());
	}

	/**
	 *
	 *


	 * Counts all documents satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return integer Count of all documents satisfying the specified condition.
	 * @since v1.2.2
	 */
	public function countByAttributes(array $attributes)
	{
		Yii::trace(get_class($this).'.countByAttributes()','ext.MongoDb.EMongoDocument');
		if($criteria->native){
			return $this->getCollection()->count($criteria->native);
				

		}
		$criteria = new EMongoCriteria;
		foreach($attributes as $name=>$value)
		$criteria->$name = $value;

		$this->applyScopes($criteria);

		return $this->getCollection()->count($criteria->getConditions());
	}

	/**
	 * Deletes documents with the specified primary keys.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param array|EMongoCriteria $condition query criteria.
	 * @since v1.0
	 */
	public function deleteAll($criteria=null)
	{
		Yii::trace(get_class($this).'.deleteByPk()','ext.MongoDb.EMongoDocument');
		$this->applyScopes($criteria);

		if(version_compare(Mongo::VERSION, '1.0.5','>=') === true)
		return $this->getCollection()->remove($criteria->getConditions(), array(
				'justOne'=>false,
				'fsync'=>$this->getFsyncFlag(),
				'safe'=>$this->getSafeFlag()
		));
		else
		return $this->getCollection()->remove($criteria->getConditions(), false);
	}


	public function deleteAllByNative($conditions=null)
	{
		Yii::trace(get_class($this).'.deleteByPk()','ext.MongoDb.EMongoDocument');
		return $this->getCollection()->remove($conditions, array(
				'justOne'=>false,
				'fsync'=>$this->getFsyncFlag(),
				'safe'=>$this->getSafeFlag()
		));

	}

	/**
	 * This event is raised before the record is saved.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link save()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 * @since v1.0
	 */
	public  function onBeforeSave($event)
	{

		$autoFields = $this->autoFields();
		Yii::log("auto fields :".CVarDumper::dumpAsString($autoFields), CLogger::LEVEL_INFO);

		if($autoFields && $_POST){
			foreach ($autoFields as $autoField){
				if($autoField == 'locations' && isset($_POST[$autoField])){
					Yii::log("processionsauto fields :".$autoField, CLogger::LEVEL_INFO);
					$this->updateLocations($_POST[$autoField]);
				}
			}
		}
		$this->raiseEvent('onBeforeSave',$event);
	}

	/**
	 * This event is raised after the record is saved.
	 * @param CEvent $event the event parameter
	 * @since v1.0
	 */
	public  function onAfterSave($event)
	{
		$this->raiseEvent('onAfterSave',$event);
	}

	/**
	 * This event is raised before the record is deleted.
	 * By setting {@link CModelEvent::isValid} to be false, the normal {@link delete()} process will be stopped.
	 * @param CModelEvent $event the event parameter
	 * @since v1.0
	 */
	public function onBeforeDelete($event)
	{
		$this->raiseEvent('onBeforeDelete',$event);
	}

	/**
	 * This event is raised after the record is deleted.
	 * @param CEvent $event the event parameter
	 * @since v1.0
	 */
	public function onAfterDelete($event)
	{
		$this->raiseEvent('onAfterDelete',$event);
	}

	/**
	 * This event is raised before finder performs a find call.
	 * In this event, the {@link CModelEvent::criteria} property contains the query criteria
	 * passed as parameters to those find methods. If you want to access
	 * the query criteria specified in scopes, please use {@link getDbCriteria()}.
	 * You can modify either criteria to customize them based on needs.
	 * @param CModelEvent $event the event parameter
	 * @see beforeFind
	 * @since v1.0
	 */
	public function onBeforeFind($event)
	{
		$this->raiseEvent('onBeforeFind',$event);
	}

	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 * @since v1.0
	 */
	public function onAfterFind($event)
	{
		$this->raiseEvent('onAfterFind',$event);
	}

	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 * @since v1.0
	 */
	public function beforeSave()
	{
		if($this->hasEventHandler('onBeforeSave'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeSave($event);
				
			Yii::log("signatureNew event::".CVarDumper::dumpAsString($event->isValid), CLogger::LEVEL_INFO);
			return $event->isValid;
		}
		else
		return true;
	}

	/**
	 * This method is invoked after saving a record successfully.
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do postprocessing after record saving.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @since v1.0
	 */
	public function afterSave()
	{
		if($this->hasEventHandler('onAfterSave'))
		$this->onAfterSave(new CEvent($this));
	}

	/**
	 * This method is invoked before deleting a record.
	 * The default implementation raises the {@link onBeforeDelete} event.
	 * You may override this method to do any preparation work for record deletion.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the record should be deleted. Defaults to true.
	 * @since v1.0
	 */
	public function beforeDelete()
	{
		if($this->hasEventHandler('onBeforeDelete'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeDelete($event);
			return $event->isValid;
		}
		else
		return true;
	}

	/**
	 * This method is invoked after deleting a record.
	 * The default implementation raises the {@link onAfterDelete} event.
	 * You may override this method to do postprocessing after the record is deleted.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @since v1.0
	 */
	public function afterDelete()
	{
		if($this->hasEventHandler('onAfterDelete'))
		$this->onAfterDelete(new CEvent($this));
	}

	/**
	 * This method is invoked before an AR finder executes a find call.
	 * The find calls include {@link find}, {@link findAll}, {@link findByPk},
	 * {@link findAllByPk}, {@link findByAttributes} and {@link findAllByAttributes}.
	 * The default implementation raises the {@link onBeforeFind} event.
	 * If you override this method, make sure you call the parent implementation
	 * so that the event is raised properly.
	 *
	 * Starting from version 1.1.5, this method may be called with a hidden {@link CDbCriteria}
	 * parameter which represents the current query criteria as passed to a find method of AR.
	 * @since v1.0
	 */
	public function beforeFind()
	{
		if($this->hasEventHandler('onBeforeFind'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeFind($event);
			return $event->isValid;
		}
		else
		return true;
	}

	/**
	 * This method is invoked after each record is instantiated by a find method.
	 * The default implementation raises the {@link onAfterFind} event.
	 * You may override this method to do postprocessing after each newly found record is instantiated.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @since v1.0
	 */
	public function afterFind()
	{
		if($this->hasEventHandler('onAfterFind'))
		$this->onAfterFind(new CEvent($this));
	}

	/**
	 * Creates an document instance.
	 * This method is called by {@link populateRecord} and {@link populateRecords}.
	 * You may override this method if the instance being created
	 * depends the attributes that are to be populated to the record.
	 * @param array $attributes list of attribute values for the active records.
	 * @return EMongoDocument the document
	 * @since v1.0
	 */
	protected function instantiate($attributes)
	{
		$class=get_class($this);
		$model=new $class(null);
		$model->initEmbeddedDocuments();
		$model->setAttributes($attributes, false);
		return $model;
	}

	/**
	 * Creates an EMongoDocument with the given attributes.
	 * This method is internally used by the find methods.
	 * @param array $attributes attribute values (column name=>column value)
	 * @param boolean $callAfterFind whether to call {@link afterFind} after the record is populated.
	 * This parameter is added in version 1.0.3.
	 * @return EMongoDocument the newly created document. The class of the object is the same as the model class.
	 * Null is returned if the input data is false.
	 * @since v1.0
	 */
	public function populateRecord($document, $callAfterFind=true)
	{
		$this->_doc = $document;
		Yii::log("native mongo document loaded..".$document["_id"], CLogger::LEVEL_ERROR);
		if($document!==null)
		{
			$model=$this->instantiate($document);
			$model->setScenario('update');
			$model->init();

			$model->attachBehaviors($model->behaviors());

			if($callAfterFind)
			$model->afterFind();
			$model->_doc = $document;
			return $model;
		}
		else
		return null;
	}

	/**
	 * Creates a list of documents based on the input data.
	 * This method is internally used by the find methods.
	 * @param array $data list of attribute values for the active records.
	 * @param boolean $callAfterFind whether to call {@link afterFind} after each record is populated.
	 * This parameter is added in version 1.0.3.
	 * @param string $index the name of the attribute whose value will be used as indexes of the query result array.
	 * If null, it means the array will be indexed by zero-based integers.
	 * @return array list of active records.
	 * @since v1.0
	 */
	public function populateRecords($data, $callAfterFind=true, $index=null)
	{
		$records=array();
		foreach($data as $attributes)
		{
			if(($record=$this->populateRecord($attributes,$callAfterFind))!==null)
			{
				if($index===null)
				$records[]=$record;
				else
				$records[$record->$index]=$record;
			}
		}
		return $records;
	}

	/**
	 * Magic search method, provides basic search functionality.
	 *
	 * Returns EMongoDocument object ($this) with criteria set to
	 * rexexp: /$attributeValue/i
	 * used for Data provider search functionality
	 * @param boolean $caseSensitive whathever do a case-sensitive search, default to false
	 * @return EMongoDocument
	 * @since v1.2.2
	 */
	public function search($caseSensitive = false)
	{
		//return $this;
		$criteria = $this->getDbCriteria();

		foreach($this->getSafeAttributeNames() as $attribute)
		{
			if($this->$attribute !== null && $this->$attribute !== '')
			{
				if(is_array($this->$attribute) || is_object($this->$attribute))
				$criteria->$attribute = $this->$attribute;
				else if(preg_match('/^(?:\s*(<>|<=|>=|<|>|=|!=|==))?(.*)$/',$this->$attribute,$matches))
				{
					$op = $matches[1];
					$value = $matches[2];

					if($op === '=') $op = '==';

					if($op !== '')
					call_user_func(array($criteria, $attribute), $op, is_numeric($value) ? floatval($value) : $value);
					else
					$criteria->$attribute = new MongoRegex($caseSensitive ? '/'.$this->$attribute.'/' : '/'.$this->$attribute.'/i');
				}
			}
		}

		$this->setDbCriteria($criteria);

		//return new EMongoDocumentDataProvider($this);
		return $this;
	}

	/**
	 * Returns the static model of the specified EMongoDocument class.
	 * The model returned is a static instance of the EMongoDocument class.
	 * It is provided for invoking class-level methods (something similar to static class methods.)
	 *
	 * EVERY derived EMongoDocument class must override this method as follows,
	 * <pre>
	 * public static function model($className=__CLASS__)
	 * {
	 *     return parent::model($className);
	 * }
	 * </pre>
	 *
	 * @param string $className EMongoDocument class name.
	 * @return EMongoDocument EMongoDocument model instance.
	 * @since v1.0
	 */
	public static function model($className=__CLASS__)
	{
		if(isset(self::$_models[$className]))
		return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className(null);
			$model->attachBehaviors($model->behaviors());
			return $model;
		}
	}

	/**
	 * @since v1.2.2
	 */
	private function createPkCriteria($pk, $multiple=false)
	{
		$pkField = $this->primaryKey();
		$criteria = new EMongoCriteria();

		if(is_string($pkField))
		{
			if(!$multiple)
			$criteria->{$pkField} = $pk;
			else
			$criteria->{$pkField}('in', $pk);
		}
		else if(is_array($pkField))
		{
			if(!$multiple)
			for($i=0; $i<count($pkField); $i++)
			$criteria->{$pkField[$i]} = $pk[$i];
			else
			throw new EMongoException(Yii::t('yii', 'Cannot create PK criteria for multiple composite key\'s (not implemented yet)'));
		}

		return $criteria;
	}



	/******************* custom search criteris handlers **************************************************************/
	/**
	 * Assuming fromDAte and toDate are MongoDate instances
	 * Enter description here ...
	 * @param unknown_type $params
	 */
	function  getDateRangeSearchCriteria($params, &$conditions){
		$c = array();

		if(isset($params['fromDate'])){
			$c['$gt']=$params['fromDate'];
		}

		if(isset($params['toDate'])){
			$c['$lt']=$params['toDate'];
		}

		if(count($c)>0){
			$conditions['dateCreated'] = $c;
		}




	}

	function getRangeSearchCriteria($params,$field, &$conditions){
		$c = array();

		if(isset($params['minPrice'])){
			$c['$gt']=$params['minPrice'];
		}

		if(isset($params['maxPrice'])){
			$c['$lt']=$params['maxPrice'];
		}

		if(count($c)>0){
				
			//$fc = array('$all'=>$c);
			$conditions['price'] = $c;
			//return $c;
		}



	}


	function getPriceRangeSearchCriteria($params, &$conditions){
		$c = array();

		if(isset($params['minPrice'])){
			if($params['minPrice'] && $params['minPrice'] !="" && $params['minPrice']!=0)
			$c['$gt']=$params['minPrice'];
		}

		if(isset($params['maxPrice'])){
			if($params['maxPrice'] && $params['maxPrice'] !="" && $params['maxPrice']!=0)
			$c['$lt']=$params['maxPrice'];
		}

		if(count($c)>0){
			$conditions['price'] = $c;
		}

	}




	function getLocationSearchCriteria($params, &$conditions){

		$c = array();
		$fc = array();
	  
		$ldef = array('locality', 'location', 'city', 'region', 'country');

		foreach ($ldef as $lk){
			$lv = isset($params[$lk])?$params[$lk]:null;
			if ($lv != null && $lv != "") {
				$k1 = strtolower( trim($lv));
				if($k1 != ''){
					$regexObjKeywords = new MongoRegex("/.*".$k1.".*/i");
					//$k[] = array($lk => array('$regex'=> $regexObjKeywords) );//$k1;
					$conditions[$lk] = $regexObjKeywords;//array('$regex'=> $regexObjKeywords);
					//$k[] = $regexObjKeywords;
				}
			}
		}


			
	}


	function addSearchCriteriaRegExFull($params,$name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}

		$searchValue = isset($params[$name])?$params[$name]:null;
		if ($searchValue != null && $searchValue != "") {
			$regexObjKeywords = new MongoRegex("/.*".$searchValue.".*/i");
			//$k[] = array($lk => array('$regex'=> $regexObjKeywords) );//$k1;
			$conditions[$property] = $regexObjKeywords;//array('$regex'=> $regexObjKeywords);
		}
			
	}



	function addSearchCriteriaRegExEnd($params,$name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}
		$searchValue = isset($params[$name])?$params[$name]:null;
		if ($searchValue != null && $searchValue != "") {
			$regexObjKeywords = new MongoRegex("/".$searchValue.".*/i");
			//$k[] = array($lk => array('$regex'=> $regexObjKeywords) );//$k1;
			$conditions[$property] = $regexObjKeywords;//array('$regex'=> $regexObjKeywords);
		}
			
	}

	function addSearchCriteria($params,$name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}
		$searchValue = isset($params[$name])?$params[$name]:null;
		if ($searchValue != null && $searchValue != "") {
			$regexObjKeywords = new MongoRegex("/".$searchValue."/i");
			//$k[] = array($lk => array('$regex'=> $regexObjKeywords) );//$k1;
			$conditions[$property] = $regexObjKeywords;//array('$regex'=> $regexObjKeywords);
		}
			
	}

	function addSearchCriteriaById($params,$name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}
		 
		$searchValue = isset($params["_id"])?$params["_id"]:null;
		if ($searchValue != null && $searchValue != "") {
		  
			$conditions[$property] = $searchValue;//array('$regex'=> $regexObjKeywords);
		}
			
	}



	function addTagSearchCriteria($params,$name, &$conditions){

		// not implemented
			
	}

	function addInterestsSearchCriteria($params,$name, &$conditions){

		// not implemented
			
	}

	function addKeywordsSearchCriteria($params, &$conditions){
		$keywords = isset($params['keywords']) ? $params['keywords'] : null;
	  
		if($keywords){
			$keywordsList = $this->csvToArrayRegEx($keywords);

			// =
			//$criteria->tags = new MongoRegex('/'.$keywords.'.*/i');
			//$conditions['tags'] =  new MongoRegex('/'.$keywords.'.*/i');
				
			if($keywordsList && !empty($keywordsList)){
				$tagsConditions = array('$in' => $keywordsList);
				$titleConditions = array('$in' => $keywordsList);
				$categorryConditions = array('$in' => $keywordsList);
					
				$conditions['$or'] =  array(array('tags'=>$tagsConditions), array("title"=>$titleConditions), array("categories"=>$categorryConditions));
				//$conditions['$or'] = array(array('keywords'=>$tagsConditions));
			}

		}


	}

	function addCatgeoriesSearchCriteria($params, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}

		if(isset($params['category']) && $params['category']!=''){
			$categories = $params['category'];
			if(!is_array($categories)){
				$categories = explode(",", $categories) ;
			}
				
			if( !empty($categories)){
					
				$conditions['categories'] = array('$in' => $categories);
			}
				
		}

	}

	function addInSearchCriteria($params, $name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}

		if(isset($params[$name]) && $params[$name]!=''){
			$categories = $params[$name];
			if(!is_array($categories)){
				$categories = explode(",", $categories) ;
			}
				
			if( !empty($categories)){
				$conditions[$property] = array('$in' => $categories);
			}
				
		}

	}




	function csvToArrayFromParams($params, $key, $delimiter=","){

		$keywords = array();
		if ($params[$key] && $params[$key] != "") {
			$keywords = $this->csvToArray( $value, $delimiter);
			 
		}
		 
		return $keywords;
	}


	function csvToArray( $value, $delimiter=","){
		$keywords = array();
		if ($value) {
			$keywords = explode(",",$value);
			 
			if ($keywords && count($keywords) > 0) {
				$k = array();
				foreach($keywords as $k1){
					 
					$k1 = strtolower( trim($k1));
					if($k1 != '')
					$k[] = $k1;
					 
				}
			}
			 
		}

		return $keywords;
		 
	}


	function csvToArrayRegEx( $value, $delimiter=","){
		$k = array();
		$keywords = array();
		if ($value) {
			$keywords = explode(",",$value);
			 
			if ($keywords && count($keywords) > 0) {
				 
				foreach($keywords as $k1){
					 
					$k1 = strtolower( trim($k1));
					if($k1 != ''){
						$regexObjKeywords = new MongoRegex("/".$k1.".*/i");
						//$k[] = array('$regex'=> $regexObjKeywords);//$k1;
						$k[] = $regexObjKeywords;
					}
				}
			}
			 
		}

		return $k;
		 
	}


	function addGeoCodeSearch(){
		/** geo code based search --
		 if(isset($appContext['absLocation']) && $appContext['absLocation']){
			$absLocation = $appContext['absLocation'];
				
			if(isset($appContext['geoLocation']) && isset($appContext['geoLocation']['geo'])){
			$geoLocation = $appContext['geoLocation'];
			$geo = $geoLocation['geo'];
			 
			//$db->command(array('geoNear'=>'places','near'=>array(151.1955562233925,-33.87107475181752),'num'=>9));
			//$c = array('$near'=> $geo, '$maxDistance'=> 1);
			 
			$radius = $_SESSION['appContext']['radius'] ;
			$c = array('$near'=> $geo, '$maxDistance'=> $radius);
			 
			//Yii::log("geo search lat:".$geo[0]." lng:".$geo[1], CLogger::LEVEL_ERROR);
			$conditions["geo"]= $c ;
			 
			}else{
			$regexObjLocation = new MongoRegex("/".$absLocation."/i");
			$conditions["absLocation"] = $regexObjLocation ;
			}

			 
			}**/
		 
	}

	/**
	 *
	 * Common Generic search mechanisms for:
	 *
	 * People
	 * Places
	 * etc...
	 *
	 * The implememtation shall implement : public function getDataProvider($params, $modelClass = "YumProfile")
	 * and use these methods internally
	 */
	/**
	 *
	 *
	 * Enter description here ...
	 * @param unknown_type $params
	 * @param unknown_type $modelClass ex: $modelClass = "YumProfile"
	 */
	public function getGenericPeopleSearchDataProvider($modelClass, $params,  $options = array())
	{

		YII::log("getGenericPeopleSearchDataProvider ::", CLogger::LEVEL_ERROR);

		$db = Yii::app()->dbService->getDB();

		$appContext = $params;

		$conditions = array();


		//get incoming params
		$this->addSearchCriteriaRegExFull($appContext,'term', $conditions, 'name');
		$this->addSearchCriteriaRegExFull($appContext,'name', $conditions);
		$this->addSearchCriteria($appContext,'firstname', $conditions);
		$this->addSearchCriteria($appContext,'lastname', $conditions);
		$this->addSearchCriteria($appContext,'email', $conditions);
		$this->addSearchCriteria($appContext,'phone', $conditions);
		$this->addTagSearchCriteria($appContext,'profession', $conditions);
		$this->addTagSearchCriteria($appContext,'education', $conditions);
		$this->addTagSearchCriteria($appContext,'work', $conditions);
		$this->addInterestsSearchCriteria($appContext,'interest', $conditions);
		$this->addTagSearchCriteria($appContext,'profession', $conditions);
		$this->addKeywordsSearchCriteria($params, &$conditions);
		$this->getDateRangeSearchCriteria($appContext,$conditions);
		$this->getPriceRangeSearchCriteria($appContext,$conditions);
		//$this->getLocationSearchCriteria($appContext,$conditions);
		//$this->addSearchCriteria($appContext,'country', $conditions,'locations.current.country');
		$this->addSearchCriteria($appContext,'country', $conditions,'locations.current.country');
		$this->addSearchCriteria($appContext,'region', $conditions,'locations.region');
		$this->addSearchCriteria($appContext,'city', $conditions,'locations.city');


		Yii::log("searchm $params :".CVarDumper::dumpAsString($params), CLogger::LEVEL_INFO);
		Yii::log("searchm conditions :".CVarDumper::dumpAsString($conditions), CLogger::LEVEL_INFO);
		Yii::log("search appContext :".CVarDumper::dumpAsString($appContext), CLogger::LEVEL_INFO);
		//$criteriav['native'] = $conditions;

		//create criteria object
		//$criteriav['sort']=>array('_id'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
		//$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;


		 
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;


	}



	public function getGenericGroupSearchDataProvider($modelClass, $params,  $options = array())
	{

		YII::log("getGenericPeopleSearchDataProvider ::", CLogger::LEVEL_ERROR);

		$db = Yii::app()->dbService->getDB();

		$appContext = $params;

		$conditions = array();


		//get incoming params

		$this->addSearchCriteriaRegExFull($appContext,'term', $conditions, 'name');
		$this->addSearchCriteriaRegExFull($appContext,'name', $conditions);
		$this->addInSearchCriteria($appContext,'groupType', $conditions);
		$this->addInSearchCriteria($appContext,'category', $conditions,'categories');
		$this->addKeywordsSearchCriteria($params, &$conditions);
		$this->getDateRangeSearchCriteria($appContext,$conditions);
		$this->getPriceRangeSearchCriteria($appContext,$conditions);
		//$this->getLocationSearchCriteria($appContext,$conditions);
		//$this->addSearchCriteria($appContext,'country', $conditions,'locations.current.country');
		$this->addSearchCriteria($appContext,'country', $conditions,'locations.country');
		$this->addSearchCriteria($appContext,'region', $conditions,'locations.region');
		$this->addSearchCriteria($appContext,'city', $conditions,'locations.city');


		Yii::log("searchm $params :".CVarDumper::dumpAsString($params), CLogger::LEVEL_INFO);
		Yii::log("searchm conditions :".CVarDumper::dumpAsString($conditions), CLogger::LEVEL_INFO);
		Yii::log("search appContext :".CVarDumper::dumpAsString($appContext), CLogger::LEVEL_INFO);
		//$criteriav['native'] = $conditions;

		//create criteria object
		//$criteriav['sort']=>array('_id'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
		//$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);

		if(!$options['limit']){
			$options['limit'] = 20;
		}
		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;


		 
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;


	}







	/***
	 *
	 * $names =   array('ajay', 'loki', 'neeraj')
	 */
	public function  findAllByNames2($names, $modelClass="YumProfile"){
		//$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		$criteria = new EMongoCriteria($options);
		$criteria->native = array('firstname'=> array('$in'=>$names));


		 
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;
	}

	// $regexObjKeywords = new MongoRegex("/.*".$searchValue.".*/i");
	public function  findAllByNameLike($name, $modelClass="YumProfile"){
		//$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		$criteria = new EMongoCriteria($options);
		$criteria->native = array('name'=> new MongoRegex("/.*".$name.".*/i") , 'age'=>array('$lt'=>10) );


		 
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;
	}

	/**
	 *
	 * Common Generic search mechanisms for:
	 *
	 * People
	 * Places
	 * etc...
	 *
	 * The implememtation shall implement : public function getDataProvider($params, $modelClass = "YumProfile")
	 * and use these methods internally
	 */
	/**
	 *
	 *
	 * Enter description here ...
	 * @param unknown_type $params
	 * @param unknown_type $modelClass
	 */
	public function getGenericMessageSearchDataProvider($modelClass,$params,  $options=array())
	{

		YII::log("getGenericPeopleSearchDataProvider ::", CLogger::LEVEL_ERROR);

		$db = Yii::app()->dbService->getDB();

		$appContext = $params;
		$conditions = $params;


		//get incoming params
		//$this->addSearchCriteria($appContext,'targetId', $conditions);


		Yii::log("searchm $params :".CVarDumper::dumpAsString($params), CLogger::LEVEL_INFO);
		Yii::log("searchm conditions :".CVarDumper::dumpAsString($conditions), CLogger::LEVEL_INFO);
		Yii::log("search appContext :".CVarDumper::dumpAsString($appContext), CLogger::LEVEL_INFO);
		//$criteriav['native'] = $conditions;

		//create criteria object
		//$criteriav['sort']=>array('_id'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
		$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		if(!isset($options['limit'])){
			$options['limit'] = 50;
		}
		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;

		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;

	}


	public function getGenericStatusSearchDataProvider($params, $modelClass = "StatusStream")
	{

		YII::log("getGenericPeopleSearchDataProvider ::", CLogger::LEVEL_ERROR);


		$appContext = $params;
		$options = array();
		$conditions = array();


		//get incoming params
		if(isset($params['targets'])){
			$conditions['targets'] = $params['targets'];
		}
		//$this->addSearchCriteria($appContext,'targets', $conditions);


		Yii::log("searchm $params :".CVarDumper::dumpAsString($params), CLogger::LEVEL_INFO);
		Yii::log("searchm conditions :".CVarDumper::dumpAsString($conditions), CLogger::LEVEL_INFO);
		Yii::log("search appContext :".CVarDumper::dumpAsString($appContext), CLogger::LEVEL_INFO);
		//$criteriav['native'] = $conditions;

		//create criteria object
		//$criteriav['sort']=>array('_id'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
		$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;


		 
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;


	}



	public static function getGenericSearchDataProvider($conditions, $options, $modelClass )
	{

		YII::log("getGenericPeopleSearchDataProvider ::", CLogger::LEVEL_ERROR);


		if(!$options)
		$options = array();
		 

		//create criteria object
		//$criteriav['sort']=>array('_id'=>EMongoCriteria::SORT_ASC, 'fieldName2'=>EMongoCriteria::SORT_DESC),
		if(!$options['sort']){
			$options['sort']=array('dateCreated'=>EMongoCriteria::SORT_DESC);
		}


		$criteria = new EMongoCriteria($options);
		$criteria->native = $conditions;
		$model = EMongoDocument::model($modelClass);
		$model->setDbCriteria($criteria);

		$dataProvider=new EMongoDocumentDataProvider($model);
		return $dataProvider;


	}


	public static function  findAllByContext($context, $options=array()){

		if(!$options){
			$options = array('sort'=>array('name'=>1));
		}
		return ContentType::model()->findAllByNative(array('context'=>$context), $options)	;
	}

	public function getAllAssociatedGraphObjectsGids(){
		Yii::log("[FATAL] This object MUST implement getAllAssociatedGraphObjectsGids @see signature specs", CLogger::LEVEL_ERROR);

		return array();
	}

	public static function s_toGids($context, $ids){
		if(!$ids || count($ids)<=0)return array();

		$gids = array();
		foreach ($ids as $id){
			$gids[] = $context."_".$id;
			 
		}

		return $gids;
	}

}
