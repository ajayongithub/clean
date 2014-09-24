<?php

Yii::import('application.modules.common.models._base.BaseCompanyLocation');

class CompanyLocation extends BaseCompanyLocation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    public static function getLocationsForComapny($companyId){
		
		 $locations = Yii::app()->db->createCommand()
		 ->select(' ml.id, ml.location_address ')
		 ->where('t.location_id = ml.id and t.company_id = '.$companyId)
		 ->from(' company_location t, master_locations ml ')
		 ->queryAll();	
		 return CHtml::listData($locations,'id','location_address') ; 

	}
}