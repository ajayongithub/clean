<?php

/**
 * This is the model base class for the table "location_schedule".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "LocationSchedule".
 *
 * Columns in table "location_schedule" available as properties of the model,
 * followed by relations of table "location_schedule" available as properties of the model.
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $loc_id
 * @property string $sched_date
 * @property string $recurrence
 * @property string $day
 * @property integer $ts_id
 *
 * @property Company $company
 * @property MasterLocations $loc
 * @property TimeSlots $ts
 * @property Reservations[] $reservations
 */
abstract class BaseLocationSchedule extends GxActiveRecord {

	public $_company_name ;
	public $_location_address ;
	public $_slot_name ;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'location_schedule';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'LocationSchedule|LocationSchedules', $n);
	}

	public static function representingColumn() {
		return 'sched_date';
	}

	public function rules() {
		return array(
			array('company_id, loc_id, sched_date, ts_id', 'required'),
			array('company_id, loc_id, ts_id', 'numerical', 'integerOnly'=>true),
			array('recurrence, day', 'length', 'max'=>256),
			array('recurrence, day', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, company_id, loc_id, sched_date, recurrence, day, ts_id,company_name,location_address,slot_name', 'safe', 'on'=>'search'),
			array('id, company_id, loc_id, sched_date, recurrence, day, ts_id,company_name,location_address,slot_name', 'safe', 'on'=>'search2'),
		);
	}

	public function relations() {
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'loc' => array(self::BELONGS_TO, 'MasterLocations', 'loc_id'),
			'ts' => array(self::BELONGS_TO, 'TimeSlots', 'ts_id'),
			'reservations' => array(self::HAS_MANY, 'Reservations', 'schedule_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'company_id' => null,
			'loc_id' => null,
			'sched_date' => Yii::t('app', 'Sched Date'),
			'recurrence' => Yii::t('app', 'Recurrence'),
			'day' => Yii::t('app', 'Day'),
			'ts_id' => null,
			'company' => null,
			'loc' => null,
			'ts' => null,
			'reservations' => null,
		);
	}
	public function search2() {
		$criteria = new CDbCriteria;

		$criteria->with=array('company','loc','ts');
		$criteria->compare('id', $this->id);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('loc_id', $this->loc_id);
		$criteria->compare('sched_date', $this->sched_date, true);
		$criteria->compare('recurrence', $this->recurrence, true);
		$criteria->compare('day', $this->day, true);
		$criteria->compare('ts_id', $this->ts_id);
		$criteria->compare('company_name', $this->_company_name,true);
		$criteria->compare('location_address', $this->_location_address,true);
		$criteria->compare('slot_name', $this->_slot_name,true);
//		$criteria->order= ' sched_date ASC ';
		$today = new CDbExpression("CURRENT_DATE()");
		$criteria->addCondition('sched_date >= '.$today);
		
			$sort = new CSort();
	$sort->attributes = array(
    'defaultOrder'=>'t.sched_date DESC',
	'sched_date'=>array(
		'asc'=>'sched_date',
		'desc'=>'sched_date DESC',
	),
    'company_name'=>array(
        'asc'=>'company.company_name',
        'desc'=>'company.company_name DESC',
    ),
    'location_address'=>array(
    	'asc'=>'loc.location_address',
    	'desc'=>'loc.location_address DESC',
    ),
    'slot_name'=>array(
    	'asc'=>'slot_name',
    	'desc'=>'ts.slot_name DESC',
    ),
	);		
		

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>$sort,
		));
	}
	/*public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('loc_id', $this->loc_id);
		$criteria->compare('sched_date', $this->sched_date, true);
		$criteria->compare('recurrence', $this->recurrence, true);
		$criteria->compare('day', $this->day, true);
		$criteria->compare('ts_id', $this->ts_id);
		$criteria->order= ' sched_date ASC ';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		
		));
	}*/

	public function getCompany_Name(){
		if ($this->_company_name === null && $this->company !== null) {
    	    $this->_company_name = $this->company->company_name;
    	}
	    return $this->_company_name;
	}
	public function setCompany_Name($value){
		$this->_company_name = $value ;
	}
	public function getLocation_Address(){
		if ($this->_location_address === null && $this->loc !== null) {
    	    $this->_location_address = $this->loc->location_address;
    	}
	    return $this->_location_address;
	}
	public function setLocation_Address($value){
		$this->_location_address = $value;
	}
	public function getSlot_Name(){
		if ($this->_slot_name === null && $this->ts !==null) {
    	    $this->_slot_name = $this->ts->slot_name;
    	}
	    return $this->_slot_name;
	}
	public function setSlot_Name($value){
		$this->_slot_name = $value;
	}
}