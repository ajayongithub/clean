<?php

/**
 * This is the model base class for the table "roster".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Roster".
 *
 * Columns in table "roster" available as properties of the model,
 * followed by relations of table "roster" available as properties of the model.
 *
 * @property integer $id
 * @property integer $sched_id
 * @property integer $emp_id
 * @property integer $cleaner
 * @property integer $extra_cleaner
 * @property integer $team_lead
 *
 * @property LocationSchedule $sched
 * @property Employees $emp
 */
abstract class BaseRoster extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'roster';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Roster|Rosters', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('sched_id, emp_id, cleaner, extra_cleaner, team_lead', 'required'),
			array('sched_id, emp_id, cleaner, extra_cleaner, team_lead', 'numerical', 'integerOnly'=>true),
			array('id, sched_id, emp_id, cleaner, extra_cleaner, team_lead', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'sched' => array(self::BELONGS_TO, 'LocationSchedule', 'sched_id'),
			'emp' => array(self::BELONGS_TO, 'Employees', 'emp_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'sched_id' => null,
			'emp_id' => null,
			'cleaner' => Yii::t('app', 'Cleaner'),
			'extra_cleaner' => Yii::t('app', 'Extra Cleaner'),
			'team_lead' => Yii::t('app', 'Team Lead'),
			'sched' => null,
			'emp' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('sched_id', $this->sched_id);
		$criteria->compare('emp_id', $this->emp_id);
		$criteria->compare('cleaner', $this->cleaner);
		$criteria->compare('extra_cleaner', $this->extra_cleaner);
		$criteria->compare('team_lead', $this->team_lead);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}