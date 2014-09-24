<?php

/**
 * This is the model base class for the table "reservations".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Reservations".
 *
 * Columns in table "reservations" available as properties of the model,
 * followed by relations of table "reservations" available as properties of the model.
 *
 * @property integer $id
 * @property string $user_id
 * @property integer $schedule_id
 * @property string $status
 * @property string $reserved_on
 * @property integer $service_type
 * @property string $changed_by
 * @property string $remarks
 * @property string $e1
 * @property string $e2
 * @property string $last_status_changed_on
 *
 * @property LocationSchedule $schedule
 * @property User $user
 */
abstract class BaseReservations extends GxActiveRecord {
	public $_sched_date ;
	public $_username ;
	public $_location_address ;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'reservations';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Reservations|Reservations', $n);
	}

	public static function representingColumn() {
		return 'reserved_on';
	}

	public function rules() {
		return array(
			array('user_id, schedule_id, reserved_on, service_type', 'required'),
			array('schedule_id, service_type', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('status, changed_by, e1, e2', 'length', 'max'=>128),
			array('remarks', 'length', 'max'=>512),
			array('last_status_changed_on', 'safe'),
			array('status, changed_by, remarks, e1, e2, last_status_changed_on', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, user_id, schedule_id, status, reserved_on, service_type, changed_by, remarks, e1, e2, last_status_changed_on, username, sched_date, location_address', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'schedule' => array(self::BELONGS_TO, 'LocationSchedule', 'schedule_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		    //'loc' => array(self::BELONGS_TO,'MasterLocation',array('schedule_id'=>'id'),'through'=>'schedule'),
		
		
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'user_id' => null,
			'schedule_id' => null,
			'status' => Yii::t('app', 'Status'),
			'reserved_on' => Yii::t('app', 'Reserved On'),
			'service_type' => Yii::t('app', 'Service Type'),
			'changed_by' => Yii::t('app', 'Changed By'),
			'remarks' => Yii::t('app', 'Remarks'),
			'e1' => Yii::t('app', 'E1'),
			'e2' => Yii::t('app', 'E2'),
			'last_status_changed_on' => Yii::t('app', 'Last Status Changed On'),
			'schedule' => null,
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->with=array('schedule','user','schedule.loc');
		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('schedule_id', $this->schedule_id);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('reserved_on', $this->reserved_on, true);
		$criteria->compare('service_type', $this->service_type);
		$criteria->compare('changed_by', $this->changed_by, true);
		$criteria->compare('remarks', $this->remarks, true);
		$criteria->compare('e1', $this->e1, true);
		$criteria->compare('e2', $this->e2, true);
		$criteria->compare('last_status_changed_on', $this->last_status_changed_on, true);
		$criteria->compare('user.username', $this->_username, true);
		$criteria->compare('schedule.sched_date', $this->_sched_date, true);
		$criteria->compare('location_address', $this->_location_address, true);
		$today = new CDbExpression("CURRENT_DATE()");
		$sort = new CSort();
		$sort->attributes = array(
			'defaultOrder'=>"sched_date ASC",
			'sched_date'=>array(
					'asc'=>'schedule.sched_date',
					'desc'=>'schedule.sched_date DESC' ,
				),
			'location_address'=>array(
					'asc'=>'location_address',
					'desc'=>'location_address DESC' ,
				),
			'username' => array(
					'asc'=>'user.username',
					'desc'=>'user.username desc',
				),
			'status'=>array(
					'asc'=>'status',
					'desc'=>'status desc',
					),
			'service_type'=>array(
					'asc'=>'service_type',
					'desc'=>'service_type desc',
					),
			);
		$criteria->addCondition('schedule.sched_date >= '.$today);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>$sort,
		));
	}
	public function getSched_Date(){
		if($this->_sched_date===null && $this->schedule !== null){
				$this->_sched_date = $this->schedule->sched_date ;
		}
		 return $this->_sched_date ;
	}
	public function setSched_Date($value){
		$this->_sched_date=$value ;
	}
	public function getLocation_Address(){
		if($this->_location_address===null && $this->schedule !== null){
				$this->_location_address = $this->schedule->loc->location_address ;
		}
		 return $this->_location_address ;
	}
	public function setLocation_Address($value){
		$this->_location_address=$value ;
	}
	public function getUsername(){
		if ($this->_username === null && $this->user !== null) {
			$this->_username = $this->user->username;
		} 
		return $this->_username;
	}
	public function setUsername($value){
		$this->_username=$value;
	}
}