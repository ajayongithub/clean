<?php
Yii::import('application.modules.reservation.controllers.ReservationController') ;
class EndPointHandlerController extends Controller
{	
	private function getCommand($sql){
			
		return Yii::app()->db->createCommand($sql) ;
	}
	private function getRows($command){
		$dataReader = $command->query() ;
		$rows = $dataReader->readAll();	
   	$dataReader->close();
		return $rows ;
	}
	public function actionCancelReservation()
	{
		$userId= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		if(isset($_REQUEST['itemId'])){
			$reservId = $_REQUEST['itemId'] ;
		}
		$obj->s = 0 ;
		$profile = YumProfile::model()->findByAttributes(array('user_id'=>$userId));
		if($profile!=null){
			if(ReservationController::cancelReservation($reservId)){
				 $obj->s=1 ;$status = "Reservation Cancelled" ;
		     $reserv = ReservationController::getCurrentReservations($userId) ;
				 if(count($reserv)>0){
		 				$obj->data = $reserv;
		 		 }else{
						$obj->s=0 ; $obj->error = "No Pending Reservations Present.";
						 }
			}else{
				$obj->s=0 ; $obj->error = "Unable to cancel Reservation. Please contact administrator.";
			}
		}else{
			$obj->s=0 ; $obj->error = "No User Profile Found. Please contact administrator.";
		}
		 echo json_encode( $obj) ;	
	}

	public function actionGetAvailableSchedules()
	{
		$userId= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		$profile = YumProfile::model()->findByAttributes(array('user_id'=>$userId));
		if($profile!=null){
		 $sched = ReservationController::getSchedulesForLocation($profile->company_id, $profile->location_id, $userId);
		 if(count($sched)>0){
		 $obj->s=1 ;$obj->data = $sched ;
		 }else{
			$obj->s=0 ; $obj->error = "No available slot currently availabe.";
		 }
		}else {
			$obj->s=0 ; $obj->error = "No User Profile Found. Please contact administrator.";
		}
		 echo json_encode( $obj) ;	
	}

	public function actionGetHistory()
	{
		$userId= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		$profile = YumProfile::model()->findByAttributes(array('user_id'=>$userId));
		if($profile!=null){
		 $history = ReservationController::getReservationHistory($userId) ;
		if(count($history)>0){
		$obj->s=1 ;$obj->data = $history ;
		}else{
			$obj->s=0 ; $obj->error = "No previous service records present." ;
		}
		}else  {
			$obj->s=0 ; $obj->error = "No User Profile Found. Please contact administrator.";
		}
		 echo json_encode( $obj) ;	
	}
	public function actionGetReservations()
	{
		$userId= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		$profile = YumProfile::model()->findByAttributes(array('user_id'=>$userId));
		if($profile!=null){
		 $history = ReservationController::getCurrentReservations($userId) ;
		 if(count($history)>0){
		 	$obj->s=1 ;$obj->data = $history ;
		}else{
			$obj->s=0 ; $obj->error = "No Reservations currently pending.";
		}
		}else  {
			$obj->s=0 ; $obj->error = "No User Profile Found. Please contact administrator.";
		}
		 echo json_encode( $obj) ;	
	}

	public function actionGetSubscription()
	{
		$userId= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		
		$subscription = Subscription::model()->findByAttributes(array('user_id'=>$userId));
		Yii::import('application.modules.reservation.controllers.*') ;
		if($subscription!=null){
			$expiry = $subscription->expiry_date ;
			$start = $subscription->start_date ;
			
			if(strtotime('now')>strtotime($expiry)) {
						$obj->s = 0 ; $obj->status = "You subscription has expired. Please Visit the website for renewal.";
			}else if(strtotime('now')>strtotime($start)) {
						$model = Plans::model()->findByAttributes(array('id'=>$subscription->plan_id));
						$obj->s = 1 ; $obj->status = "You have an active subscription.";
						$data->plan_name = $model->plan_name; 
						$data->expiry_date = $subscription->expiry_date ;
						$data->start_date = $subscription->start_date ;
						$obj->data = $data ;
			}else {
				$obj->s = 0 ; $obj->status = "You are currently not subscribed to any of our plans. Please Visit the website for subscription.";
			}
		}else {
				$obj->s = 0 ; $obj->status = "You are currently not subscribed to any of our plans. Please Visit the website for subscription.";
		}
		echo json_encode($obj);
		}

	public function actionGetUserProfile()
	{
		 $user = $_REQUEST['userId'] ;
	 $command=$this->getCommand( 'select id from user where id=:user');
   $command->bindParam(':user', $user, PDO::PARAM_STR);
	 $rows=$this->getRows($command);
	 if(count($rows)==0){
	 	$obj->s = 0 ;
		$obj->error = 'No such user exists.';
	 }else{
	 	 $command=$this->getCommand( 'select firstname,initials,lastname,email,telephone_work,car_make,car_model,car_color,car_number_plate from profile where user_id=:id');
		 $userId = $rows[0]['id'] ;
 	   $command->bindParam(':id', $userId, PDO::PARAM_INT);
		 $rows=$this->getRows($command);
		 if(count($rows)==0){
		 	$obj->s = 0 ;
			$obj->error = 'No Profile for User' ;
		 }else{
		  $profile = $rows[0] ;
		 	$obj->s = 1 ;
			
			$userData->name = $profile['firstname'].' '.$profile['initials'].' '.$profile['lastname'] ;
			$userData->email = $profile['email'] ;
			$userData->phone = $profile['telephone_work'] ;
			$userData->make = $profile['car_make'] ;
			$userData->model = $profile['car_model'] ;
			$userData->color = $profile['car_color'] ;
			$userData->number = $profile['car_number_plate'] ;
			$obj->data = $userData ;
	}
	 }
	 echo json_encode($obj);
	}

	public function actionLogin()
	{
		$username = ""; $passwd = "" ;
		if(isset($_REQUEST['username'])){
			$username = $_REQUEST['username'] ;
		}
		if(isset($_REQUEST['passwd'])){
			$passwd = $_REQUEST['passwd'] ;
		}
		$identity = new YumUserIdentity($username, $passwd);
		$identity->authenticate();
		$obj->s=0 ;
		// check for app version here also!!!
		switch($identity->errorCode) {
			case YumUserIdentity::ERROR_NONE:
				$obj->s = 1 ; $obj->status = "Success" ; $data->uid = $identity->id ;
				$obj->data = $data ;
				break;
			case YumUserIdentity::ERROR_EMAIL_INVALID:
				//$this->loginForm->addError("password",Yum::t('Username or Password is incorrect'));
				$obj->s = 0 ;
				break;
			case YumUserIdentity::ERROR_STATUS_INACTIVE:
				//$this->loginForm->addError("status",Yum::t('This account is not activated.'));
				$obj->s = 0 ;
				break;
			case YumUserIdentity::ERROR_STATUS_BANNED:
				//$this->loginForm->addError("status",Yum::t('This account is blocked.'));
				$obj->s = 0 ;
				break;
			case YumUserIdentity::ERROR_STATUS_REMOVED:
				//$this->loginForm->addError('status', Yum::t('Your account has been deleted.'));
				$obj->s =0 ;
				break;
			case YumUserIdentity::ERROR_PASSWORD_INVALID:
				$obj->s =0 ;
				Yum::log( Yum::t(
							'Password invalid for user {username} (Ip-Address: {ip})', array(
								'{ip}' => Yii::app()->request->getUserHostAddress(),
								'{username}' => $username)), 'error');
				break;
		}
		echo json_encode($obj);
	}

	public function actionMakeReservation()
	{
		$userId= "";
		$schedId= "";
		$servType= "";
		if(isset($_REQUEST['userId'])){
			$userId = $_REQUEST['userId'] ;
		}
		if(isset($_REQUEST['itemId'])){
			$schedId = $_REQUEST['itemId'] ;
		}
		$profile = YumProfile::model()->findByAttributes(array('user_id'=>$userId));
			$subscription = Subscription::model()->findByAttributes(array('user_id'=>$userId)) ;
			$servType = Plans::getNextService($subscription);
		if($profile!=null){
			if(ReservationController::makeReservation($schedId, $userId, $servType)){
				 $obj->s=1 ;$status = "Reservation Confirmed" ;
		     $sched = ReservationController::getSchedulesForLocation($profile->company_id, $profile->location_id, $userId);
				 if(count($sched)>0){
		 				$obj->data = $sched ;
		 		}else{
				$obj->s=0 ; $obj->error = "No Schedules available for reservations.";
		 		}
			}else{
				$obj->s=0 ; $obj->error = "Unable to make Reservation. Please contact administrator.";
			}
		}else{
			$obj->s=0 ; $obj->error = "No User Profile Found. Please contact administrator.";
		}
		 echo json_encode( $obj) ;	
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
