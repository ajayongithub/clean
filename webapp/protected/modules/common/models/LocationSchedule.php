<?php

Yii::import('application.modules.common.models._base.BaseLocationSchedule');

class LocationSchedule extends BaseLocationSchedule
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function getNextSchedules(){
		 $dateWiseCount = Yii::app()->db->createCommand()
		 ->select(' count(*) as numbers, ls.sched_date ') 
		 ->from(' location_schedule ls ')
		 ->where(' ls.sched_date >= CURRENT_DATE() ')
		 ->order(' ls.sched_date ASC ')
		 ->group(' ls.sched_date ')
		 ->limit(5)
		 ->queryAll();	
		return $dateWiseCount ; 
	}
	
	public static function getScheduleDetails($schedId){
		Yii::log("Id for sched is ".$schedId);
		$model = LocationSchedule::model()->findByPk($schedId) ;
		$retVal = $model->company->company_name ;
		$retVal .= ' ';
		$retVal .= $model->loc->location_address ;
		$retVal .= ' ';
		$retVal .=$model->loc->location_city ;
		return $retVal ;	
		/*$schedDetails = Yii::app()->db->createCommand()
		 ->select(' c.company_name, ml.location_address,ml.location_city ') 
		 ->from(' location_schedule ls , company c, master_locations ml')
		 ->where(' ls.id = '.$schedId and ls.loc_id = ml.id and ls.)
		 ->queryAll();	
		Yii::log("count for  for sched is ".count($schedDetails));
		 if($schedDetails==null )return null ;
		 $details = $schedDetails[0] ;
		 return $details['company_name'].' '.$details['location_address'].' '.$details['location_city'] ;*/
	}	
	

}