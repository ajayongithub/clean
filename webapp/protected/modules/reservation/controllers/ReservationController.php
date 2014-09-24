<?php

class ReservationController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view'),
				'roles'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
			//array('deny', 
			//	'users'=>array('*'),
			//	),
			);
}

	public function actionView($id) {
		$this->layout="//layouts/adminLayout" ;
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Reservations'),
		));
	}

	public function actionCreate() {
		$model = new Reservations;

		$this->performAjaxValidation($model, 'reservations-form');

		if (isset($_POST['Reservations'])) {
			$model->setAttributes($_POST['Reservations']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$this->layout="//layouts/adminLayout" ;
		$model = $this->loadModel($id, 'Reservations');
		$oldStatus = $model->status ;
		$this->performAjaxValidation($model, 'reservations-form');

		if (isset($_POST['Reservations'])) {
			$model->setAttributes($_POST['Reservations']);

			if ($model->save()) {
				Yii::log("Save success");
				$newStatus = $model->status ;
				if(strcmp($oldStatus,"Reserved")==0&&strcmp($newStatus,"Serviced")==0){
					//update service count for the subscription;
					$subs = Subscription::model()->findByAttributes(array('user_id'=>$model->user_id)) ;
					if($subs!==null){
						$subs->service_number++ ;
						$subs->save();
					}
					
				}else{
					if(strcmp($oldStatus,"Serviced")==0&&strcmp($newStatus,"Serviced")!=0){
					//update service count for the subscription;
						$subs = Subscription::model()->findByAttributes(array('user_id'=>$model->user_id)) ;
						if($subs!==null){
							$subs->service_number-- ;
							$subs->save();
						}
					}	
				}
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Reservations')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
//change as per rules for reserv
	public static function getSchedulesForLocation($companyId,$locId,$user){
		 $locSchedules = Yii::app()->db->createCommand()
		 ->select(' ls.id, ls.sched_date ,ts.slot_name, ts.slot_begin, ts.slot_end  ')
		 ->from(' location_schedule ls, time_slots ts ')
		 ->where('ls.ts_id = ts.id and ls.loc_id = '.$locId.' and ls.company_id='.$companyId.' and ls.sched_date > CURRENT_DATE and '//ls.sched_date < adddate(CURRENT_DATE ,INTERVAL 60 DAY) and '
		        .' ls.id not in (select schedule_id from reservations where user_id = '.$user. ' and status = "Reserved" ) ' )
		 ->order(' ls.sched_date asc ')
		 ->queryAll();		
		 return $locSchedules ;
	}
	public static function getCurrentReservations($user){
		 $history = Yii::app()->db->createCommand()
		 ->select(' ls.sched_date,ts.slot_name ,r.reserved_on, r.status,r.id,r.service_type,ml.location_address ')
		 ->from(' location_schedule ls, reservations r, time_slots ts, master_locations ml ')
		 ->where(' ls.ts_id = ts.id and ls.id = r.schedule_id and ml.id = ls.loc_id and r.status="Reserved" and r.user_id = '.$user)
		 ->order(' ls.sched_date desc ')
		 ->queryAll();		
		 return $history ;	
	}
	public static function getReservationHistory($user){
		 $history = Yii::app()->db->createCommand()
		 ->select(' ls.sched_date,ts.slot_name ,r.reserved_on, r.status,r.id,r.service_type ,ml.location_address ')
		 ->from(' location_schedule ls, reservations r, time_slots ts ,master_locations ml')
		 ->where(' ls.ts_id = ts.id and ls.id = r.schedule_id and ls.loc_id = ml.id and r.user_id = '.$user)
		 ->order(' ls.sched_date desc ')
		 ->queryAll();		
		 return $history ;	
	}
	private function getProfileStatus($userId){
		
		return  Yii::app()->db->createCommand()
		 ->select('  profile_complete_status, car_make, car_model, car_color, car_number_plate, location_id,company_id ')
		 ->where('user_id = '.$userId)
		 ->from(' profile ')
		 ->queryAll();	
	}
	
	/*
	 * function: getAvailableSchedules
	 * Algorithm:
	 * Check for the subscriber subscription start date and end date.
	 * 1. Is current date between the two,
	 * 2. If no return -1 ; /// this should have never been called.
	 * 3. If the current date is between the two check the number of 
	 * 		that have elapsed since the subscription had started 
	 * 		(why am I doing this?, check point 4 for the answer)
	 * 4. If the number of months that have elapsed is > 1 check the number of services
	 * 		that have been done. if = 12 return -2 all services consumed.
	 * 5. If the number of services < 12 get the number of reservations active
	 * 6. If the no of services + no of reservations = 12 return -3.
	 * 7. Now if the no of services and reservations < 12 then Start the action.
	 * 8. now based on the point 3 (no of months) get this months start and end date.
	 *    also get next months start and end date.
	 * 9. check if there is service that has been done or a reservation pending in current month.
	 *    if yes then only show schedule and do not allow to book
	 * 10. if there is no service or a reservation then show all schedule and allow to book also.
	 * 11.
	 * OK AFTER DISCUSSION WITH ANUJ IT WAS DECIDED THAT WE SHALL STICK TO THE CALENDAR BASED METHOD
	 * ALLOWING ONLY ONE CLEANING PER CALENDAR MONTH.  THIS SHALL MEAN THAT OUT OF A MAX 13 CALENDAR 
	 * MONTH OVERLAY PERIOD ONLY TWELVE SERVICING SHALL BE PERMITTED.
	 * THE REVISITED ALGO IS AS UNDER:
	 * 1. get the user subscription details,
	 * 2. check the no of services used if = 12 return null,
	 * 3. get the months of Reserved and Serviced reservations,
	 * 4. select location schedules that are not in these months.
	 * 
	 * Existing function for reference;
	 *  $locSchedules = Yii::app()->db->createCommand()
		 ->select(' ls.id, ls.sched_date ,ts.slot_name, ts.slot_begin, ts.slot_end  ')
		 ->from(' location_schedule ls, time_slots ts ')
		 ->where('ls.ts_id = ts.id and ls.loc_id = '.$locId.' and ls.company_id='.$companyId.' and ls.sched_date > CURRENT_DATE and '//ls.sched_date < adddate(CURRENT_DATE ,INTERVAL 60 DAY) and '
		        .' ls.id not in (select schedule_id from reservations where user_id = '.$user. ' and status = "Reserved" ) ' )
		 ->order(' ls.sched_date asc ')
		 ->queryAll();		
		 return $locSchedules ;
	 */

	
	public static function getRulesBasedSchedules($companyId,$locId,$user){
		$subs = Subscription::model()->findAllByAttributes(array('user_id'=>$user));
		
		$planId = $subs[0]['plan_id'] ;
		$plan = Plans::model()->findByPk($planId);
		
		$maxDate = ReservationController::getMaxDate($user);
		//echo '<p>';
		//echo $maxDate ;
		//echo '<p>';
		//echo $subs[0]['start_date'];
		//echo '<p>';
		//echo $subs[0]['expiry_date'];
		//echo '<p>';
		//echo '<p>';
		
		$startDate = ReservationController::getStartingDate($maxDate, $plan->plan_freq, $subs[0]['start_date'], $subs[0]['expiry_date']);
		
$cmd= Yii::app()->db->createCommand()
                ->select(' ls.id, ls.sched_date,ts.slot_name, ts.slot_begin,ts.slot_end  ')
                ->from(' location_schedule ls, time_slots ts ')
                ->where(' ls.ts_id = ts.id and ls.loc_id=:locId and ls.company_id=:companyId and ls.sched_date > :startDate ',array('locId'=>$locId,'companyId'=>$companyId,'startDate'=>$startDate)  )
                ->order( ' ls.sched_date ASC ');


		
/*		$locSchedules = Yii::app()->db->createCommand()
		->select(' ls.id, ls.sched_date,ts.slot_name, ts.slot_begin,ts.slot_end  ')
		->from(' location_schedule ls, time_slots ts ')  
		->where(' ls.ts_id = ts.id and ls.loc_id=:locId and ls.company_id=:companyId and ls.sched_date > :startDate ',array('locId'=>$locId,'companyId'=>$companyId,'startDate'=>$startDate)  )
				->order( ' ls.sched_date ASC ')
				->queryAll();*/
		$locationSchedules = $cmd->queryAll();
		return $locationSchedules ;	
		//var_dump($locSchedules);
		
//		$subs = Subscription::model()->findByAttributes(array('user_id'=>$userId)) ;
//		if($subs->service_number==12) return null ;
/* 		$locSchedules = Yii::app()->db->createCommand()
    ->select(' ls.id, ls.sched_date,ts.slot_name, ts.slot_begin,ts.slot_end  ')
    ->from(' location_schedule ls, time_slots ts ')   //->join('tbl_profile p', 'u.id=p.user_id') ->where('id=:id', array(':id'=>$id))
    ->where(' ls.ts_id = ts.id and ls.loc_id=:locId and ls.company_id=:companyId and ls.sched_date > CURRENT_DATE and '
    		.' month(ls.sched_date) not in (select month(l.sched_date) from reservations r , location_schedule l where r.schedule_id = l.id and '
    		.' r.user_id=:userId and (r.status = "Reserved" or r.status="Serviced")) ',array('locId'=>$locId,'companyId'=>$companyId,'userId'=>$user)  )
    ->order( ' ls.sched_date ASC ')
    ->queryAll();
   	return $locSchedules; 
 */	}
	public static function getMaxDate($user){
		$lastReserved = Yii::app()->db->createCommand()
		->select(' max(ls.sched_date) as maxDate ')
		->from(' location_schedule ls, reservations r ')   
		->where(' ls.id = r.schedule_id and r.user_id=:userId and (r.status = "Reserved" or r.status="Serviced") ',
				array('userId'=>$user)  )
		->queryAll();
		
		//echo "Count of maxDate is :".count($lastReserved);
		if(count($lastReserved)>0){
			//var_dump($lastReserved[0]['maxDate'] );
		}
		return $lastReserved[0]['maxDate'];

	}
	public static function getStartingDate($lastReservedDate,$planFreq,$subsStart,$subsEnd){
		
		$currDate = new DateTime(); // get current date
		
		if($lastReservedDate==null){
			//echo "<p>Last reserved is null";
			//echo '<p>returning'. '\''.$currDate->format('Y/m/d').'\'' ;
			return $currDate->format('Y/m/d') ;
		}

		$subsStart = explode('-',$subsStart);
		$subsEnd = explode('-',$subsEnd);
		$lastReserved = explode('-',$lastReservedDate);
		
		$freq = $planFreq ;//get Frequency of the plan
		$sDate = new DateTime(); //lastReservedDate
		$eDate = new DateTime(); //expiry date
		$fDate = new DateTime(); // dummy date holder
 		$rDate = new DateTime(); //reserved date
 		
		$sDate->setDate($subsStart[0],$subsStart[1],$subsStart[2]); // subscription start date for user
		$eDate->setDate($subsEnd[0],$subsEnd[1],$subsEnd[2]); //get subscription expiry date for user
		$rDate->setDate($lastReserved[0],$lastReserved[1],$lastReserved[2]); //get last reserved
		 
		//echo "<p/>Old Date ";
		//echo $sDate->format('Y-m-d H:i:s') ;
		//echo "<p/>Reserved ";
		//echo $rDate->format('Y-m-d H:i:s') ;
			
		while($sDate < $eDate){
			$fDate->setTimestamp($sDate->getTimestamp()) ;
			$sDate = $sDate->add(new DateInterval('P'.$freq.'M'));
			//echo "<p/>From: ";
			//echo $fDate->format('Y-m-d H:i:s') ;
			//echo "To:";
			//echo $sDate->format('Y-m-d H:i:s') ;
				
			if($rDate >= $fDate && $rDate < $sDate){
				//echo "<p>Interval found";
				if($sDate < $eDate){
					if($sDate>$currDate){
					//echo "<p>returning date ".'\''.$sDate->format('Y/m/d').'\'' ;
					return $sDate->format('Y/m/d');
					}else{
						//echo "<p>returning current date ".'\''.$currDate->format('Y/m/d').'\'' ;
						return $currDate->format('Y/m/d') ;
							
					}
					
				}else return null ;
			}
		}
		return null ;
		
	}
	
	public function actionIndex() {
		$this->layout = "//layouts/userLayout" ;
	//	$dataProvider = new CActiveDataProvider('Reservations');

		$id = Yii::app()->user->id;
		$profileStatus = $this->getProfileStatus($id);
		$locationId = $profileStatus[0]['location_id'];
		$companyId = $profileStatus[0]['company_id'];

		$locationName = MasterLocations::getLocationNameFromId($locationId) ;
		//check for status  created, mandate generated, ideal payment on, 
		 if(strcmp($profileStatus[0]['profile_complete_status'],'Created')==0){
		 	$this->redirect(array('/reservation/subscription/order'),true);
		 }
		 if(strcmp($profileStatus[0]['profile_complete_status'],'Mandate Generated')==0){
		 	$this->redirect(array('/reservation/subscription/order'),true);
		 }
		 if(empty($profileStatus[0]['car_make'])||
		 	(empty($profileStatus[0]['car_model']))||
		 	(empty($profileStatus[0]['car_color']))||
		 	(empty($profileStatus[0]['car_number_plate']))){
		 		Yum::setFlash(Yii::t('reservation','Please complete your profile before making reservations')) ;
		 			$this->redirect(array('/reservation/account/update'),true);
		 	}else{	
			//check for expiry of subscription here
			$reservations = $this->getReservationHistory($id);
			$subscription = Subscription::model()->findByAttributes(array('user_id'=>$id)) ;
			$serviceType = Plans::getNextService($subscription);
			//$lsched = $this->getSchedulesForLocation($companyId,$locationId,$id);
			$lsched = $this->getRulesBasedSchedules($companyId, $locationId, $id);
			$this->render('index', array(
					'history' => $reservations,
					'location' => $locationName,
					'newSched' => $lsched,
					'serviceType' => $serviceType
					));
		 	}
	
	}
	public static function cancelReservation($reservId){
			$reserve = Reservations::model()->findByPk($reservId) ;
			//check if the status is already cancelled here.
			$reserve->status = 'Cancelled';
			$now = new DateTime('now');
			$reserve->last_status_changed_on = $now->format('Y-m-d H:i') ;
			$reserve->changed_by = 'You';
			return ($reserve->save()) ;
	}
	public function actionCancel(){
		if(isset($_POST['id'])){
			$reservId = $_POST['id'] ;
			if(self::cancelReservation($reservId))
				$this->redirect('index');
			else throw CHttpException(920,"Unable to cancel.");
		}
	}
	public static function makeReservation($schedId,$userId,$servType){
			$reserve = new Reservations ;
			$reserve->user_id = $userId;
			//TODO:: check if schedule exists
			$reserve->schedule_id = $schedId ;
			$reserve->status = 'Reserved';
			$reserve->service_type = $servType ;
			$now = new DateTime('now');
			$reserve->reserved_on = $now->format('Y-m-d H:i') ;
			$reserve->changed_by = 'You';
			return ($reserve->save()) ;
	}
	public function actionReserve(){
		if(isset($_POST['id'])){
			$schedId = $_POST['id'] ;
			$servType = $_POST['type'] ;
			if(self::makeReservation($schedId, Yii::app()->user->id, $servType) )
				$this->redirect('index');
			else throw CHttpException(920,"Unable to reserve.");
		}
	}

	public function actionAdmin() {
		$this->layout="//layouts/adminLayout" ;
		$model = new Reservations('search');
		$model->unsetAttributes();

		if (isset($_GET['Reservations']))
			$model->setAttributes($_GET['Reservations']);
		$this->render('admin', array(
			'model' => $model,
		));
	}

}
