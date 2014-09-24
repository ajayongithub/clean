<?php

Yii::import('application.modules.reservation.models._base.BaseReservations');

class Reservations extends BaseReservations
{	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public static function getNextReservationsCount(){
		 $dateWiseCount = Yii::app()->db->createCommand()
		 ->select(' count(*) as numbers, ls.sched_date ') 
		 ->from(' reservations r, location_schedule ls ')
		 ->where(' ls.id = r.schedule_id  and ls.sched_date >= CURRENT_DATE() ')
		 ->order(' ls.sched_date ASC ')
		 ->group(' ls.sched_date ')
		 ->limit(5)
		 ->queryAll();	
		return $dateWiseCount ; 
	}
}