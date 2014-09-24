<?php

Yii::import('application.modules.planning.models._base.BaseEmployees');

class Employees extends BaseEmployees
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getEmployeeName($empId){
		$model = Employees::model()->findByPk($empId);
		if($model==null) return null ;
		return $model->emp_name.' '.$model->emp_last_name ;
	}
}