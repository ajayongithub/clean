<?php

class RosterController extends Controller
{
	const TIME_EXT_CLN= 20 ;
	const TIME_COMP_CLN = 30 ;
	const PERS_PER_CAR = 2 ;
	public $layout = "//layouts/adminLayout" ;	
	private function getUniqueFutureDates(){
		$dates = Yii::app()->db->createCommand()
		 ->select(' distinct(sched_date) as sched_date ')
		 ->from(' location_schedule ')
		 ->where(' CURRENT_DATE() <= sched_date ')
		 ->order(' sched_date ')
		 ->queryAll();		
		 $retArr = array();
		 $indx = 0 ;
		 foreach($dates as $sdate){
		 	$sch = $sdate["sched_date"] ;
			$retArr[$sch] = $sch;
		 }

		 return $retArr;
	}	
	private function getSchedulesForDate($sDate){
		$schedules = Yii::app()->db->createCommand()
		 ->select(' ls.id, c.company_name as company_name, ml.location_address, ml.location_city, ml.location_zipcode, ts.slot_name, ts.slot_begin, ts.slot_end ')
		 ->from(' location_schedule ls, company c, company_location cl, master_locations ml , time_slots ts ')
		 ->where(' ls.sched_date="'.$sDate.'" and ls.company_id = cl.company_id and ls.loc_id = cl.location_id and ls.ts_id = ts.id '
		 			.' and c.id = cl.company_id and ml.id=cl.location_id ')
		 ->order(' ml.location_city ')
		 ->queryAll();
		 return $schedules;
	}
	public function actionGetSchedules(){

		if (!Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
		$sDate = $_POST['schedDate'];
		$schedules = $this->getSchedulesForDate($sDate) ;
		$reserv = array() ;
		$profiles = array();
		$time = array();
		$cleaners  = array() ;
		$scheduledCleaners = array();
		$vehicles = array();
		$vehiclesAssigned = array();
		
		//$employees = Employees::model()->findAll();//ByAttributes(array('emp_base_location'=>$sched['location_city']));
		$employees = Employees::model()->findAllByAttributes(array('emp_designation'=>'Cleaner'));
		$availCars = CleaningCars::model()->findAll();
		//Yii::log("Starting proecessing for date ".$sDate) ;
		foreach($schedules as $sched){
			//Yii::log("Processing schedule for ".$sched['company_name']." at city ".$sched['location_city'].' at location '.$sched['location_address']) ;
			$extOnly = 0 ; $extInt = 0 ;
			$reserv[$sched["id"]] = array() ;
			$reservations = Reservations::model()->findAll('schedule_id=:sid and status=:stts',array('sid'=>$sched['id'],'stts'=>'Reserved')) ;
			for($indx = 0 ; $indx < count($reservations); $indx++){
				$reserv[$sched["id"]][$indx] = $reservations[$indx];
				($reservations[$indx]->service_type==Plans::EXTERIOR) ? $extOnly++ : $extInt++ ;
				$profiles[$reservations[$indx]->id] = YumProfile::model()->findByAttributes(array('user_id'=>$reservations[$indx]->user_id));
			}
			$minutesNeeded = $extInt * self::TIME_COMP_CLN + $extOnly * self::TIME_EXT_CLN ;
		 	$timeAvail  = (strtotime($sched['slot_end'])	-	strtotime($sched['slot_begin']))/60 ;
			$time[$sched['id']]=$minutesNeeded ;		
			$noOfCleanersReqd = intval($minutesNeeded /$timeAvail) + 1 ;
			$noOfCars = intval($noOfCleanersReqd/self::PERS_PER_CAR);
			$noOfCars += (($noOfCleanersReqd % self::PERS_PER_CAR)==0)?0:1 ; 
			$tsBeginIndex = (strtotime($sched['slot_begin']) - strtotime('09:00:00'))/(60*10) ; 	
			$tsEndIndex = (strtotime($sched['slot_end']) - strtotime('09:00:00'))/(60*10) ;
			for($eIndex = 0 ; $eIndex < count($employees) && $noOfCleanersReqd >0 ; $eIndex++){
				$available = false ;
				$employee = $employees[$eIndex] ;
				if(!isset($cleaners[$employee->id])){//check if already assigned if not add
					//Yii::log('Employee id is not set') ;
					$cleaners[$employee->id]=array();
					for($i=0;$i<48;$i++)$cleaners[$employee->id][$i] = -1 ; 
					$available = true ;
				}else{//is set cleaner employee id check if employee is free in the time slot
					$available = true ;
					for($lIndex = $tsBeginIndex ; $lIndex < $tsEndIndex ; $lIndex++){
						if($cleaners[$employee->id][$lIndex]!=-1) {
							$available=false ;
					//		Yii::log('Employee id is already assigned ') ;
							break ;	
						}
					}
				}//end of if not set cleaner -> employee ->id 
				if($available==true){
					for($indx = $tsBeginIndex ; $indx < $tsEndIndex ; $indx++) $cleaners[$employee->id][$indx] = $sched['id'] ;
					if(!isset($scheduledCleaners[$sched['id']])) $scheduledCleaners[$sched['id']] =array();
					array_push($scheduledCleaners[$sched['id']],$employee->id);
					//Yii::log('Adding Employee '.$employee->id);
					$noOfCleanersReqd--;
				}else{
				//Yii::log('Could not find employee') ;
				}
			}
			$vehicles[$sched["id"]]=array();

		for($carIndex = 0 ; $carIndex < count($availCars) && $noOfCars > 0; $carIndex++){
				if(in_array($availCars[$carIndex]->id,$vehiclesAssigned)==false){
					//echo ":Added in vehicles <br/>"; 
					array_push($vehicles[$sched["id"]] , $availCars[$carIndex]->id)  ;
					array_push($vehiclesAssigned,$availCars[$carIndex]->id) ; 
					$noOfCars-- ;
					//print_r($vehicles);
				}
			}
		}
		echo $this->renderPartial('_schedulesForm',array('sDate'=>$sDate,'schedules'=>$schedules,'reserv'=>$reserv,'profiles'=>$profiles,'scheduled'=>$scheduledCleaners,'vehicles'=>$vehicles),false,true);
	}
	public function actionSaveRoster(){
		$cleaners = $_POST['schd'];
		$extras = $_POST['extra'];
		$teamLead = $_POST['teamLead'];
		$schedDate = $_POST['schedDate'] ;
		$cars = $_POST['cars'] ;
//		foreach($cleaners as $id=>$cleaner){
	if(isset($cleaners)){
		foreach($cleaners as $id=>$clnr){
			Roster::deletePreviousScheduleEntry($id) ;
		}
			foreach($cleaners as $id=>$cleaner){
				if(isset($cleaners[$id])){
					foreach($cleaners[$id] as $clnr){
						$model = new Roster();
						$model->sched_id = $id ;
						$model->emp_id = $clnr ;
						$model->cleaner = 1 ;
						$model->team_lead = 0 ;
						$model->extra_cleaner = 0 ;
						$model->save();
					}
				}
				if(isset($extras[$id])){
					$model = new Roster();
						$model->sched_id = $id ;
						$model->emp_id = $extras[$id] ;
						$model->cleaner = 0 ;
						$model->team_lead = 0 ;
						$model->extra_cleaner = 1 ;
						$model->save();
				}
				if(isset($teamLead[$id])){
					$model = new Roster();
						$model->sched_id = $id ;
						$model->emp_id = $teamLead[$id] ;
						$model->cleaner = 0 ;
						$model->team_lead=1 ;
						$model->extra_cleaner = 0 ;
						$model->save();
				}
				if(isset($cars[$id])){
					
				foreach($cars[$id] as $car){
						$model = new Roster();
						$model->sched_id = $id ;
						$model->emp_id = $car ;
						$model->cleaner = 0 ;
						$model->team_lead = 0 ;
						$model->extra_cleaner = 0 ;
						$model->save();
					}
				}

			}
			$obj->s = 1 ;
			$obj->status = "Roster Data Saved.";
			echo CJSON::encode($obj) ;
	}else{
			$obj->s = 0 ;
			$obj->status = "Invalid Data Received, roster could not be saved.";
			echo CJSON::encode($obj) ;
		
	}

		//$this->render('saved',array('schedDate'=>$schedDate,'cleaners'=>$cleaners,'extras'=>$extras,'teamLead'=>$teamLead,'cars'=>$cars));
		
	}
	/*redundant code
	public function actionGetSchedulesWithBaseLocation(){
		if (!Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
		$sDate = $_POST['schedDate'];

		$schedules = Yii::app()->db->createCommand()
		 ->select(' ls.id, c.company_name as company_name, ml.location_address, ml.location_city, ml.location_zipcode, ts.slot_name, ts.slot_begin, ts.slot_end ')
		 ->from(' location_schedule ls, company c, company_location cl, master_locations ml , time_slots ts ')
		 ->where(' ls.sched_date="'.$sDate.'" and ls.company_id = cl.company_id and ls.loc_id = cl.location_id and ls.ts_id = ts.id '
		 			.' and c.id = cl.company_id and ml.id=cl.location_id ')
		 ->order(' ml.location_city ')
		 ->queryAll();
		 $reserv = array() ;
		 $profiles = array();
		 $time = array();
		 $cleaners  = array() ;
		 $scheduledCleaners = array();
		foreach($schedules as $sched){
			Yii::log("Processing schedule ".$sched["id"]) ;
			$extOnly = 0 ; $extInt = 0 ;
			$reserv[$sched["id"]] = array() ;
			$reservations = Reservations::model()->findAll('schedule_id=:sid',array('sid'=>$sched['id'])) ;
			for($indx = 0 ; $indx < count($reservations); $indx++){
				$reserv[$sched["id"]][$indx] = $reservations[$indx];
				($reservations[$indx]->service_type==Plans::EXTERIOR) ? $extOnly++ : $extInt++ ;
				$profiles[$reservations[$indx]->id] = YumProfile::model()->findByAttributes(array('user_id'=>$reservations[$indx]->user_id));
			}
			$minutesNeeded = $extInt * self::TIME_COMP_CLN + $extOnly * self::TIME_EXT_CLN ;
		 	$timeAvail  = (strtotime($sched['slot_end'])	-	strtotime($sched['slot_begin']))/60 ;
			$time[$sched['id']]=$minutesNeeded ;		
			$noOfCleanersReqd = intval($minutesNeeded /$timeAvail) + 1 ;
			Yii::log('No of Cleaners Required '.$noOfCleanersReqd) ;
			$employees = Employees::model()->findAllByAttributes(array('emp_base_location'=>$sched['location_city']));
			$tsBeginIndex = (strtotime($sched['slot_begin']) - strtotime('09:00:00'))/(60*10) ; 	
			$tsEndIndex = (strtotime($sched['slot_end']) - strtotime('09:00:00'))/(60*10) ;
			for($eIndex = 0 ; $eIndex < count($employees) && $noOfCleanersReqd >0 ; $eIndex++){
				$available = false ;
				$employee = $employees[$eIndex] ;
				if(!isset($cleaners[$employee->id])){
					$cleaners[$employee->id]=array();
					for($i=0;$i<48;$i++)$cleaners[$employee->id][$i] = -1 ; 
					$available = true ;
				}else{
					$available = true ;
					for($lIndex = $tsBeginIndex ; $lIndex < $tsEndIndex ; $lIndex++){
						if($cleaners[$employee->id][$lIndex]!=-1) {
							$available=false ;
							break ;	
						}
					}
				}
				if($available==true){
					for($indx = $tsBeginIndex ; $indx < $tsEndIndex ; $indx++) $cleaners[$employee->id][$indx] = $sched['id'] ;
					if(!isset($scheduledCleaners[$sched['id']])) $scheduledCleaners[$sched['id']] =array();
					array_push($scheduledCleaners[$sched['id']],$employee->id);
					Yii::log('Adding Employee '.$employee->id);
					$noOfCleanersReqd--;
				}
				
			}
			
		}
		 
		echo $this->renderPartial('_schedulesForm',array('sDate'=>$sDate,'schedules'=>$schedules,'reserv'=>$reserv,'profiles'=>$profiles,'scheduled'=>$scheduledCleaners),false,true);
	}

	private function findCleaner($cleaners,$available,$sched){
		
	}
	*/
	public function actionGetReservations(){
		$scheds = $_POST['scheds'] ;
		$arr = array();
		parse_str($scheds,$arr);//serialize returns id=on&id1=on&id2=on....., parse str splits id an values.
		$ids = array_keys($arr);
		$idStr = implode(',',$ids) ;
		$reservations = Yii::app()->db->createCommand()
		 ->select(' * ')
		 ->from(' reservations ')
		 ->where(' status="Reserved" and schedule_id in ('.$idStr .')')
		 ->order(' schedule_id ')
		 ->queryAll();		
		echo $this->renderPartial('_reservationForm',array('reservations'=>$reservations),false,true);
	}
	public function actionIndex()
	{
		Yii::import('application.modules.common.models.*');
		$dates = $this->getUniqueFutureDates() ;
		$this->render('roster',array('sdates'=>$dates)) ;
		/*$schedules = new LocationSchedule('search') ;
		$schedules->sched_date = date('2013-07-25');
		$this->render('index',array('ls'=>$loopSched));
		$strDate = '2013-07-25'	;
		for($i=0;$i<10;$i++){
			$startDate =  strtotime($strDate. ' + '.$i.' days');
			echo date('Y-m-d',$startDate).'<br/>';
		$schedules = LocationSchedule::model()->findAll('sched_date = :sDate',array('sDate'=>date('Y-m-d',$startDate))) ;
		foreach($schedules as $schedule){
			echo 'Schedule Id '.$schedule->id.'<br/>';
			$reservation = Reservations::model()->findAll('schedule_id=:schId',array('schId'=>$schedule->id));	
			foreach($reservation as $booking){
				echo '1.            Booked for :'.$booking->user_id.'<br/>';
			}
		}
		}*/
	}

	public function actionGetPersonnel(){
		$scheds = $_POST['scheds'] ;
		$arr = array();
		parse_str($scheds,$arr);//serialize returns id=on&id1=on&id2=on....., parse str splits id an values.
		$ids = array_keys($arr);
	//	$idStr = implode(',',$ids) ;
		foreach($ids as $schedId){
			//$schedId = $ids[$i] ;
			$ls = LocationSchedule::model()->findByPk($schedId) ;
			$ts = TimeSlots::model()->findByPk($ls->ts_id) ;
			$reservations = Reservations::model()->findAll('schedule_id = :sid',array('sid'=>$ls->id)) ;
			echo gmdate('H:i:s',(strtotime($ts->slot_end)-strtotime($ts->slot_begin))) .'<br/>' ;
			$cml = CompanyMasterLocations::model()->findByAttributes(array('location_id'=>$ls->loc_id,'company_id'=>$ls->company_id));
			$cleaners = Employees::model()->findAllByAttributes(array('emp_base_location'=>$cml->location_city)) ;
//			var_dump($cleaners) ;
			echo "For city".$cml->location_city.' company '.$cml->company_name.' location '.$cml->location_address." in time slot ".$ts->slot_name." no of cars ".count($reservations).'<br/>' ;
			foreach($cleaners as $cleaner){
				echo "Cleaner : ".$cleaner->emp_name.' <br/>' ;
			}
			/*
			echo $ts->slot_begin.'----'.$ts->slot_end .'<br/>' ;
			$time1 = strtotime($ts->slot_begin);
			$time2 = strtotime($ts->slot_end);

			echo $time1 .'-------------'.$time2.'<br/>' ;
			$diff = $time2 - $time1;
			echo 'direct '.date('i:s',14400).'<br/>' ;
			echo $diff.'<br/>' ;
			echo 'Time 1: '.date('H:i', $time1).'<br/>';
			echo 'Time 2: '.date('H:i', $time2).'<br/>';

			if($diff){
    			echo 'Time Available: '.date('H:i:s', $diff).'<br/>';
			}else{
			    echo 'No Diff.';
			}
			*/
		}	
		
	}
	private function initDS($locCount,$empCount,$tsCount){
		$arr = array(array(array())) ;
		//location, employee, time 
		for($locid = 0 ; $locid < $locCount ; $locid++) {
			for($empId = 0 ; $empId < $empCount ; $empId++){
				for($ts = 0 ; $ts<$tsCount ; $ts++){
						$arr[$locid][$empId][$ts] = 0;
				}
			}
		 }
		return $arr ;
	}
	private function getCompanyMasterLocation($city){
		$mls =  Yii::app()->db->createCommand()
		 ->select(' `c`.`id` AS `company_id`,`c`.`company_name` AS `company_name`,`ml`.`id` AS `location_id`,`ml`.`location_address` AS `location_address`,`ml`.`location_city` AS `location_city`,`ml`.`location_zipcode` AS `location_zipcode`,`cl`.`remark` AS `remarks`' )
		 ->from('`company` `c` , `company_location` `cl`, `master_locations` `ml`')
		 ->where(' `c`.`id` = `cl`.`company_id`) and (`cl`.`location_id` = `ml`.`id`)')
		 ->order(' ml.location_city ')
		 ->queryAll();
	}
	public function actionGenerateRoster(){
		$cities = Yii::app()->db->createCommand()
		 ->select(' distinct(location_city)  as cit ')
		 ->from(' master_locations ')
		 ->order(' cit ')
		 ->queryAll();		
		 $rDate = '2013/08/05';
		 for($i = 0 ; $i < 3 ; $i++){
		 	$city = $cities[$i]['cit'] ;
		 	echo $city ;
		 	$employees = Employees::model()->findAllByAttributes(array('emp_base_location'=>$city)) ;//getting employees in a city
		 	//$mls = CompanyMasterLocations::model()->findAllByAttributes(array('location_city'=>$city));	//getting all company master locations in a city
		 	$mls = $this->getCompanyMasterLocation($city) ;
		 	$locCount = count($mls) ; $empCount= count($employees) ;
		 	$roster = $this->initDS(count($mls),count($employees),48);//10 min slots for 8 hours will be 48 slots
		 	for($locIndex = 0 ; $locIndex < $locCount ; $locIndex++){
		 	//	echo 'Memory Used is '.memory_get_usage() ;
		 		$ml = $mls[$locIndex] ;
		 		// now based on the city locations get schedules for these CMLS for a date.
		 		$scheds = LocationSchedule::model()->findAllByAttributes(array('loc_id'=>$ml->location_id,
		 																		'company_id'=>$ml->company_id,
		 																		'sched_date'=>$rDate	));
		 		echo '<br/>'.$city .' Location '.$ml->location_address.' company '.$ml->company_name.' employees '.count($employees).'<br/>' ;
		 		foreach($scheds as $sched){
		 			$reservs = Reservations::model()->findAllByAttributes(array('schedule_id'=>$sched->id))	;
		 			$ts = TimeSlots::model()->findByPk($sched->ts_id);
		 			echo "Time Slots:".$ts-> slot_name." No of Reservations made : ".count($reservs).'<br/>';
					$rand = 0 ; 
		 			foreach($reservs as $reserv){
		 				$serviceType = mt_rand()%2 ; 
		 				$timeTaken = array('0'=>2,3) ;//in no of slots
		 				$roster = $this->assignEmployee($roster,$ts,$reserv,$locIndex,$locCount,$empCount,$timeTaken[$serviceType]);	
		 			}

		 		}
		 		for($rEmpIndex = 0 ; $rEmpIndex < $empCount ; $rEmpIndex++){
		 			echo '<br/>Employee '.$employees[$rEmpIndex]->emp_name.' ';
		 			for($rTsIndex = 0 ; $rTsIndex < 48 ; $rTsIndex++){
		 				echo ' '.$roster[$locIndex][$rEmpIndex][$rTsIndex].' ';
		 			}
		 		}
		 	}
		 	
		 }
		 
	}
	public function assignEmployee($roster,$ts,$reserv,$locIndex,$locCount,$empCount,$serviceType){
		//search for the first free employee during the time slot time. for that location.
		// for this we need to check the time slot occupancy of all the locations prior to this 
		// for that employee.  This will be done by checkning the content of the matrix for the given time slot index 
		//prior to the current numeric location index.  
		//Also we shall need to check if any employee has been assigned to a car in this location as well.  If so then we continue to fill 
		// the particular employees slot first.
		//0 to 23 for 0900 to 1300 and
		//24 to 47 for 1300 to 1700.
		$tsBeginIndex = (strtotime($ts->slot_begin) - strtotime('09:00:00'))/(60*10) ; 	
		$tsEndIndex = (strtotime($ts->slot_end) - strtotime('09:00:00'))/(60*10) ;
		for($empIndex = 0 ; $empIndex < $empCount ; $empIndex++){
			//is there an employee already assigned to this location for the time slot
			$assigned = false;
			for($tsIndex = $tsBeginIndex ; $tsIndex<$tsEndIndex&&$assigned==false ; $tsIndex++){
				if($roster[$locIndex][$empIndex][$tsIndex]!=0){
					$assigned = true ;
				}	
			}
			//somebody has been assigned also there is a free slot to put in the reservation
			// so do it and return.
			if($assigned==true){ 
				for($tsIndex=$tsBeginIndex ; $tsIndex<($tsEndIndex-$serviceType); $tsIndex++){
					if($roster[$locIndex][$empIndex][$tsIndex]==0){
						$roster = $this->markReservation($roster,$locIndex,$empIndex,$tsIndex,$serviceType,$reserv) ;
						return $roster;
					}
				}	
			//	$noSlotsFree = true ;
			}
			//if not assigned then check for all previous location indexes if the employee has been marked 
			//for a location within the same time slot.
			$assignedElsewhere = false ;
			if(!$assigned){
				for($prevLoc = 0 ; $prevLoc < $locIndex&&$assignedElsewhere==false ; $prevLoc++){
					for($tsIndex = $tsBeginIndex ; $tsIndex<$tsEndIndex&&$assignedElsewhere==false ; $tsIndex++){
						if($roster[$prevLoc][$empIndex][$tsIndex]!=0){
							$assignedElsewhere = true ;
						}	
					}
				}
			//now if the employee is not assigned else where as well check what is to be done
			if($assignedElsewhere==false){
				$roster = $this->markReservation($roster, $locIndex, $empIndex, $tsBeginIndex, $serviceType, $reserv);
				return $roster;
			}
			}
		}
			return $roster ;			
		
		
	}
	private function markReservation($roster,$locIndex,$empIndex,$tsIndex,$servType,$reserv){
		for($slotIndex = 0 ; $slotIndex < $servType ; $slotIndex++){
			$roster[$locIndex][$empIndex][$tsIndex+$slotIndex] = $reserv->id ;
		}
		return $roster ;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}