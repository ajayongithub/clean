<?php
/**
 * EMongoEmbeddedDocument.php
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
 * @since		v1.0.8
 */

/**
 * @since v1.0.8
 */
abstract class EMongoEmbeddedDocument extends CModel
{

	public static $DRAFT = 'D';
	public static $LIVE = 'L';
	public static $OLD = 'O';
	public static $BLOCKED = 'B';
	public static $DELETED='DL';
	
public static function getGUID(){
		if (function_exists('com_create_guid22')){
			return com_create_guid();
		}else{
			//rand(microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = ""//chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12);
			//.chr(125);// "}"
			return $uuid;
		}
	}
	public  function  identity(){
		return $this->_id->__toString();
	}
	
	public static function toMongoId($id){
		if($id instanceof MongoId){
			return $id;
		}
		
		return new MongoId($id);
	}
	

	public static function  statusListBox(){
		return CHtml::listData(self::$STATUS, 'name', 'label');
	}

	public  function  getStatusSummary(){

		if(!$this->status){
			return "Live";
		}

		switch($this->status){
			case 'D': return 'Draft';
			case 'L': return 'Live';
			case 'O': return 'Old';
			case 'B': return 'Blocked';

		}
			
		return 'Live';
	}

	public static $STATUS = array(
	array('label'=>'Draft', 'name'=>'D')
	,array('label'=>'Live', 'name'=>'L')
	,array('label'=>'Old', 'name'=>'O')

	);

	public static $GROUP_TYPES = array(
	array('label'=>'Private', 'name'=>'private')
	,array('label'=>'Restricted', 'name'=>'restricted')
	,array('label'=>'Public', 'name'=>'public')

	);
	public function tempDir(){
		return  Yii::getPathOfAlias('webroot') .'/uf/images';// folder for uploaded files
	}

	public function getGid(){
		return $this->getNodeType()."_".$this->identity();
	}
	public function getNodeType(){
		return get_class($this);
	}


	public function getViewUrl(){

		return Yii::app()->createUrl("//".$this->getNodeType()."/view", array('id'=>$this->identity()));
	}

	public function getName(){

		$r = new ReflectionClass(get_class($this));

		if($r->hasProperty("name")){
			return $this->name;
		}

		if($r->hasProperty("title")){
			return $this->title;
		}

		return "";
	}
	public function getSummary(){

		$r = new ReflectionClass(get_class($this));

		if($r->hasProperty("name")){
			return $this->name;
		}

		if($r->hasProperty("title")){
			return $this->title;
		}

		return "";
	}

	public function getHeadline(){

		$r = new ReflectionClass(get_class($this));


		if($r->hasProperty("headline")){
			return $this->headline?$this->headline:" - ";
		}

		if($r->hasProperty("name")){
			return $this->name;
		}

		if($r->hasProperty("title")){
			return $this->title;
		}

		return "";
	}


	public function getLoc(){

		$location = $this->getLocation("current");
		if(!$location)return " - ";

		return $location->getLocationAsHuman();
	}




	private static $_attributes=array();

	/**
	 * CMap of embedded documents
	 * @var CMap $_embedded
	 * @since v1.0.8
	 */
	protected $_embedded=null;

	/**
	 * Cacheed values for embeddedDocuments() method vall
	 * @var array $_embeddedConfig
	 * @since v1.3.2
	 */
	protected static $_embeddedConfig = array();

	/**
	 * Hold down owner pointer (if any)
	 *
	 * @var EMongoEmbeddedDocument $_owner
	 * @since v1.0.8
	 */
	protected $_owner=null;

	public function autoFields(){
		return array();
	}

	/**
	 * Constructor.
	 * @param string $scenario name of the scenario that this model is used in.
	 * See {@link CModel::scenario} on how scenario is used by models.
	 * @see getScenario
	 * @since v1.0.8
	 */
	public function __construct($scenario='insert')
	{
		$this->setScenario($scenario);
		$this->init();
		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();

		$this->initEmbeddedDocuments();
	}

	/**
	 * Initializes this model.
	 * This method is invoked in the constructor right after {@link scenario} is set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 * @since 1.0.8
	 */
	public function init(){}

	/**
	 * @since v1.0.8
	 */
	protected function initEmbeddedDocuments()
	{
		if(!$this->hasEmbeddedDocuments() || !$this->beforeEmbeddedDocsInit())
		return false;

		$this->_embedded = new CMap;
		if(!isset(self::$_embeddedConfig[get_class($this)]))
		self::$_embeddedConfig[get_class($this)] = $this->embeddedDocuments();
		$this->afterEmbeddedDocsInit();
	}

	/**
	 * @since v1.0.8
	 */
	public function onBeforeEmbeddedDocsInit($event)
	{
		$this->raiseEvent('onBeforeEmbeddedDocsInit', $event);
	}

	/**
	 * @since v1.0.8
	 */
	public function onAfterEmbeddedDocsInit($event)
	{
		$this->raiseEvent('onAfterEmbeddedDocsInit', $event);
	}

	/**
	 * @since v1.0.8
	 */
	public function onBeforeToArray($event)
	{
		$this->raiseEvent('onBeforeToArray', $event);
	}

	/**
	 * @since v1.0.8
	 */
	public function onAfterToArray($event)
	{
		$this->raiseEvent('onAfterToArray', $event);
	}

	/**
	 * @since v1.0.8
	 */
	protected function beforeToArray()
	{
		$event = new CModelEvent($this);
		$this->onBeforeToArray($event);
		return $event->isValid;
	}

	/**
	 * @since v1.0.8
	 */
	protected function afterToArray()
	{
		$this->onAfterToArray(new CModelEvent($this));
	}

	/**
	 * @since v1.0.8
	 */
	protected function beforeEmbeddedDocsInit()
	{
		$event=new CModelEvent($this);
		$this->onBeforeEmbeddedDocsInit($event);
		return $event->isValid;
	}

	/**
	 * @since v1.0.8
	 */
	protected function afterEmbeddedDocsInit()
	{
		$this->onAfterEmbeddedDocsInit(new CModelEvent());
	}

	/**
	 * @since v1.0.8
	 */
	public function __get($name)
	{
		if($this->hasEmbeddedDocuments() && isset(self::$_embeddedConfig[get_class($this)][$name])) {
			// Late creation of embedded documents on first access
			if (is_null($this->_embedded->itemAt($name))) {
				$docClassName = self::$_embeddedConfig[get_class($this)][$name];
				$doc = new $docClassName($this->getScenario());
				$doc->setOwner($this);
				$this->_embedded->add($name, $doc);
			}
			return $this->_embedded->itemAt($name);
		}
		else
		return parent::__get($name);
	}

	/**
	 * @since v1.0.8
	 */
	public function __set($name, $value)
	{
		if($this->hasEmbeddedDocuments() && isset(self::$_embeddedConfig[get_class($this)][$name]))
		{
			if(is_array($value)) {
				// Late creation of embedded documents on first access
				if (is_null($this->_embedded->itemAt($name))) {
					$docClassName = self::$_embeddedConfig[get_class($this)][$name];
					$doc = new $docClassName($this->getScenario());
					$doc->setOwner($this);
					$this->_embedded->add($name, $doc);
				}
				return $this->_embedded->itemAt($name)->attributes=$value;
			}
			else if($value instanceof EMongoEmbeddedDocument)
			return $this->_embedded->add($name, $value);
		}
		else
		parent::__set($name, $value);
	}

	/**
	 * @since v1.3.2
	 * @see CComponent::__isset()
	 */
	public function __isset($name) {
		if($this->hasEmbeddedDocuments() && isset(self::$_embeddedConfig[get_class($this)][$name]))
		{
			return isset($this->_embedded[$name]);
		}
		else
		return parent::__isset($name);
	}

	/**
	 * @since v1.0.8
	 */
	public function afterValidate()
	{
		if($this->hasEmbeddedDocuments())
		foreach($this->_embedded as $doc)
		{
			if(!$doc->validate())
			{
				$this->addErrors($doc->getErrors());
			}
		}
	}

	/**
	 * @since v1.0.8
	 */
	public function embeddedDocuments()
	{
		return array();
	}

	/**
	 * @since v1.0.8
	 */
	public function hasEmbeddedDocuments()
	{
		if(isset(self::$_embeddedConfig[get_class($this)]))
		return true;
		return count($this->embeddedDocuments()) > 0;
	}

	/**
	 * Returns the list of attribute names.
	 * By default, this method returns all public properties of the class.
	 * You may override this method to change the default.
	 * @return array list of attribute names. Defaults to all public properties of the class.
	 * @since v1.0.8
	 */
	public function attributeNames()
	{
		$className=get_class($this);
		if(!isset(self::$_attributes[$className]))
		{
			$class=new ReflectionClass(get_class($this));
			$names=array();
			foreach($class->getProperties() as $property)
			{
				$name=$property->getName();
				if($property->isPublic() && !$property->isStatic())
				$names[]=$name;
			}
			if($this->hasEmbeddedDocuments())
			{
				$names = array_merge($names, array_keys(self::$_embeddedConfig[get_class($this)]));
			}
			return self::$_attributes[$className]=$names;
		}
		else
		return self::$_attributes[$className];
	}

	/**
	 * Returns the given object as an associative array
	 * Fires beforeToArray and afterToArray events
	 * @return array an associative array of the contents of this object
	 * @since v1.0.8
	 */
	public function toArray()
	{
		if($this->beforeToArray())
		{
			$arr = $this->_toArray();
			$this->afterToArray();
			return $arr;
		}
		else
		return array();
	}

	/**
	 * This method does the actual convertion to an array
	 * Does not fire any events
	 * @return array an associative array of the contents of this object
	 * @since v1.3.4
	 */
	protected function _toArray()
	{
		$arr = array();
		$class=new ReflectionClass(get_class($this));
		foreach($class->getProperties() as $property)
		{
			$name=$property->getName();
			if($property->isPublic() && !$property->isStatic() && $name !='doc')
			$arr[$name] = $this->$name;
		}

		//loki:
		//if(isset($arr['doc'])){
		//	$arr['doc'] = null;
		//}
		if($this->hasEmbeddedDocuments())
		foreach($this->_embedded as $key=>$value)
		$arr[$key]=$value->toArray();

		return $arr;
	}

	/**
	 * Return owner of this document
	 * @return EMongoEmbeddedDocument
	 * @since v1.0.8
	 */
	public function getOwner()
	{
		if($this->_owner!==null)
		return $this->_owner;
		else
		return null;
	}

	/**
	 * Set owner of this document
	 * @param EMongoEmbeddedDocument $owner
	 * @since v1.0.8
	 */
	public function setOwner(EMongoEmbeddedDocument $owner)
	{
		$this->_owner = $owner;
	}

	/**
	 * Override default seScenario method for populating to embedded records
	 * @see CModel::setScenario()
	 * @since v1.0.8
	 */
	public function setScenario($value)
	{
		if($this->hasEmbeddedDocuments() && $this->_embedded !== null)
		{
			foreach($this->_embedded as $doc)
			$doc->setScenario($value);
		}
		parent::setScenario($value);
	}




	//todo custom

	/**
	 * Responds to {@link CActiveRecord::onBeforeSave} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * You may set {@link CModelEvent::isValid} to be false to quit the saving process.
	 * @param CModelEvent $event event parameter
	 */
	protected function onBeforeSave($event)
	{
		$this->raiseEvent('onBeforeSave',$event);
	}
	/**
	 * Responds to {@link CActiveRecord::onBeforeSave} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * You may set {@link CModelEvent::isValid} to be false to quit the saving process.
	 * @param CModelEvent $event event parameter
	 */
	public function beforeSave($event)
	{
	}


	/**
	 * Responds to {@link CActiveRecord::onAfterSave} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * @param CModelEvent $event event parameter
	 */
	public function onAfterSave($event)
	{
		$this->raiseEvent('onAfterSave',$event);
	}
	/**
	 * Responds to {@link CActiveRecord::onAfterSave} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * @param CModelEvent $event event parameter
	 */
	public function afterSave($event)
	{
	}

	/**
	 * Responds to {@link CActiveRecord::onBeforeDelete} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * You may set {@link CModelEvent::isValid} to be false to quit the deletion process.
	 * @param CEvent $event event parameter
	 */
	public function onBeforeDelete($event)
	{
		$this->raiseEvent('onBeforeDelete',$event);
	}
	public function beforeDelete($event)
	{
	}

	/**
	 * Responds to {@link CActiveRecord::onAfterDelete} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * @param CEvent $event event parameter
	 */
	public function onAfterDelete($event)
	{
		$this->raiseEvent('onAfterDelete',$event);
	}
	public function afterDelete($event)
	{
	}

	/**
	 * Responds to {@link CActiveRecord::onBeforeFind} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * @param CEvent $event event parameter
	 * @since 1.0.9
	 */
	public function onBeforeFind($event)
	{
	}
	public function beforeFind($event)
	{
	}

	/**
	 * Responds to {@link CActiveRecord::onAfterFind} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * @param CEvent $event event parameter
	 */
	public function onAfterFind($event)
	{
	}
	public function afterFind($event)
	{
	}




	////////////////////// custom date/time utils  ///////////////////////////////////////////

	/**
	 * Returns a nicely formatted date string for given Datetime string.
	 *
	 * @param string $dateString Datetime string
	 * @param int $format Format of returned date
	 * @return string Formatted date string
	 */
	public static function nice($dateString = null, $format = 'D, M jS Y, H:i') {

		$date = ($dateString == null) ? time() : strtotime($dateString);
		return date($format, $date);
	}

	/**
	 * Returns a formatted descriptive date string for given datetime string.
	 *
	 * If the given date is today, the returned string could be "Today, 6:54 pm".
	 * If the given date was yesterday, the returned string could be "Yesterday, 6:54 pm".
	 * If $dateString's year is the current year, the returned string does not
	 * include mention of the year.
	 *
	 * @param string $dateString Datetime string or Unix timestamp
	 * @return string Described, relative date string
	 */
	public static function niceShort($dateString = null) {
		$date = ($dateString == null) ? time() : strtotime($dateString);

		$y = (self::isThisYear($date)) ? '' : ' Y';

		if (self::isToday($date)) {
			$ret = sprintf('Today, %s', date("g:i a", $date));
		} elseif (self::wasYesterday($date)) {
			$ret = sprintf('Yesterday, %s', date("g:i a", $date));
		} else {
			$ret = date("M jS{$y}, H:i", $date);
		}

		return $ret;
	}

	/**
	 * Returns true if given date is today.
	 *
	 * @param string $date Unix timestamp
	 * @return boolean True if date is today
	 */
	public static function isToday($date) {
		return date('Y-m-d', $date) == date('Y-m-d', time());
	}

	/**
	 * Returns true if given date was yesterday
	 *
	 * @param string $date Unix timestamp
	 * @return boolean True if date was yesterday
	 */
	public static function wasYesterday($date) {
		return date('Y-m-d', $date) == date('Y-m-d', strtotime('yesterday'));
	}

	/**
	 * Returns true if given date is in this year
	 *
	 * @param string $date Unix timestamp
	 * @return boolean True if date is in this year
	 */
	public static function isThisYear($date) {
		return date('Y', $date) == date('Y', time());
	}

	/**
	 * Returns true if given date is in this week
	 *
	 * @param string $date Unix timestamp
	 * @return boolean True if date is in this week
	 */
	public static function isThisWeek($date) {
		return date('W Y', $date) == date('W Y', time());
	}

	/**
	 * Returns true if given date is in this month
	 *
	 * @param string $date Unix timestamp
	 * @return boolean True if date is in this month
	 */
	public static function isThisMonth($date) {
		return date('m Y',$date) == date('m Y', time());
	}


	public static function isTimeGreaterThanInMin($timeInSeconds, $compareInMinutes){
		$now = time();
			
		$diff = $now - $timeInSeconds;

		// If more than a week, then take into account the length of months
		//if ($diff >= 604800) {
		if($diff >= $compareInMinutes*60){
			return true;

		}

		return false;

	}
	/**
	 * Returns either a relative date or a formatted date depending
	 * on the difference between the current time and given datetime.
	 * $datetime should be in a <i>strtotime</i>-parsable format, like MySQL's datetime datatype.
	 *
	 * Options:
	 *  'format' => a fall back format if the relative time is longer than the duration specified by end
	 *  'end' =>  The end of relative time telling
	 *
	 * Relative dates look something like this:
	 *	3 weeks, 4 days ago
	 *	15 seconds ago
	 * Formatted dates look like this:
	 *	on 02/18/2004
	 *
	 * The returned string includes 'ago' or 'on' and assumes you'll properly add a word
	 * like 'Posted ' before the function output.
	 *
	 * @param string $dateString Datetime string
	 * @param array $options Default format if timestamp is used in $dateString
	 * @return string Relative time string.
	 */
	function timeAgoInWords($dateTime, $options = array()) {
		$now = time();

		if(is_string($dateTime)){
			$inSeconds = strtotime($dateTime);
		}else{
			$inSeconds = $dateTime;
		}

		$backwards = ($inSeconds > $now);

		$format = 'j/n/y';
		$end = '+1 month';

		if (is_array($options)) {
			if (isset($options['format'])) {
				$format = $options['format'];
				unset($options['format']);
			}
			if (isset($options['end'])) {
				$end = $options['end'];
				unset($options['end']);
			}
		} else {
			$format = $options;
		}

		if ($backwards) {
			$futureTime = $inSeconds;
			$pastTime = $now;
		} else {
			$futureTime = $now;
			$pastTime = $inSeconds;
		}
		$diff = $futureTime - $pastTime;

		// If more than a week, then take into account the length of months
		if ($diff >= 604800) {
			$current = array();
			$date = array();

			list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

			list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
			$years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

			if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
				$months = 0;
				$years = 0;
			} else {
				if ($future['Y'] == $past['Y']) {
					$months = $future['m'] - $past['m'];
				} else {
					$years = $future['Y'] - $past['Y'];
					$months = $future['m'] + ((12 * $years) - $past['m']);

					if ($months >= 12) {
						$years = floor($months / 12);
						$months = $months - ($years * 12);
					}

					if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
						$years --;
					}
				}
			}

			if ($future['d'] >= $past['d']) {
				$days = $future['d'] - $past['d'];
			} else {
				$daysInPastMonth = date('t', $pastTime);
				$daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

				if (!$backwards) {
					$days = ($daysInPastMonth - $past['d']) + $future['d'];
				} else {
					$days = ($daysInFutureMonth - $past['d']) + $future['d'];
				}

				if ($future['m'] != $past['m']) {
					$months --;
				}
			}

			if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
				$months = 11;
				$years --;
			}

			if ($months >= 12) {
				$years = $years + 1;
				$months = $months - 12;
			}

			if ($days >= 7) {
				$weeks = floor($days / 7);
				$days = $days - ($weeks * 7);
			}
		} else {
			$years = $months = $weeks = 0;
			$days = floor($diff / 86400);

			$diff = $diff - ($days * 86400);

			$hours = floor($diff / 3600);
			$diff = $diff - ($hours * 3600);

			$minutes = floor($diff / 60);
			$diff = $diff - ($minutes * 60);
			$seconds = $diff;
		}
		$relativeDate = '';
		$diff = $futureTime - $pastTime;

		if ($diff > abs($now - strtotime($end))) {
			$relativeDate = sprintf('on %s', date($format, $inSeconds));
		} else {
			if ($years > 0) {
				// years and months and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . ($years==1 ? 'year':'years');
				$relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . ($months==1 ? 'month':'months') : '';
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks') : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($months) > 0) {
				// months, weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . ($months==1 ? 'month':'months');
				$relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks') : '';
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($weeks) > 0) {
				// weeks and days
				$relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks==1 ? 'week':'weeks');
				$relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days') : '';
			} elseif (abs($days) > 0) {
				// days and hours
				$relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . ($days==1 ? 'day':'days');
				$relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours==1 ? 'hour':'hours') : '';
			} elseif (abs($hours) > 0) {
				// hours and minutes
				$relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours==1 ? 'hour':'hours');
				//$relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes==1 ? 'minute':'minutes') : '';
			} elseif (abs($minutes) > 0) {
				// minutes only
				$relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes==1 ? 'minute':'minutes');
			} else {
				// seconds only
				$relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . ($seconds==1 ? 'second':'seconds');
			}

			if (!$backwards) {
				$relativeDate = sprintf('%s ago', $relativeDate);
			}
		}
		return $relativeDate;
	}

	function ago1($property='dateCreated', $options = array()) {

		if($this->$property){
			$time = $this->$property->sec;
		}else{
			$time = time();
		}

		return timeAgoInWords($time);

	}


	static function  formatPostDate($date, $format='dd/MM/yyyy'){
		if($date && get_class($date)=='MongoDate' ){
			$time = $date->sec;

		}else{

			$time = time();
		}

		$now = time();

		$diff = $now - $time;

		// If more than a week, then take into account the length of months
		if ($diff < 24*60*60) {
			return EMongoEmbeddedDocument::timeAgoInWords($time);


		}

		return Yii::app()->dateFormatter->format('MMM dd', $time);



	}


	function ago($property, $options = array()) {

		if($property && get_class($property)=='MongoDate' ){
			$time = $property->sec;
		}else{
			$time = time();
		}

		return EMongoEmbeddedDocument::timeAgoInWords($time);

	}


	public static function formatDate($date, $format='dd/MM/yyyy'){
			
		if($date && is_object($date) && get_class($date)=="MongoDate"  ){
			return  Yii::app()->dateFormatter->format($format,$date->sec);;
		}

		return $date;
	}


	public static function getDateFromList($dateList){
		if(!$dateList || is_object($dateList)) return $dateList;

		$dateString = null;

		if(is_string($dateList)){
			$dateString = $dateList;
		}


		if(is_array($dateList)){
			if(!isset($dateList['Day'])){
				$dateList['Day'] = '01';
			}

			if(!isset($dateList['Month'])){
				$dateList['Month'] = '01';
			}

			$dateString = strtr('Day/Month/Year', (array) $dateList);
		}

		if(!$dateString)return $dateList;
			
		Yii::log("dateString::".CVarDumper::dumpAsString($dateString), CLogger::LEVEL_INFO);
		$date = CDateTimeParser::parse($dateString, 'd/M/yyyy');

		if($date ){
			return new MongoDate($date);
		}else{
			return null;
		}
	}

	public static function getDate($dateString){
		$date = CDateTimeParser::parse($dateString, 'dd/MM/yyyy');
		if($date ){
			return new MongoDate($date);
		}else{
			return null;
		}
	}




	//////////////  embedded objects operations //////////////////
	public function &addEditEmbeddedArrayObject( $property, &$embeddedObject){
		$object = $this;

		//might be edit operation on embeded
		//if($embeddedObject->oid && $embeddedObject->oid > -1 ){
		if( $embeddedObject->oid > -1 ){
			if($object->$property != null){
				foreach ($object->$property as $i=>$o){
					if($o->oid == $embeddedObject->oid){
						$object->{$property}[$i]= $embeddedObject;
						$object->save();
						return $embeddedObject;
					}
				}

			}
		}


		if(!$object->$property)$object->$property = array();

		if($object->$property != null && count($object->$property)>0){
			$embeddedObject->oid = $object->{$property}[count($object->$property)-1]->oid+1;

		}else{
			$embeddedObject->oid = 0;
		}


		$propertyArray = $object->$property;
		$propertyArray[] = $embeddedObject;
		$object->$property = $propertyArray;

		$object->save();
		return $embeddedObject;

	}



	/**
	 * Remove emebedded object from array at a given index
	 * Enter description here ...
	 * @param unknown_type $type
	 * @param unknown_type $from
	 * @param unknown_type $params
	 */
	public function removeEmbeddedObject($property, $oid){
		$object = $this;

		if($object->$property != null){

			$propertyArray = $object->$property;

			if($propertyArray){
				foreach ($propertyArray as $i=>$embededObject){

					if($embededObject->oid == $oid){
						unset($propertyArray[$i]);
							
					}

				}
			}


			$object->$property = $propertyArray;

			$object->save();
		}

	}



	/**
	 * Get a new OR matched embedded object at a given index
	 * In case matched index : by oid is not located a new object is returned
	 *
	 * Enter description here ...
	 * @param $type
	 * @param $from
	 * @param $params
	 */
	public function &getObject($type, $embeddedCollection, $params){

		$o = new $type(null);
		$o->attributes = $params[$type];

		//might be edit operation on embeded
		if($o->oid && $o->oid>-1){
			if($embeddedCollection != null){
				foreach ($embeddedCollection as $n){
					if($n->oid == $o->oid){
						return $o;
					}
				}

			}
		}else{

			if($embeddedCollection != null){
				$o->oid = count($embeddedCollection);

			}else{
				$o->oid = 0;
			}
		}

		//If reaches here - its add request
		//If reaches here - its add request
		//*** important - type MUST be classname

		return $o;


	}




	//*** important - type MUST be classname
	public function findEmbeddedObjectByOid($type, &$from, $params){


		//might be edit operation on embeded
		if(isset($params['oid'])){
			if($from != null){
				foreach ($from as $i=>$o){
					if($o->oid == $params['oid']){
							
							
						return $o;
					}
				}

			}
		}

		//If reaches here - its add request
		//*** important - type MUST be classname
		$o = new $type(null);
		$o->isNew = true;
			
		/**
			if($type=='WorkExperience'){
			$o = new WorkExperience();
			}

			if($type=='Education'){
			$o = new Education();
			}**/

			
		return $o;

	}


	/**
	 * utility methods that implemented models shall be triggering for automation of social db
	 *
	 *
	 */
	///////////////// tag and classifications DB ///////////////////////////////////////

	/**
	 * $this->tagIt(array('type'=>'work','name'=>$workExperience->companyName, 'jobTitle'=>$workExperience->jobTitle ));
		$this->tagIt(array('type'=>'jobTitle', 'name'=>$workExperience->jobTitle ));
	 * Enter description here ...
	 * @param unknown_type $tag
	 */
	public function tagIt($tag){

		$db = Yii::app()->dbService->getDB();

		if(!$db->tags->findOne($tag)){
			$db->tags->save($tag);
		}
	}


	/**
	 * tag search norammly used for auto complete purposes
	 * term , collection must must be passed
	 * Enter description here ...
	 * @param $params
	 */
	function  termSearch($params) {
		$term = $params['term'];
		$type = $params['termType'];

		$db = $this->getDB();
			
		//log.debug "site :get:: ${params}"
		$q = $term?$term:'a';

		$regexObj = new MongoRegex("/".$q."/i");
		$where = array("type"=>$type,"name" => $regexObj);
			
		$result = $db->tags->find($where)->limit(20)->sort(array('name'=>1));

		// return $result;
		//def result = dbService.getDB()[c].find().limit(100).sort(value:1)
		$r = array();

		foreach ($result as $r1){
			$r[]= array('value' =>$r1['name']);
		}
			
		return $r;

	}


	/**
	 * tag search norammly used for auto complete purposes
	 * term , collection must must be passed
	 * Enter description here ...
	 * @param $params
	 */
	function  termSearchRegion($params) {
		if(!$types)$types = array('country');

		$term = $params['term'];
		$type = $params['termType'];

		$db = $this->getDB();
			
		//log.debug "site :get:: ${params}"
		$q = $term?$term:'de';

		$regexObj = new MongoRegex("/^".$q.".*/i");

		if($type == 'country'){
			$where = array("type"=>$type,"name" => $regexObj);
		}else if($type == 'region'){
			$where = array("type"=>$type,"name" => $regexObj);
		}else if($type == 'city'){
			$where = array("type"=>$type,"name" => $regexObj);
		}else if($type == 'locality'){
			$where = array("type"=>$type,"name" => $regexObj);
		}


		Yii::log("location search::".CVarDumper::dumpAsString($where), CLogger::LEVEL_INFO);
		$result = $db->regions->find($where)->limit(20)->sort(array('name'=>1));

		// return $result;
		//def result = dbService.getDB()[c].find().limit(100).sort(value:1)
		$r = array();

		foreach ($result as $r1){
			$r[]= array('value' =>$r1['name']);
		}
			
		return $r;

	}




	public function circleIt($circleAttributes, $members){
		$circle = Circle::model()->findNative($circleAttributes);
			
		if(!$circle){
			$circle = new Circle();
			$circle->attributes = $circleAttributes;
			$circle->save();
		}

		if($members){

			foreach ($members as $member){
				$circle->addMemberToGroupCircle($member);
			}

		}

	}





	/***
	 * inserts OR overrides with new values passed in $objects ($object)
	 */
	function saveBulkIfNotExists($collectionName, $objects){

		$db = Yii::app()->dbService->getDB();
		$c = $db->$collectionName;

		if(!$objects) return;
		foreach ($objects as $object){
			$existingObject = $c->findOne($object);
			if($existingObject){
				$object["_id"] = $existingObject->_id;
			}

			$c->save($object);

		}
	}


	function saveBulkIfNotExistsNoChecks($collectionName, $objects){

		$db = Yii::app()->dbService->getDB();
		$c = $db->$collectionName;

		if(!$objects) return;
		$c->batchInsert($objects, array('continueOnError'=>true));


	}

	function convertToArray($dataProvider){
		if(!$dataProvider){
			return array('data'=>array(), 'total'=>0, 'offset'=>0,'limit'=>10);
		}
			
		$total = $dataProvider->getTotalItemCount();
		$offset =$dataProvider->getPagination()->getOffset();
		$limit = $dataProvider->getPagination()->getLimit();

		if($dataProvider && $dataProvider->data){
			foreach ($dataProvider->data as $i=>$message){
				$dataProvider->data[$i]['message']['gid'] = $message->identity();
				$dataProvider->data[$i]->contextRef = $message->getReference();
			}
		}

		$data = $dataProvider->getData();
		$response = array('data'=>$data, 'total'=>$total, 'offset'=>$offset,'limit'=>$limit);

		return $response;
	}


	/**
	 * $viewPath = Yii::app()->basePath . '/views/messageStream/_messageTemplate.php';
	 * Enter description here ...
	 * @param unknown_type $data
	 * @param unknown_type $template
	 */
	public function renderEach($dataProviderMap, $template){
		if(!$dataProviderMap)return $dataProviderMap;
		$data = $dataProviderMap['data'];

		if(!$data)return $dataProviderMap;

		foreach ($data as $i=>$model){
			$content = Yii::app()->controller->renderInternal($template ,  array('model'=>$model, 'index'=>$i), true);
			$model->message['html'] = $content;
			$data[$i] = $model;
		}
		$dataProviderMap['data'] = $data;

		return $dataProviderMap;
	}

	/**
	 * converts single string based id to mongoid
	 * or converts arrays of ids to array of mongoids
	 * Enter description here ...
	 * @param $id
	 */
	public function toObjectId($id){
		if(is_string($id)){
			return new MongoId($id);
		}


		if(is_array($id)){
			$ids = array();
			foreach ($id as $oid){
				if(is_string($oid)){
					$ids[] = new MongoId($oid);
				}else{
					$ids[] = $oid;
				}
					
			}

			return $ids;
		}


	}

	public function load($object){
		if(!is_object($object) && is_string($object)){
			$object = YumProfile::getProfile($id);
		}else if(get_class($profile)=='MongoId'){
			$object = YumProfile::getProfile($id);
		}
	}


	public function toLongDateRange($date1 , $date2){
		if(!$date1 && !$date2) return null;

		$date1 = $this->toLongDate($date1);
		$date2 = $this->toLongDate($date2);

		if(!$date2){
			return $date1." - N.A.";
		}

		if(!$date1){
			return 'N.A. - '.$date2;
		}

		return $date1." - ".$date2;

	}


	public static function formatDateRange($date1 , $date2, $format='Y-m-d'){
		if(!$date1 && !$date2) return null;

		$f = "";

		if($date1){
			$date1f = new DateTime(date('Y-m-d', $date1->sec));
			$date1f = $date1f->format($format);
			$f .= $date1f;
		}else{
			$f .=" N.A.";
		}

		$f .= " - ";

		if($date2){
			$date2f = new DateTime(date('Y-m-d', $date2->sec));
			$date2f = $date2f->format($format);
			$f .= $date2f;

		}else{
			$f .=" N.A.";
		}

		return $f;

	}



	public function toLongDate($date){
		if(!$date || !is_object($date)){
			return null;
		}

		if(get_class($date)=='MongoDate'){
			$date = $date->sec;
		}

		return Yii::app()->dateFormatter->format(Yii::app()->locale->getDateFormat('long'),$date);
	}



	/**
	 * add value object to existing collection . In case key is NOT null It shall be compared to for objects the $keyName .
	 * In case the objects already exists with $keyName they shall be overridden by new value
	 *
	 * Enter description here ...
	 * @param $collection
	 * @param $key
	 * @param $value
	 */
	public function updateToEmbeddedCollection($collectionName, $value, $keyName=null){

		Yii::log("Saving updated value::".$collectionName."  ::".CVarDumper::dumpAsString($value), CLogger::LEVEL_INFO);
		$collection = $this->$collectionName;
		if(!$collection){
			$this->$collectionName = array();
			$collection = $this->$collectionName;
		}

		if($keyName){
			foreach($collection as $index => $object){
				if($object[$keyName] == $value[$keyName]){
					$collection[$index]= $value;
					$this->$collectionName = $collection;
					return $collection;
				}
			}

		}



		$collection[] = $value;
		$this->$collectionName = $collection;

		return $collection;
	}

	/**
	 * get from locations where key is 'name' and  value = "hometown"
	 * getEmbeddedObject('locations',  'name', 'hometown')
	 * Enter description here ...
	 * @param unknown_type $collection
	 * @param unknown_type $keyName
	 * @param unknown_type $keyValue
	 */
	public function getEmbeddedCollectionObject($collectionName,  $keyName, $keyValue){
		if(!$this->$collectionName) return null;

		$collection = $this->$collectionName;
		if(!$collection){
			$this->$collectionName = array();
			$collection = $this->$collectionName;
		}
		foreach($collection as $index => $object){
			if($object[$keyName] == $keyValue){
				return $object;
			}
		}
	}

	public function removeFromEmbeddedCollection($collectionName, $value, $keyName=null){
		$collection = $this->$collectionName;

		if(!$collection){
			$this->$collectionName = array();
			$collection = $this->$collectionName;
		}

		foreach($collection as $index => $object){
			if($object[$keyName] == $value[$keyName]){
				unset($collection[$index]);
				return;
			}
		}
	}

	public function updateAllToEmbeddedCollection($collectionName, $values, $keyName,  $modelClass, $validate=false){
		if(isset($values)){
			foreach($values as $k=>$attrs){

				if($validate && $modelClass){

					$object = new $modelClass();
					$object->attributes = $attrs;
					//@todo:op validate later
					$attrs = $object->attributes;

				}

				$collection = $this->updateToEmbeddedCollection($collectionName, $attrs, $keyName);
				//$collection = $this->addToEmbeddedCollection($collection, $keyName, $attrs);
				$this->$collectionName = $collection;
			}
		}
		Yii::log("Saving updated collection::".$collectionName."  ::".CVarDumper::dumpAsString($values), CLogger::LEVEL_INFO);
		Yii::log("Saving updated collection::".CVarDumper::dumpAsString($this->$collectionName), CLogger::LEVEL_INFO);
	}



	public function removeFromEmbeddedCollection1($rootCollectionName, $level2CollectionName, $key){
		$rootCollection = $this->$rootCollectionName;
		if(!$rootCollection){
			return;
		}


		unset($rootCollection[$level2CollectionName][$key]);
		$this->$rootCollectionName = $rootCollection;
		$this->save();
	}


	public function getEmbeddedCollection2Level($rootCollectionName, $level2CollectionName){
		$rootCollection = $this->$rootCollectionName;
		$level2Collection = $rootCollection[$level2CollectionName];

		if(!$level2Collection){
			$rootCollection[$level2CollectionName] = array();
			$level2Collection = $rootCollection[$level2CollectionName];
		}
		$this->$rootCollectionName = $rootCollection;
		return $level2Collection;
	}

	public function tagEmbeddedCollection2LevelValue($rootCollectionName, $level2CollectionName, $key, $value){
		$this->tagIt(array("type"=>$level2CollectionName, "name"=>$key));
	}

	/**
	 * Example adding interests
	 *
	 * "interests", "Movies", "Titanic" , array('name'=>'Titanic', 'photo'=>titanic.png')
	 * Enter description here ...
	 * @param unknown_type $holder
	 * @param unknown_type $collection
	 * @param unknown_type $key
	 * @param unknown_type $value
	 * @param unknown_type $tagId
	 */
	public function addToEmbeddedCollection2Level($rootCollectionName, $level2CollectionName, $key, $value, $tagId=true){
		$rootCollection = $this->$rootCollectionName;
		if(!$rootCollection){
			$rootCollection = array();
		}
			
		$rootCollection[$level2CollectionName][$key] = $value;
		$this->$rootCollectionName = $rootCollection;
		$state = $this->save();

		$profile = YumProfile::model()->findByPk($this->_id);


		$this->tagEmbeddedCollection2LevelValue($rootCollectionName, $level2CollectionName, $key, $value);
	}

	public function removeFromEmbeddedCollection2Level($rootCollectionName, $level2CollectionName, $key){
		$rootCollection = $this->$rootCollectionName;
		if(!$rootCollection){
			return;
		}


		unset($rootCollection[$level2CollectionName][$key]);
		$this->$rootCollectionName = $rootCollection;
		$this->save();
	}

	/*************  generic profile /group functions **********************************************/
	public function isOwner($profile = null){
		if(!$profile){
			$profile = YumProfile::getSessionProfile();
		}
			
		if(!$profile)return false;


		if($this instanceof YumProfile){
			if($this->identity() == $profile->identity()){
				return true;
			}
		}


		if(get_class($this) == 'StatusStream' || get_class($this) == 'GraphObjectComment'|| get_class($this) == 'GraphObjectLike' || get_class($this) == 'GraphObjectLike'){

			if($this->actor == $profile->identity()){
				return true;
			}
		}


		if(get_class($this) == 'Poll' || get_class($this) == 'Blog'){

			if($this->owner == $profile->identity()){
				return true;
			}
		}


		return false;
	}



	public function isAdmin($profile = null){

		//return false;
		if(!$profile){
			$profile = YumProfile::getSessionProfile();
		}
		if(!$profile)return false;

		if($this instanceof  YumProfile){
			return $this->isOwner($profile);
			
			
		}else{
			Yii::log("isAdmin:", CLogger::LEVEL_INFO);
			return $this->isCircleMember('admin', $profile->_id);
		}

		/**
		 if(get_class($this) == 'Group'){
			if(!$this->admin){
			return false;
			}
			if( in_array($profile->identity(),$this->admin )){
			return true;
			}
			}**/

		return false;
	}

	public function isMember($profile = null){

		//return false;
		if(!$profile){
			$profile = YumProfile::getSessionProfile();
		}
		if(!$profile)return false;

		if(get_class($this) == 'YumProfile'){
			return $this->isOwner($profile);
		}else{
			Yii::log("isAdmin:", CLogger::LEVEL_INFO);
			return $this->isCircleMember('member', $profile->_id);
		}

		/**
		 if(get_class($this) == 'Group'){
			if(!$this->admin){
			return false;
			}
			if( in_array($profile->identity(),$this->admin )){
			return true;
			}
			}**/

		return false;
	}




	/**
	 * checks and get the already invited profiles from passed in profile ids (string ids)
	 * Enter description here ...
	 * @param unknown_type $profileIdenties
	 */
	public function getInviteesStatus($profileIdenties){
		$connectRequests = ConnectRequest::model()->findAllByNative(array('actor'=>$this->identity(), 'target'=>array('$in'=>$profileIdenties)));
		if(!$connectRequests)return array();
			
		$invited = array();
		foreach ($connectRequests as $connectRequest){
			$invited[] = $connectRequest->target;
		}
			
		return $invited;
			
	}

	/**
	 * Applicable to profile, group, circle or its derivatives
	 *
	 * Returns one of the followings:
	 *
	 * self | connected | not-connected | GraphObject::$NOT_IDENTIFIED;
	 *
	 *  GraphObject::$NOT_IDENTIFIED; shall mean - relationship for connection not implemented
	 *
	 * Enter description here ...
	 * @param unknown_type $profile
	 */
	public function getConnectStatus($profile = null){
		if(!$profile){
			$profile = YumProfile::getSessionProfile();
		}

		if(!$profile)return false;

		if(get_class($this) == 'YumProfile'){

			$isOwner = $this->isOwner($profile);

			if($isOwner)return GraphObject::$SELF;

			$alreadyInvitees = $profile->getInviteesStatus(array($this->identity()));
			if(in_array($this->identity(), $alreadyInvitees)){
				return GraphObject::$ALREADY_INVITED;
			}
		}

		if(!$this->connections || !$this->connections['all'] ||!in_array( $profile->identity(),$this->connections['all']) ){

			return GraphObject::$NOT_CONNECTED;

		}else{
			//if(ConnectRequest::model()->findByNative(array('')))
			return GraphObject::$CONNECTED;
		}


		return GraphObject::$NOT_IDENTIFIED;

	}




	/////////////////////////// CDN funcions ////////////////////////////////////////////
	public function getImageObjectByName($name) {

		$url = null;
		Yii::log("Render image ....".$name, CLogger::LEVEL_ERROR);
		$db = Yii::app()->dbService->getDB();

		// GridFS
		$gridFS = $db->getGridFS();

		// Find image to stream
		$image = $gridFS->findOne(array("metadata.name"=>$name));


		return $image;


	}


	public function getDocumentFileById($id) {

		if(!is_object($id)){
			$id = new MongoId($id);
		}

		$url = null;
		Yii::log("Render image ....".$name, CLogger::LEVEL_ERROR);
		$db = Yii::app()->dbService->getDB();

		// GridFS
		$gridFS = $db->getGridFS();

		// Find image to stream
		$image = $gridFS->findOne(array("_id"=>$id));


		return $image;


	}




	/**
	 * $keyName shall be used for uniqueness of updated/or added oobject
	 * location based attributes :: any model can have n number of locations
	 * in example : $_POST['Location']
	 *
	 * add/edit locations
	 * ********************************/

	function getLocation($tag="current"){
		//$locationAttr = $this->getEmbeddedCollectionObject('locations', 'name', $tag);

		$locationAttr = $this->locations[$tag];

		$location = new Location();
		if($locationAttr){
			$location->attributes = $locationAttr;
		}
		
		$location->name = $tag;
		if(!$location->country){
			$location->country = "India";
		}
		return $location;

	}

	function getLocationSummary($tag="current"){

		return $this->getLocation($tag)->getLocationAsHuman();
	}




	function updateLocations($values){
		return $this->updateAllToEmbeddedCollection('locations',$values, 'name', null);
	}

	public function getFormatted($property){
		$value = $this->$property;

		if(!$value)return "-";

		if(is_string($value)){
			return $value;
		}

		if(is_array($value)){
			return implode(",", $value);
		}
	}

	public function getKey($property=null){

		if(!$property){
			return $this->getCollectionName()."-". $this->identity();
		}
		return EMongoEmbeddedDocument::s_getKey($this->getCollectionName(), $this->identity(),$property);

	}

	public static function s_getKey($collectionName,$modelId,$property){
		$key = $collectionName."-".$modelId."-".$property;
		return $key;
	}


	/********************************************* custom fields CMS support *******************/

	public static function s_getContentType($contentTypeName){
		$contentType = ContentType::model()->findByNative(array('name'=>$contentTypeName));

		return $contentType;
	}

	public  function getContentType(){
		$contentTypeName = $model->contentType;
			
		$contentType = ContentType::model()->findByNative(array('name'=>$contentTypeName));

		return $contentType;
	}



	public function findAllFieldTypesAsJson(){

		$details = $this->fieldTypes;
		if(!$details){
			$details = array(array('name'=>'', 'type'=>'', 'description'=>''));
		}
			
		return CJSON::encode($details);
	}

	public function findAllFieldsAsJson(){

		$details = $this->fields;
		if(!$details){
			$details = array(array('name'=>'', 'type'=>'', 'value'=>''));
		}
			
		return CJSON::encode($details);
	}


	public function getFields($type){

		$reflector = new ReflectionClass(get_class($this));

		if($reflector->hasProperty($type)){
			$fields = $this->{$type};

		}else{
			$fields = $this->fields[$type];

		}
		//var_dump($type);
		//var_dump($this->fields);
		if(!$fields ){
			return array();
		}


		return $fields;
	}




	public function getField($type){
		if(!$this->fields || !$this->fields[$type]){
			return null;
		}

		return $this->fields[$type];
	}

	public function getFieldFormatted($type){
		if(!$this->fields || !$this->fields[$type]){
			return " -";
		}

		return $this->fields[$type];
	}

	public function getDateFieldFormatted($type, $format="medium"){
		if(!$this->fields || !$this->fields[$type]){
			return " - ";
		}

		$date = $this->fields[$type];
		if($date && is_object($date)){
			return $this->formatDate($date, $format);
		}

		return "-";
	}
	
	

	/**
	 * (
	 'cc' => '1'
	 'YumProfile' => array
	 (
	 'locations' => array
	 (
	 'current' => array
	 (
	 'name' => 'current'
	 'country' => ''
	 'region' => ''
	 'city' => ''
	 )
	 )
	 'gender' => 'Female'
	 'fields' => array
	 (
	 'age' => array
	 (
	 'fromAge' => '1'
	 'toAge' => '1'
	 )
	 )
	 )
	 'limit' => '10'
	 'page' => '6'
	 'offset' => '0'
	 )]]
	 * Enter description here ...
	 * @param unknown_type $params
	 * @param unknown_type $conditions
	 */
	public function addSearchCriterias( &$params, &$conditions){

		//$conditions["adminBlocked"] = array('$ne'=>'B');

		//get incoming params
		if(isset($params["_id"])){

			$conditions["_id"] = $params["_id"];
		}

		if(isset($params["nodeType"])){

			$conditions["nodeType"] = $params["nodeType"];
		}


		if(isset($params["admin"])){

			$conditions["admin"] = $params["admin"];
		}


		if(isset($params["contextId"])){

			$conditions["contextId"] = $params["contextId"];
		}

		if(isset($params["context"])){

			$conditions["context"] = $params["context"];
		}



		$contextRef = $params['contextRef'];

		if($contextRef){

			if($contextRef['nodeType']&&$contextRef['nodeId'])
			$contextGraphObject = GraphObject::findByReference($contextRef);
		}


		if(!$contextGraphObject){
			//$conditions['context'] = 'global';
			//$conditions['context'] = 'global';
		}else{
			$conditions['context'] = $contextGraphObject->getNodeType();
			$conditions['contextId'] = $contextGraphObject->identity();
		}


		// profile search
		if(isset($params["WorkExperience"]) && is_array($params["WorkExperience"])){

			if($params["WorkExperience"]["companyName"]){
				$conditions["workExperiences.companyName"] = $params["WorkExperience"]["companyName"];
			}

			if($params["WorkExperience"]["jobTitle"]){
				$conditions["workExperiences.jobTitle"] = $params["WorkExperience"]["jobTitle"];
			}

		}

		if(isset($params["Education"]) && is_array($params["Education"])){

			if($params["Education"]["instituteName"]){
				$conditions["workExperiences.instituteName"] = $params["WorkExperience"]["instituteName"];
			}

			if($params["WorkExperience"]["degree"]){
				$conditions["workExperiences.degree"] = $params["WorkExperience"]["degree"];
			}

		}


		$this->addSearchCriteriaRegExFull($params,'term', $conditions, 'name');
		$this->addSearchCriteriaRegExFull($params,'name', $conditions);
		$this->addSearchCriteria($params,'gender', $conditions);
		$this->addSearchCriteria($params,'firstname', $conditions);
		$this->addSearchCriteria($params,'lastname', $conditions);
		$this->addSearchCriteria($params,'email', $conditions);
		$this->addSearchCriteria($params,'phone', $conditions);
		$this->addTagSearchCriteria($params,'profession', $conditions);
		$this->addTagSearchCriteria($params,'education', $conditions);
		$this->addTagSearchCriteria($params,'work', $conditions);
		$this->addInterestsSearchCriteria($params,'interest', $conditions);
		$this->addTagSearchCriteria($params,'profession', $conditions);
		$this->addKeywordsSearchCriteria($params, &$conditions);
		$this->getIntRangeSearchCriteria($params['fields']['age'],$conditions, 'age');
		$this->getIntRangeSearchCriteria($params['fields']['price'],$conditions, 'price');
		$this->getDateRangeSearchCriteria($params,$conditions);
		$this->getPriceRangeSearchCriteria($params,$conditions);
		//$this->getLocationSearchCriteria($appContext,$conditions);
		//$this->addSearchCriteria($appContext,'country', $conditions,'locations.current.country');

		if(isset($params['locations']['current'])){
			$location = $params['locations']['current'];
			$this->addSearchCriteria($location,'country', $conditions,'locations.current.country');
			$this->addSearchCriteria($location,'region', $conditions,'locations.current.region');
			$this->addSearchCriteria($location,'city', $conditions,'locations.current.city');

		}
		$this->addSearchCriteria($params,'country', $conditions,'locations.current.country');
		$this->addSearchCriteria($params,'region', $conditions,'locations.current.region');
		$this->addSearchCriteria($params,'city', $conditions,'locations.current.city');

			
		$this->addInSearchCriteria($params,'categories', $conditions,'categories');
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

			$categoriesFiltered = array();
			foreach ($categories as $c){
				$c = trim($c);
				if($c && $c!=''){
					$categoriesFiltered[] = $c;
				}
			}
			if( !empty($categories)){
				$conditions[$property] = array('$in' => $categories);
			}

		}

	}

function addAndSearchCriteria($params, $name, &$conditions, $property=null){
		if(!$property){
			$property = $name;
		}

		if(isset($params[$name]) && $params[$name]!=''){
			$categories = $params[$name];
			if(!is_array($categories)){
				$categories = explode(",", $categories) ;
			}

			$categoriesFiltered = array();
			foreach ($categories as $c){
				$c = trim($c);
				if($c && $c!=''){
					$categoriesFiltered[] = $c;
				}
			}
			if( !empty($categories)){
				foreach ($categories as $category){
					$conditions[$property] = $category;
				}
				//$conditions[$property] = array('$and' => $categories);
			}

		}

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


	function getIntRangeSearchCriteria($params, &$conditions, $name){
		$c = array();

		if(isset($params['from'])){
			if($params['from'] && $params['from'] !="" && $params['from']!=0)
			$c['$gt']=  (int)$params['from'];
		}

		if(isset($params['to'])){
			if($params['to'] && $params['to'] !="" && $params['to']!=0)
			$c['$lt']= (int)$params['to'];
		}

		if(count($c)>0){
			$conditions[$name] = $c;
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



	public function getContacts($type){
		if(!$this->contacts || !$this->contacts[$type]){
			return array();
		}

		return $this->contacts[$type];
	}

	public function getContactsAsHumanList($type){
		if(!$this->contacts || !$this->contacts[$type]){
			return "-";
		}

		$contacts = array();

		if($type == "email"){
			foreach ($this->contacts[$type] as $contact){
				$text = '<a class="mailto" href="mailto:'.$contact['title'].'" title="'.$contact['title'].'">'.$contact['title'].'</a>';
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$contacts[] = $text;
			}
		}else if($type == "web"){
			foreach ($this->contacts[$type] as $contact){
				$text = '<a class="webto" href="'.$contact['title'].'" title="'.$contact['title'].'">'.$contact['title'].'</a>';
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$contacts[] = $text;
			}
		}else{
			foreach ($this->contacts[$type] as $contact){
				$text = $contact['title'];
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$contacts[] = $text;
			}}

			return $contacts;
	}


	public function getFieldsAsHumanList($type){


		$fields = $this->getFields($type);

		$objects = array();

		if($type == "email"){
			foreach ($fields as $contact){
				$text = '<a class="mailto" href="mailto:'.$contact['title'].'" title="'.$contact['title'].'">'.$contact['title'].'</a>';
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$objects[] = $text;
			}
		}else if($type == "web"){
			foreach ($fields as $contact){
				$text = '<a class="webto" href="'.$contact['title'].'" title="'.$contact['title'].'">'.$contact['title'].'</a>';
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$objects[] = $text;
			}
		}else{
			foreach ($fields as $contact){
				$text = $contact['title'];
				if($contact['type']){
					$text .= "(".$contact['type'].")";
				}
				$objects[] = $text;
			}}

			return $objects;
	}

	public function getFieldsAsHumanListFormatted($type){
		$objects = $this->getFieldsAsHumanList($type);

		if($objects && count($objects)>0){
			return implode (" | ", $objects);
		}

		return " - ";
	}


	public function getContactsAsHuman($type){
		$contacts =$this->getContacts($type);
		if(!$contacts ){
			return "-";
		}

		$contactst = array();
		foreach ($contacts as $contact){
			$contactst[] = $contact['title'];
		}


		return implode(", ",$contactst);
	}


	public function getContactsAsHuman2($type){
		if(!$this->contacts || !$this->contacts[$type]){
			return "-";
		}

		$contacts = array();
		foreach ($this->contacts[$type] as $contact){
			$contacts[] = $contact['title'];
		}


		return implode(", ",$contacts);
	}




	public static function parseText($text){
		$list = array();

		$text = str_ireplace("*","",$text);

		//foreach ($delimiters as $delimiter){
		$l1 = explode(",", $text);
		if($l1){
			foreach ($l1 as $subtext){
				$l2 = explode("\n", $subtext);
				if($l2 ){


					$list = array_merge($list, $l2);

				}

			}
		}
		//}

		foreach ($list as $i=>$e){
			$list[$i] = trim($e);
		}

		return $list;
	}


	public function  getTextSummary($property, $max=200){
		if(!$this->$property)return "";

		$foo = CHtml::encode($this->$property);
		if(count_chars($foo)<$max) return $foo;

		$bar = substr($foo,0,$max) . "...";

		return $bar;
			
	}

	public static function  s_getTextSummary($value, $max=200){
		if(!$value)return "";

		$foo = $value;
		if(count_chars($foo)<$max) return $foo;

		$bar = substr($foo,0,$max) . "...";

		return $bar;
			
	}



}