<?php

class DefaultController extends Controller
{

    public $layout = '//layouts/adminLayout';
//    public $layout = '//layouts/user';
	private function getCommand($sql){
			
		return Yii::app()->db->createCommand($sql) ;
	}
	private function getRows($command){
		$dataReader = $command->query() ;
		$rows = $dataReader->readAll();	
   	$dataReader->close();
		return $rows ;
	}
	public function actionDate(){
		$this->render('date') ;
	}	
	public function actionLoadMailer(){
		for($i = 0 ; $i < 252 ; $i++){
			echo 'Sending mail No'.$i;
			$retVal = $this->actionMailer();
			echo 'Status =  '.$retVal.'<br/>';
			ob_flush();
		}	
	}
	public function actionMailer(){
	Yii::import('ext.phpmailer.*');
		$invite_url = Yii::app()->createAbsoluteUrl('/common/invites/accept', array('inviteId'=>778855));
		$mail  = new JPhpMailer() ;
		$mail->IsSMTP();                // set mailer to use SMTP
		// setting for production setup at godaddy:::::
		$mail->Host = "relay-hosting.secureserver.net";  // specify main and backup server
		//$mail->Host = "smtpout.europe.secureserver.net";  // specify main and backup server
		//$mail->Host = "smtp.office365.com";  // developer : host testing server
		$mail->SMTPDebug = true ;     // turn on SMTP authentication
		$mail->Username = "cs@yclean.nl";  // SMTP username
		$mail->Password = "Ajay2013"; // SMTP password
		//setting for developer testing 
		//$mail->port = 587 ;
		//$mail->SMTPAuth = true ;
		//$mail->SMTPSecure = 'tls' ;

		$mail->From = "cs@yclean.nl";
		$mail->FromName = "YClean Customer Support";
		$mail->AddAddress("ajay_work@rediffmail.com" );
		$mail->AddAddress("cs@yclean.nl");                  // name is optional

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$body = strtr(
				'Hello, {username}. Please create your account with this url: {activation_url}', array(
					'{username}' => 'Whats Your Name',
					'{activation_url}' => $invite_url));
		$mail->Subject = "Invitation to join Yclean ";
		$mail->Body    = $body ; 
		$mail->AltBody = "Activate your account click ".$invite_url;
		//$mail->AddAttachment('/var/www/yclean/downloads/'.'47.pdf');
		$retVal = $mail->Send();
		if(!$retVal)
		{
			echo "could not sent mail" ;
		   Yii::log( "Message could not be sent. <p>");
//		   throw new CHttpException(999, "Mailer Error: " . $mail->ErrorInfo);
		}
		return $retVal ;	
	}
	public function actionMailerNG(){
	$to="ajay_work@rediffmail.com" ;
	$body = "dummy mail test" ;	
	$subject = "Subject comes here";
	
		$mail  = new YiiMail() ;
	$mail->transportType='smtp';
	$mail->logging='smtp';
	$mail->transportOptions = 	array(
//					'host'=>'relay-hosting.secureserver.net', 
					'host'=>'smtp.office365.com',
					//'host'=>'smtpout.secureserver.com',
					'username'=>'cs@yclean.nl',
					'password'=>'Ajay2013',
					'port'=>587,
					'encryption'=>'tls',
					);
    $message = new YiiMailMessage(); //, $contentType, $charset)
    $message->setBody($body, 'text/html');
    $message->subject = $subject ;
    $message->addTo($to);

    $message->attach(Swift_Attachment::fromPath('/var/www/yclean/downloads/47.pdf'));
    $message->setFrom(array('cs@yclean.nl' => 'Support - YClean Team'));
    $numsent = $mail->send($message);
		
		return $numsent;
	}
	public function actionIndex()
	{

	$locId = 1 ;
	 $command=$this->getCommand( 'select * from location_schedule where loc_id=:locId');
   $command->bindParam(':locId', $locId, PDO::PARAM_INT);
	 $rows=$this->getRows($command);
	 $freq = array() ;	

	 foreach($rows as $row){
		$freq[] = $row['recurrence'].$row['day'];	
	 }

	//	var_dump($freq);
		$content= '';
			$tillDate = new DateTime();
			$tillDate->add(new DateInterval('P2M'));
	  $r = new When();
		$r->recur(new DateTime(),'monthly')->byday($freq)->until($tillDate);
		while($result = $r->next()){
			$content .= $result->format('d-F-Y').'<br/>';
		} 
		$this->render('index',array('cont'=>$content));
		
	}
		public function actionDisplay(){
			$command=$this->getCommand('select distinct location_city from master_locations');
			$rows = $this->getRows($command) ;
			$cities = array();
			foreach($rows as $row){
				$cities[$row['location_city']] = $row['location_city'] ;
			}
			$dataProvider = new CActiveDataProvider('LocationSchedule') ;
			$this->render('compositePage',array('cities'=>$cities,'dataProvider'=>$dataProvider));
		}
		public function actionGetCityLocations(){
			if(isset($_POST['city'])){
				$city = $_POST['city'];
				$command=$this->getCommand('select id,location_address from master_locations where location_city=:city');
   				$command->bindParam(':city', $city, PDO::PARAM_INT);
				$rows = $this->getRows($command) ;
				Yii::log('Row count is'.count($rows));
				$locations = array();

				echo CHtml::tag('option',array('value'=>''),'Select a location',true);
				foreach($rows as $row){
					$loc = $row['location_address'] ;
					$id = $row['id'];
						echo CHtml::tag('option',array('value'=>$id),$loc,true);
						
				}
		}
		}

	public function actionGetScheduleRules(){
		$locid = $_POST['locId'];
		$dataProvider=new CActiveDataProvider('LocationSchedule', array(
    		'criteria'=>array(
    	    'condition'=>'loc_id='.$locid,
    			),
		));
		echo $this->renderPartial('_rulesView',array('dataProvider'=>$dataProvider));
	}


	public function actionGetList(){

	$locId = $_POST['locId'] ;
	 $command=$this->getCommand( 'select * from location_schedule where loc_id=:locId');
   $command->bindParam(':locId', $locId, PDO::PARAM_INT);
	 $rows=$this->getRows($command);
	 $freq = array() ;	

	 foreach($rows as $row){
		$freq[] = $row['recurrence'].$row['day'];	
	 }

	//	var_dump($freq);
		$content= '';
			$tillDate = new DateTime();
			$tillDate->add(new DateInterval('P2M'));
	  $r = new When();
		$r->recur(new DateTime(),'monthly')->byday($freq)->until($tillDate);
		while($result = $r->next()){
			echo $result->format('d-F-Y').'<br/>';
		} 
	}
	/*
	 * YumProfile[firstname]:abcd
YumProfile[initials]:abcd
YumProfile[lastname]:abcd
YumRegistrationForm[username]:abcd1
YumRegistrationForm[password]:abcd123
YumRegistrationForm[verifyPassword]:abcd123
YumProfile[email]:abcd1@123.com
YumProfile[street]:abcd 01
YumProfile[address_zipcode]:1231 df
YumProfile[city]:Amsterdam
YumProfile[telephone_work]:343424
YumProfile[country]:Netherland
YumProfile[company_id]:5
YumProfile[location_id]:8
YumRegistrationForm[verifyCode]:aoc
	*/
	public function actionCreateUsers(){
			$cl = CompanyLocation::model()->findAll();
			$plans = Plans::model()->findAll();
			for($i = 0 ; $i < 50 ; $i++){
				$profile = new YumProfile(); 
				$user = new YumUser;
				$profile->street = 'abcd 01';
				$profile->address_zipcode = '1234 AD' ;
				$profile->city = 'ABCD' ;
				$profile->telephone_work = '987654321' ;
				$profile->country = 'Netherland' ;
				$profile->company_id = $cl[$i%count($cl)]->company_id ;
				$profile->location_id = $cl[$i%count($cl)]->location_id ;
				$profile->firstname = 'abc'.$i ;
				$profile->initials = 'abc'.$i ;
				$profile->lastname = 'abc'.$i ;
				$profile->email = 'abc'.$i.'@email.com' ;
				$profile->profile_complete_status = 'Created';
				$user->register('abc'.$i, '123123', $profile);	
				$status = YumUser::activate($profile->email, $user->activationKey);
				echo "created user no ".$i.'<br/>';
				$order = new Orders() ;
				$order->order_date = date('now');
				$order->plan_id = $plans[$i%count($plans)]->id ;
				$order->status = 'Pending' ;
				$order->user_id = $user->id ;
				$order->save();
				$pd = new PaymentDetails();
				$pd->amount = $plans[$i%count($plans)]->plan_cost * 12 ;
				$pd->order_id = $order->id ;
				$pd->payment_issue_date = date('now');
				$pd->payment_type = 'Mandate' ;
				$pd->status='Pending';
				$pd->save();
				Subscription::startSubscription($order, $pd, $profile)	;

				ob_flush();
			}
	}
	public function actionStartSubscription(){
			$plans = Plans::model()->findAll();
			for($i = 0 ; $i < 50 ; $i++){
				$pid = 54 +$i ;
				$profile = YumProfile::model()->findByAttributes(array('user_id'=>$pid));
				$order = new Orders() ;
				$order->order_date = date('now');
				$order->plan_id = $plans[$i%count($plans)]->id ;
				$order->status = 'Pending' ;
				$order->user_id = $pid;
				$order->save();
				$pd = new PaymentDetails();
				$pd->amount = $plans[$i%count($plans)]->plan_cost * 12 ;
				$pd->order_id = $order->id ;
				$pd->payment_issue_date = date('now');
				$pd->payment_type = 'Mandate' ;
				$pd->status='Pending';
				$pd->save();
				Subscription::startSubscription($order, $pd, $profile)	;
				
			}
		
	}
	public function actionCreateMasterLocations(){
		$city = array('Amsterdam','Roterdam','Haarlem') ;
		for($i = 0 ; $i < 9; $i++){
			$ml = new MasterLocations ;
			$ml->location_address = $city[$i/3]." Street No ".($i);
			$ml->location_city = $city[$i/3] ;
			$ml->location_zipcode = '1234 ZC';
			$ml->save();
		}	
	}
	public function actionCreateCompanies(){
		$city = array('Amsterdam','Roterdam','Haarlem') ;
		//$ml = MasterLocations::model()->findAll();
		$companies = array('Microsoft','Adobe','Apple','HP') ;
		for($i = 0; $i < count($companies); $i++){
			$comp = new Company();
			$comp->company_name = $companies[$i] ;
			$comp->contact_firstname = 'first name for contact '.$companies[$i] ;
			$comp->contact_lastname = 'last name for contact '.$companies[$i] ;
			$comp->contact_init = 'in';
			$comp->contact_email = 'contact@'.$companies[$i].'.com';
			$comp->ho_address = 'HO '.$companies[$i].' with 00';
			$comp->ho_city = $city[$i%3];
			$comp->ho_zipcode = $i.$i.$i.$i.' AB';
			$comp->save();
			
		}
	}
	public function actionCreateCompanyLocations(){
		$companies = Company::model()->findAll();
		$masterLoc = MasterLocations::model()->findAll();
		for($i = 0 ; $i < count($companies) ; $i++){
			for($j = 0 ; $j < count($masterLoc) ; $j++){
				if($j%(2+$i)==0){
					$cl = new CompanyLocation();
					$cl->company_id = $companies[$i]->id ;
					$cl->location_id = $masterLoc[$j]->id ;
					$cl->save();
				}
			}
		}
			
	}
	public function actionCreateLocationSchedules(){
		$dte = $_GET['dte'] ;
		$cl = CompanyLocation::model()->findAll();
		$ts = TimeSlots::model()->findAll();
		for($i = 0 ; $i < count($cl) ; $i++){
			$ls = new LocationSchedule();
			$ls->company_id = $cl[$i]->company_id ;
			$ls->loc_id = $cl[$i]->location_id ;
			$ls->ts_id = $ts[$i%count($ts)]->id ;	
			$ls->sched_date = $dte ;
			$ls->save();
		}	
	}
	public function actionMakeReservations(){
		//$dte=$_GET['dte'];
		$users = YumUser::model()->findAll('id>:uid',array('uid'=>100)) ;
		for($i = 0 ; $i < count($users) ; $i++){
		//	$ls = LocationSchedule::model()->findAllByAttributes
			$profile = YumProfile::model()->findByAttributes(array('user_id'=>$users[$i]->id));
			$ls = LocationSchedule::model()->findAll('company_id=:cid and loc_id =:lid',
									array('cid'=>$profile->company_id,'lid'=>$profile->location_id));
			foreach($ls as $schedule){
				$reserve = new Reservations() ;
				$reserve->user_id = $users[$i]->id ;
				$reserve->schedule_id = $schedule->id ;
				$reserve->status = 'Reserved' ;
				$reserve->reserved_on = '2013/09/01' ;
				$reserve->service_type = Plans::getNextService(Subscription::model()->findByAttributes(array('user_id'=>$users[$i]->id))) ;
				$reserve->save();
				print_r($reserve->getErrors()) ;
			}

		} 
		echo "Reservations done" ;


	}
	public function actionCreateEmployees(){
		Yii::import('application.modules.planning.models.*') ;
		$city = array('Amsterdam','Roterdam','Haarlem') ;
		for($i = 0 ; $i < 15 ; $i++){
			$emp = new Employees ;
			$emp->emp_contract_end_date = '2014/12/31' ;
			$emp->emp_designation = 'Cleaner' ;
			$emp->emp_email = 'emp'.$i.'@yclean.nl' ;
			$emp->emp_gender = "Male" ;
			$emp->emp_init = 'IN' ;
			$emp->emp_last_name = 'Last'.$i ;
			$emp->emp_name = 'Emp'.$i ;
			$emp->emp_num = $i ;
			$emp->emp_phone_no= '123456'.$i ;
			$emp->emp_work_hr_begin= '09:00' ;
			$emp->emp_work_hr_end= '17:00' ;
			$emp->sunday = 1 ;
			$emp->monday = 1 ;
			$emp->tuesday = 1 ;
			$emp->wednesday = 1 ;
			$emp->thursday = 1 ;
			$emp->friday = 1 ;
			$emp->saturday = 1 ;
			$emp->emp_base_location = $city[$i%count($city)] ;
			$emp->emp_driving_license = 'DLNO123123' ;
			$emp->save();
			print_r( $emp->getErrors());
		}
	}

	
	public function actionSlots(){
		$tsBeginIndex = (strtotime('09:00:00') - strtotime('09:00:00'))/(60*10) ; 	
		$tsEndIndex = (strtotime('13:00:00') - strtotime('09:00:00'))/(60*10) ;
		echo $tsBeginIndex.' is the first <br/>';
		echo $tsEndIndex.' is the last <br/>';
	}
	public function actionMultiDim(){
		$arr = array(array(array())) ;
		//location, employee, time 
		for($locid = 0 ; $locid < 4 ; $locid++) {
			echo "Location id:".$locid.'<br/>';
			for($empId = 0 ; $empId < 5 ; $empId++){
				echo "employee id:".$empId.'<br/>';
				for($ts = 0 ; $ts<48 ; $ts++){
						$arr[$locid][$empId][$ts] = 'Free' ;
				}
			}
		 }
		
	}

	public function actionGetRoles(){
		echo Yii::app()->user->isAdmin();
		/*if(!Yii::app()->user->isAdmin()){
				echo "Admin Role";
			
		}
		if(!Yii::app()->user->isGuest)
			if(Yii::app()->user->hasRole('admin')){
				echo "Admin Role";
			}else{
				if(Yii::app()->user->hasRole('Demo'))
					echo "User Role";
				else 
					echo 'No Roles' ;
				
			}
		else
		echo "Guest User ";*/
	}		
	public function actionGetUserProfile(){
		
		$userName = $_REQUEST['user'];
		$userModel = YumUser::model()->findByAttributes(array('username'=>$userName));
		$profileModel = YumProfile::model()->findByAttributes(array('user_id'=>$userModel->id));
		$proRet->email = $profileModel->email;
		$proRet->name = $profileModel->firstname.' '.$profileModel->initials.' '.$profileModel->lastname ;
		$proRet->phone = $profileModel->telephone_work ;
		$retObj->s = 1 ;
		$retObj->data = $proRet ;
		echo json_encode($retObj);
		
	}
	public function actionTestEncode(){
		$invite_url = Yii::app()->createAbsoluteUrl('/common/invites/accept', array('inviteId'=>778855));
		echo "Base Url : ".$invite_url."<br/>" ;
		echo "Encoded Url : ".urlencode($invite_url)."<br/>";
		}
		
		public function printModelArray($array){
			echo "<hr/>";
			foreach($array as $ele){
				print_r($ele->attributes);
			}
		}
	public function actionListUserDetails(){
		if(isset($_REQUEST['user']))
			$userName = $_REQUEST['user'];
		else 
			return ;
		$userModel = array(); $profileModel=array();
		$userModel[] = YumUser::model()->findByAttributes(array('username'=>$userName));
		$profileModel[] = YumProfile::model()->findByAttributes(array('user_id'=>$userModel[0]->id));
		$orderModels = Orders::model()->findAllByAttributes(array('user_id'=>$userModel[0]->id));
		$paymentDetailModels = array();
		foreach($orderModels as $order){
			$payDetails = PaymentDetails::model()->findAllByAttributes(array('order_id'=>$order->id));
			$paymentDetailModels = array_merge($paymentDetailModels,$payDetails);
		}
		$subscriptionModels = Subscription::model()->findAllByAttributes(array('user_id'=>$userModel[0]->id));		
		
		echo 'User'.(count($userModel));
		$this->printModelArray($userModel);		
		echo "<hr/>";		
		echo 'Profile'.(count($profileModel));
		$this->printModelArray($profileModel);
		echo "<hr/>";
		echo 'Order'.(count($orderModels));
		$this->printModelArray($orderModels);
		echo "<hr/>";
		echo 'Payment'.(count($paymentDetailModels));
		$this->printModelArray($paymentDetailModels);
		echo "<hr/>";
		echo 'Subscription'.(count($subscriptionModels));
		$this->printModelArray($subscriptionModels);
		echo "<hr/>";
	}	
		
	public function actionGetTzInfo(){
		echo "Time zone is ";
//		echo $this->getLocalTimeZone();
		echo phpinfo();
	}
	
	public function actionGetDateSlots(){
			$subStartDate = '2013/10/14';
			$freq = 30 ;
			$sDate = new DateTime();
			$eDate = new DateTime();	
			$fDate = new DateTime();	
			$currDate = new DateTime();	
			$sDate->setDate(2013, 10, 14);
			$eDate->setDate(2014, 10, 13);
			echo "<p/>Old Date ";
			echo $sDate->format('Y-m-d H:i:s') ;
			echo "<p/>Current Date ";
			echo $currDate->format('Y-m-d H:i:s') ;
			
			while($sDate < $eDate){
				$fDate->setTimestamp($sDate->getTimestamp()) ;
				$sDate = $sDate->add(new DateInterval('P2M'));
				echo "<p/>From: ";
				echo $fDate->format('Y-m-d H:i:s') ;
				echo "To:";
				echo $sDate->format('Y-m-d H:i:s') ;
					
				if($currDate >= $fDate && $currDate < $sDate){	
						echo "<p>Interval found";
						return ;
					}
				}	
								
	}
	public function actionTestFetch(){
		$userId = $_REQUEST['userId'] ;
		Yii::import('application.modules.reservation.controllers.*');
		$maxDate = ReservationController::getMaxDate($userId);
		echo '<p> Max Date :'.$maxDate ;
		$startDate = ReservationController::getStartingDate($maxDate, 1, '2013-10-1', '2014-9-30');
		echo '<p> Start Date is :'.$startDate ;
		$result = ReservationController::getRulesBasedSchedules(18, 58, 165);
		var_dump($result);
		
	}
	
	public function actionTestQuery(){
		$companyId = 18 ;
		$locId = 58 ;
		$startDate = '2014/04/01';
//		$startDate = new DateTime();
//		$varSql = ' select ls.id, ls.sched_date, ts.slot_name,ts.slot_begin,ts.slot_end from location_schedule ls, time_slots ts where ls.ts_id = ts.id and ls.loc_id='.$locId.' and ls.company_id='.$companyId.' and  ls.sched_date > \''.$startDate.'\' order by ls.sched_date ASC' ;

		$cmd= Yii::app()->db->createCommand()
		->select(' ls.id, ls.sched_date,ts.slot_name, ts.slot_begin,ts.slot_end  ')
		->from(' location_schedule ls, time_slots ts ')   
		->where(' ls.ts_id = ts.id and ls.loc_id=:locId and ls.company_id=:companyId and ls.sched_date > :startDate ',array('locId'=>$locId,'companyId'=>$companyId,'startDate'=>$startDate)  )
		->order( ' ls.sched_date ASC ');
		var_dump($cmd);
		$locSchedules = $cmd->queryAll(); 
//		echo $varSql ;

//		$locSchedules = Yii::app()->db->createCommand($varSql)->queryAll();
		var_dump($locSchedules);
	
	}
	
}
