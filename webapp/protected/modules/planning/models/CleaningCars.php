<?php

Yii::import('application.modules.planning.models._base.BaseCleaningCars');

class CleaningCars extends BaseCleaningCars
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getCarNumber($id){
		$model = CleaningCars::model()->findByPk($id);
		return $model->number_plate ;
	}
}