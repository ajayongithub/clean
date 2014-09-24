<?php

/**
 * This is the model base class for the table "company_location".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CompanyLocation".
 *
 * Columns in table "company_location" available as properties of the model,
 * followed by relations of table "company_location" available as properties of the model.
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $location_id
 * @property string $start_date
 * @property string $end_date
 * @property string $remark
 *
 * @property Company $company
 * @property MasterLocations $location
 */
abstract class BaseCompanyLocation extends GxActiveRecord {
	public $_company_name ;
	public $_location_address ;
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'company_location';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'CompanyLocation|CompanyLocations', $n);
	}

	public static function representingColumn() {
		return 'start_date';
	}

	public function rules() {
		return array(
			array('company_id, location_id', 'required'),
			array('company_id, location_id', 'numerical', 'integerOnly'=>true),
			array('remark', 'length', 'max'=>512),
			array('start_date, end_date', 'safe'),
			array('start_date, end_date, remark', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, company_id, location_id, start_date, end_date, remark, company_name, location_address', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'location' => array(self::BELONGS_TO, 'MasterLocations', 'location_id'),
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
			'location_id' => null,
			'start_date' => Yii::t('app', 'Start Date'),
			'end_date' => Yii::t('app', 'End Date'),
			'remark' => Yii::t('app', 'Remark'),
			'company' => null,
			'location' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->with = array('company','location') ;

		$criteria->compare('id', $this->id);
		$criteria->compare('company_id', $this->company_id);
		$criteria->compare('location_id', $this->location_id);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('remark', $this->remark, true);
		$criteria->compare('company_name', $this->_company_name, true);
		$criteria->compare('location_address', $this->_location_address, true);
		
		
	$sort = new CSort();
		$sort->attributes = array(
    'defaultOrder'=>'id DESC',
    'id'=>array(
        'asc'=>'id',
        'desc'=>'id DESC',
		),
    'remark'=>array(
        'asc'=>'remark',
        'desc'=>'remark DESC',
		),
		
		'company_name'=>array(
        'asc'=>'company.company_name',
        'desc'=>'company.company_name DESC',
		),
    'location_address'=>array(
    	'asc'=>'location.location_address',
    	'desc'=>'location.location_address DESC',
		),
		);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>$sort,
		));
	}
	
	public function getCompany_Name(){
		Yii::log('Getting company name ') ;
		if ($this->_company_name === null && $this->company !== null) {
    	    $this->_company_name = $this->company->company_name;
    	}
	    return $this->_company_name;
	}
	public function setCompany_Name($value){
		Yii::log('Setting company name ') ;
		$this->_company_name = $value ;
	}
	public function getLocation_Address(){
		Yii::log('Getting location address ') ;
		if ($this->_location_address === null && $this->location !== null) {
    	    $this->_location_address = $this->location->location_address;
    	}
	    return $this->_location_address;
	}
	public function setLocation_Address($value){
		Yii::log('Setting location address') ;
		$this->_location_address = $value;
	}
	
}