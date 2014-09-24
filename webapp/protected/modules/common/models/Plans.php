<?php

Yii::import('application.modules.common.models._base.BasePlans');

class Plans extends BasePlans
{
	const EXTERIOR = 0 ;
	const EXT_INT = 1 ;
	public static $service_type = array('Exterior','Exterior & Interior') ;
	public static function getNextService($subscription){
		$plan =  Plans::model()->findByPk($subscription->plan_id) ;
		if(strcmp($plan->plan_name,'Exterior Cleaning Pack')==0)
			return self::EXTERIOR ;
		if(strcmp($plan->plan_name,'Complete Cleaning Pack')==0)
			return self::EXT_INT;
		$t1 = strtotime($subscription->start_date) ;
		$t2 = strtotime('now');
		return (intval(date('m',$t2-$t1)) %2) ;
	} 
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getServiceTypeForList(){
		return array(
				''=>'Service Type',
				self::EXTERIOR => self::$service_type[self::EXTERIOR] ,
				self::EXT_INT => self::$service_type[self::EXT_INT] ,
			);
	}
	public static function getPlanName($planId){
		$plan =  Plans::model()->findByPk($planId) ;
		return $plan->plan_name ;	
	}
}