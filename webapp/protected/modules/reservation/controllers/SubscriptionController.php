<?php
Yii::import('application.modules.membership.controllers.*');
class SubscriptionController extends YumMembershipController
{
	private  $CRED_NAME = 'YClean BV' ;
	private  $CRED_ADDRESS = 'YClean Address ' ;
	private  $CRED_POSTAL_CODE = '0000 XX' ;
	private  $CRED_CITY = 'AMSTERDAM' ;
	private  $CRED_COUNTRY = 'HOLLAND' ;
	private  $CRED_ID = 'CREDIT_ID ' ;
	private  $CRED_MANDATE_REF = 'YCLEANNL' ;

	private  $CELL_CRED_NAME = 'E6' ;
	private  $CELL_CRED_ADDRESS = 'E8' ;
	private  $CELL_CRED_POSTAL_CODE = 'E10' ;
	private  $CELL_CRED_CITY = 'H10' ;
	private  $CELL_CRED_COUNTRY = 'E12' ;
	private  $CELL_CRED_ID = 'H9' ;
	private  $CELL_CRED_MANDATE_REF = 'H9' ;

	private  $CELL_DEB_NAME = 'G18';
	private  $CELL_DEB_ADDRESS = 'G19';
	private  $CELL_DEB_POSTAL_CODE = 'G20';
	private  $CELL_DEB_CITY = 'K20';
	private  $CELL_DEB_COUNTRY = 'G21';
	private  $CELL_DEB_BIC = 'G23';
	private  $CELL_DEB_IBAN = 'G22';
	public  $VAT = 21 ;
	
	const NO_SUBSCRIPTION = 0 ;	
	const SUBS_ACTIVE = 1 ;	
	const SUBS_EXPIRED = 2 ;	
	const ERROR_SUBS = -1 ;	
	const OTHER = 100 ;	
	
	public $layout = '//layouts/userLayout';
	public function filters() {
		return array(
			'accessControl', 
		);
	}

	public function accessRules() {
		return array(
		array('allow',
				'actions'=>array('index','subscribe','ideal','mandate'),
				'users'=>array('@'),
		),
		array('allow',
				'actions'=>array('admin','delete','searchMandate','acceptMandate'),
				'users'=>array('admin'),
		),
		//array('deny',
		//	'users'=>array('*'),
		//	),
		);
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionOrder(){
//this code is duplicate for ycleanapp as well so any changes here shall have to be reflected 
// in the yclean app as well, till refactoring is done.
		$subscription = Subscription::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if($subscription!=null){
			$activeStatus = self::OTHER;
			$expiry = $subscription->expiry_date ;
			$start = $subscription->start_date ;
			
			if(strtotime('now')>strtotime($expiry)) 
				$activeStatus= self::SUBS_EXPIRED ;	
			else if(strtotime('now')>strtotime($start)) 
				$activeStatus= self::SUBS_ACTIVE ;	
			else 
				$activeStatus  = self::ERROR_SUBS ;
		}else 
			$activeStatus  = self::NO_SUBSCRIPTION ;

		switch($activeStatus){
			case self::NO_SUBSCRIPTION: {
										$order = Orders::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
										if($order==null){
											$model = Plans::model()->findAll();
											Yum::setFlash(Yii::t('subscription','You are currently not subscribed'));
											$this->render('order',array( 'model'=>$model));
										}else {
											$paymentDetail	= PaymentDetails::model()->findByAttributes(array('order_id'=>$order->id));
											if($paymentDetail==null){
												$order->delete();
												Yum::setFlash(Yii::t('subscription','Your previous order could not be completed, please chose a plan again'));  
												$model = Plans::model()->findAll();
												$this->render('order',array( 'model'=>$model));
											}else{
												$plan = Plans::model()->findByAttributes(array('id'=>$order->plan_id));
												if(strcmp($paymentDetail->payment_type,'Mandate')==0){
													Yum::setFlash(Yii::t('subscription','Your previous order has not be completed, please contact our customer care'));  
													$this->render('incomplete',array('plan'=>$plan,'order'=>$order,'payment'=>$paymentDetail)) ;
												}else	{
												$order->delete();
												Yum::setFlash(Yii::t('subscription','Your previous order could not be completed, please chose a plan again'));  
												$model = Plans::model()->findAll();
												$this->render('order',array( 'model'=>$model));
												}
											}
										}
										break;
										}
			case self::SUBS_ACTIVE: {
										$model = Plans::model()->findByAttributes(array('id'=>$subscription->plan_id));
										Yum::setFlash(Yii::t('subscription','Your current subscription details are'));
										$this->render('index',array( 'plan'=>$model,'subscription'=>$subscription));
										break;
										}
			case self::SUBS_EXPIRED: {
										$model = Plans::model()->findAll();
										Yum::setFlash(Yii::t('subscription','Your subscription has expired'));
										$this->render('order',array( 'model'=>$model));
										break;
										}
		}
	}
	
	public static function isActiveSubscriber($userId){
		$count = Yii::app()->db->createCommand()
		 ->select(' count(*) as cnt ')
		 ->from(' subscription ')
		 ->where(' user_id ='.$userId.' AND start_date <= CURRENT_DATE( ) AND '
		 								  .'expiry_date > CURRENT_DATE( )')
		 ->queryAll();		
		if($count[0]['cnt']>0) return true;
		return false ;
	}
	
	public function actionSubscribe(){
		if(isset($_POST['Plan'])) {
			$postData = $_POST['Plan'];
			$plan_id = $postData['id'] ;
			$order = new Orders ;
			$order->user_id = Yii::app()->user->id ;
			$now = new DateTime('now') ;
			$order->order_date = $now->format('Y-m-d H:i') ;
			$order->plan_id  = $plan_id ;
			$order->status = 'new';
			$planModel = Plans::model()->findByPk($plan_id);
			if($order->save())
			$this->render('makePayment',array('order'=>$order,'plan'=>$planModel));
			else throw CHttpException(911,Yii::t('subscription','Unable to process order'));
		}
		else throw CHttpException(910,Yii::t('subscription','Incorrect Action Called'));
	}
	public function actionIdeal(){

		if(isset($_POST['orderId'])){
			$id = $_POST['orderId'] ;
			$order = Orders::model()->findByPk($id);
			$planSel = Plans::model()->findByPk($order->plan_id);
			$payment = $this->updatePaymentDetails(null, $planSel->plan_cost*11, $id, 'iDeal', 'Pending');
			//echo "Order no ".$order->id." for user id ".$order->user_id." to be marked as success " ;
			$profile = YumProfile::model()->findByAttributes(array('user_id'=>$order->user_id)) ;
			$profile->profile_complete_status = 'Paying via iDeal';
			$profile->save();
			$this->render('initiateIdeal',array('payment'=>$payment,'order'=>$order,'plan'=>$planSel,'profile'=>$profile));
/*			if($this->sendActivatedMail($profile, Yii::app()->user))
			$this->redirect('/reservation/reservation/index') ;
			else
			echo "Could not send activation mail" ;*/
		}
			
	}
	/*private function startSubscription($order,$payment,$profile){
		$plan = Plans::model()->findByPk($order->plan_id) ;
		$subscribe = new Subscription() ;
		$subscribe->amount = $payment->amount;
		$nowDate = date('Y-m-d') ;
		$expiryDate = strtotime('+12 months');
		
		$subscribe->expiry_date = date('Y-m-d',$expiryDate) ;
		$subscribe->plan_id = $order->plan_id ;
		$subscribe->start_date = $nowDate ;
		$subscribe->user_id = $profile->user_id ;
		$subscribe->service_number = 0 ;
		$subscribe->save();
		$profile->profile_complete_status="Subscribed";
		$profile->save();
		$body = "Your subscription has been started. Welcome to YClean." ;
		$subject = "Active Account." ;
		YMailerController::sendMail($profile->email, 'cs@yclean.nl', $subject, $body, null,null);
	}
*/
	public function actionIdealResponse($status,$order,$txid,$user){
		if(Yii::app()->user->id != $user) throw new CHttpException(302,Yii::t('subscription','Not authorised to view this page'));
		$paymentDetail = PaymentDetails::model()->findByPk($txid) ;
		if(strcmp($paymentDetail->payment_type,'iDeal')!=0) throw new CHttpException(998,Yii::t('subscription','Invalid Transaction Response'));
		if(strcmp($paymentDetail->status,'Completed')==0) throw new CHttpException(998,Yii::t('subscription','Invalid Transaction Response'));
		$orderRow = Orders::model()->findByPk($order);
		if(strcmp($orderRow->status,'Completed')==0) throw new CHttpException(998,Yii::t('subscription','Invalid Transaction Response'));
		Yii::log("Stage 4 cleared");
		$profile = YumProfile::model()->findByAttributes(array('user_id' => $user));
		
			$paymentDetail->status = $status ;
			$paymentDetail->save();
		if(strcmp($status,'success')==0){
			$orderRow->status  = 'Completed' ;
			$orderRow->save();
			Subscription::startSubscription($orderRow,$paymentDetail,$profile);
		}else if(strcmp($status,'cancelled')==0){
			$orderRow->status  = 'cancelled' ;
			$orderRow->save();
		}else if(strcmp($status,'exception')==0){
			$orderRow->status  = 'exception' ;
			$orderRow->save();
		}else if(strcmp($status,'declined')==0){
			$orderRow->status  = 'declined' ;
			$orderRow->save();
		}else{
			$orderRow->status  = 'Other Reason' ;
			$orderRow->save();
		}
		$this->render('idealResponse',array('status'=>$status,'order'=>$order));
		
	}
	public function updatePaymentDetails($id,$amount,$order_id,$type,$status){
		if($id==NULL){
			$payment = new PaymentDetails ;
			$payment->amount = number_format($amount,2) ;
			$payment->order_id = $order_id;
			$now = new DateTime('now') ;
			$payment->payment_issue_date =  $now->format('Y-m-d') ;
			$payment->payment_type = $type;
			$payment->status = $status;
			if( $payment->save()){
				$formatPid = sprintf('%06d', $payment->id);
				$payment->payment_id = $this->CRED_MANDATE_REF.$formatPid ;
				if($payment->save())
					return $payment;
			}
		}
		return null ;
	}

	public static function getMandateFilePath($id){
		
	}
	
	private function createMandate($payment,$order,$plan,$profile){
		ini_set('memory_limit','1024M');//added on the fly
		$dirPath = dirname(__FILE__).'/../views/subscription/';
		$fileName = $dirPath.'MandateTemplate.xls';

		$inputFileType = PHPExcel_IOFactory::identify($fileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($fileName);

		//  Change these values to select the Rendering library that you wish to use
		//    and its directory location on your server
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		//$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
		//$rendererLibrary = 'tcPDF5.9';
		$rendererLibrary = 'mPDF';
		//$rendererLibrary = 'domPDF0.6.0beta3';
		$rendererLibraryPath = dirname(__FILE__).'/../../../vendors/MPDF56/';

		//echo $rendererLibraryPath ;
		//echo Yii::getPathOfAlias('application')  ;
		//echo $rendererName;
		// Change the file
		$objPHPExcel->setActiveSheetIndex(0)
//		->setCellValue($this->CELL_CRED_NAME, $this->CRED_NAME)
//		->setCellValue($this->CELL_CRED_ADDRESS,$this->CRED_ADDRESS)
//		->setCellValue($this->CELL_CRED_POSTAL_CODE,$this->CRED_POSTAL_CODE)
//		->setCellValue($this->CELL_CRED_CITY,$this->CRED_CITY)
//		->setCellValue($this->CELL_CRED_COUNTRY,$this->CRED_COUNTRY)
//		->setCellValue($this->CELL_CRED_ID,$this->CRED_ID)
		->setCellValue($this->CELL_CRED_MANDATE_REF,$payment->payment_id)
		->setCellValue($this->CELL_DEB_NAME, $profile->firstname.' '.$profile->initials.' '.$profile->lastname)
		->setCellValue($this->CELL_DEB_ADDRESS,$profile->street)
		->setCellValue($this->CELL_DEB_POSTAL_CODE,$profile->address_zipcode)
		->setCellValue($this->CELL_DEB_CITY,$profile->city)
		->setCellValue($this->CELL_DEB_COUNTRY,$profile->country)
		->setCellValue($this->CELL_DEB_BIC,$profile->bank_name)
		->setCellValue($this->CELL_DEB_IBAN,$profile->bank_account);

$objDrawingPType = new PHPExcel_Worksheet_Drawing();
$objDrawingPType->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
$objDrawingPType->setName("YClean");
//$objDrawingPType->setPath(Yii::app()->basePath.DIRECTORY_SEPARATOR."../images/main-logo.png");
//$objDrawingPType->setPath($basePath1.DIRECTORY_SEPARATOR."/images/main-logo.png");
//$objDrawingPType->setPath($basePath1.DIRECTORY_SEPARATOR."/images/textures/grey4.jpg");
//$objDrawingPType->setPath(dirname(__FILE__).'/../../../../images/main-logo.png');
//$objDrawingPType->set
$objDrawingPType->setPath("images/main-logo.png");
$objDrawingPType->setCoordinates('C5');
$objDrawingPType->setOffsetX(3);
$objDrawingPType->setOffsetY(7);

		$objPHPExcel->getActiveSheet()->setShowGridLines(false);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		if (!PHPExcel_Settings::setPdfRenderer(
		$rendererName,
		$rendererLibraryPath
		)) {
			die(
    'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
    '<br />' .
    'at the top of this script as appropriate for your directory structure'
    );
		}
		$basePath = Yii::getPathOfAlias('webroot');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//		$objWriter = PHPExcel_Writer_PDF_mPDF::createWriter($objPHPExcel,'PDF') ;
//		$objWriter.setEmbedImages(true);
//		$objWriter.setImagesRoot("/var/www/yclean/images/export");
		//$objWriter->save('php://output');
		$objWriter->save($basePath.'/downloads/'.$profile->user_id.'.pdf');
		$var1=  Yii::app()->createAbsoluteUrl('downloads/'.$profile->user_id.'.pdf');
		Yii::import('application.modules.common.controllers.YMailerController');
/* 		$var1 = YMailerController::sendMail($profile->email, 'cs@yclean.nl', 
						'Mandate File for your subscription at YClean',
						'Please find Attached your mandate on sign up of YClean Service',
						$basePath.'/downloads/', $profile->user_id.'.pdf'); 
 */	
		$var1 = YMailerController::sendMandateMail($profile,$basePath.'/downloads/', $profile->user_id.'.pdf');
		return $var1;



	}

	public function actionMandate(){
		if(isset($_POST['orderId'])){
			$id = $_POST['orderId'] ;
			$order = Orders::model()->findByPk($id);
			//echo "Order no ".$order->id." for user id ".$order->user_id." to be marked as success " ;
			$profile = YumProfile::model()->findByAttributes(array('user_id'=>$order->user_id)) ;
			$profile->profile_complete_status = 'Mandate Generated';
			$bankName = $_POST['bank_name'];
			$profile->bank_name = $bankName;
			$bankAccount = $_POST['bank_account'];
			$profile->bank_account = $bankAccount;
			$profile->save();
			//echo 'profile updated' ;
			$planSel = Plans::model()->findByPk($order->plan_id);
			$payment = 	$this->updatePaymentDetails(null, $planSel->plan_cost, $id, 'Mandate', 'Pending');
			//echo 'Creating Mandate' ;
			if($payment!=null){
				$paymentDest = $this->createMandate($payment,$order,$planSel,$profile) ;
				//$this->render('mandatePrint',array('order'=>$order,'plan'=>$plan,'profile'=>$profile,'dest'=>$paymentDest))	;
				$this->render('mandatePrint');
			}else throw CHttpException(500,'Unable to process your request, please try again') ;
		}
			
	}
	private function sendActivatedMail($profile,$user){
		Yii::import('ext.phpmailer.*');
		$mail  = new JPhpMailer() ;
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "relay-hosting.secureserver.net";  // specify main and backup server
		$mail->Username = "cs@yclean.nl";  // SMTP username
		$mail->Password = "Ajay2013"; // SMTP password

		$mail->From = "cs@yclean.nl";
		$mail->FromName = "YClean Customer Support";
		$mail->AddAddress("$profile->email" );
		$mail->AddAddress("ajay.aneja@spectrumin.co.in");                  // name is optional
		//		$mail->AddReplyTo("info@example.com", "Information");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		//		$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
		//		$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
		$mail->IsHTML(true);                                  // set email format to HTML

		$body = strtr(
				'Hello, {username}. Your account with YClean is now fully active. ', array(
					'{username}' => $profile->firstname,
		));
		$mail->Subject = "Active Account at Yclean ";
		$mail->Body    = $body ;
		$mail->AltBody = "Your account is now active ";
		$sent = $mail->Send();

		if(!$sent)
		{
			Yii::log( "Message could not be sent. <p>");
			Yii::log( "Mailer Error: " . $mail->ErrorInfo);
		}


		return $sent;
	}
	// Uncomment the following methods and override them if needed
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
