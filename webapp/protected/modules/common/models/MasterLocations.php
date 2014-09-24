<?php

Yii::import('application.modules.common.models._base.BaseMasterLocations');

class MasterLocations extends BaseMasterLocations
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public static function getLocationNameFromId($locId){
		$ml = MasterLocations::model()->findByPk($locId) ;
		return $ml->location_address;
		 /*$criteria = new CDbCriteria;
		 $criteria->condition = 'id = '.$locId ;
		 $locations = MasterLocations::model()->findAll($criteria) ;
		 return  CHtml::listData($locations,'id','location_address'');*/
	}
	public static function getCityUserCount(){
		 $userCount = Yii::app()->db->createCommand()
		 ->select(' count(*) as numbers, ml.location_city as city_name') 
		 ->from(' profile p, master_locations ml ')
		 ->where(' p.location_id = ml.id ')
		 ->order(' numbers DESC ')
		 ->group(' city_name ')
		 ->limit(5)
		 ->queryAll();	
		return $userCount ; 
	}
}