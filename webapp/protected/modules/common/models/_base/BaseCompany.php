<?php

/**
 * This is the model base class for the table "company".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Company".
 *
 * Columns in table "company" available as properties of the model,
 * followed by relations of table "company" available as properties of the model.
 *
 * @property integer $id
 * @property string $company_name
 * @property string $ho_address
 * @property string $ho_number
 * @property string $ho_zipcode
 * @property string $ho_city
 * @property string $contact_firstname
 * @property string $contact_init
 * @property string $contact_lastname
 * @property string $contact_email
 * @property string $extra_column
 * @property string $remarks
 * @property string $start_date
 * @property string $end_date
 * @property string $duration
 *
 * @property CompanyLocation[] $companyLocations
 */
abstract class BaseCompany extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'company';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Company|Companies', $n);
	}

	public static function representingColumn() {
		return 'company_name';
	}

	public function rules() {
		return array(
			array('company_name, ho_address, ho_zipcode, ho_city, contact_firstname,  contact_lastname, contact_email', 'required'),
			array('company_name, ho_number, ho_city, contact_firstname, contact_lastname', 'length', 'max'=>128),
			array('ho_address, contact_email, extra_column, duration', 'length', 'max'=>256),
			array('ho_zipcode, contact_init', 'length', 'max'=>32),
			array('remarks', 'length', 'max'=>512),
			array('start_date, end_date', 'safe'),
			array('ho_number, extra_column, remarks, start_date, end_date, duration', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, company_name, ho_address, ho_number, ho_zipcode, ho_city, contact_firstname, contact_init, contact_lastname, contact_email, extra_column, remarks, start_date, end_date, duration', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'companyLocations' => array(self::HAS_MANY, 'CompanyLocation', 'company_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'company_name' => Yii::t('app', 'Name'),
			'ho_address' => Yii::t('app', 'Street & No.'),
			'ho_number' => Yii::t('app', 'Number'),
			'ho_zipcode' => Yii::t('app', 'Zipcode'),
			'ho_city' => Yii::t('app', 'City'),
			'contact_firstname' => Yii::t('app', 'Firstname'),
			'contact_init' => Yii::t('app', 'Initials'),
			'contact_lastname' => Yii::t('app', 'Lastname'),
			'contact_email' => Yii::t('app', 'Email'),
			'extra_column' => Yii::t('app', 'Extra Column'),
			'remarks' => Yii::t('app', 'Remarks'),
			'start_date' => Yii::t('app', 'Start Date'),
			'end_date' => Yii::t('app', 'End Date'),
			'duration' => Yii::t('app', 'Duration'),
			'companyLocations' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('company_name', $this->company_name, true);
		$criteria->compare('ho_address', $this->ho_address, true);
		$criteria->compare('ho_number', $this->ho_number, true);
		$criteria->compare('ho_zipcode', $this->ho_zipcode, true);
		$criteria->compare('ho_city', $this->ho_city, true);
		$criteria->compare('contact_firstname', $this->contact_firstname, true);
		$criteria->compare('contact_init', $this->contact_init, true);
		$criteria->compare('contact_lastname', $this->contact_lastname, true);
		$criteria->compare('contact_email', $this->contact_email, true);
		$criteria->compare('extra_column', $this->extra_column, true);
		$criteria->compare('remarks', $this->remarks, true);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('duration', $this->duration, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}