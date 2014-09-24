<?php

Yii::import('application.modules.common.models._base.BaseCompanyMasterLocations');

class CompanyMasterLocations extends BaseCompanyMasterLocations
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getLocationsForCompany($company_id){
		$criteria = new CDbCriteria;
		 $criteria->condition = 'company_id = '.$company_id ;
	//	 $locations = CompanyMasterLocations::model()->findAll($criteria) ;
		 $locations = Yii::app()->db->createCommand()
		 ->select(' ml.id, ml.location_address, ')
		 ->from(' master_locations ml, company_location cl')
		 ->where(' cl.location_id = ml.id and cl.company_id='.$company_id)
		 ->order(' ml.location_address ')
		 ->queryAll();
		 
		 $retVal = array();

		 foreach($locations as $row){
		 	$obj = array();
		 	$obj['location_id'] = $row['id'] ;
		 	$obj['location_address'] = $row['location_address'] ;
		 	array_push($retVal, $obj);
		 }
		// return  CHtml::listData($locations,'location_id','location_address');
		return $retVal ;
			
	}
}