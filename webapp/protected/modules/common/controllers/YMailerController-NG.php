<?php

class YMailerController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public static function sendMail($to,$from,$subject,$body,$attachmentPath,$attachment){
		Yii::import('ext.phpmailer.*');
		$mail  = new JPhpMailer() ;
		$mail->IsSMTP();                // set mailer to use SMTP
		// setting for production setup at godaddy:::::
		//$mail->Host = "relay-hosting.secureserver.net";  // specify main and backup server
		$mail->Host = "smtp.office365.com";  // developer : host testing server
		$mail->SMTPDebug = false ;     // turn on SMTP authentication
		$mail->Username = "cs@yclean.nl";  // SMTP username
		$mail->Password = "Ajay2013"; // SMTP password
		//setting for developer testing 
		$mail->port = 587 ;
		$mail->SMTPAuth = true ;
		$mail->SMTPSecure = 'tls' ;

		$mail->From = "cs@yclean.nl";
		$mail->FromName = "YClean Customer Support";
		$mail->AddAddress($to );
		$mail->AddAddress("cs@yclean.nl");                  // name is optional

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $body ; 
		if($attachment!=null)
			$mail->AddAttachment($attachmentPath.'/'.$attachment);
		if(!$mail->Send())
		{
		   Yii::log( "Message could not be sent. <p>");
			return false ;
		}
			return true ;
	}

	public function sendMailNG($from,$to,$subject,$body,$attachmentPath){

	$mail  = new YiiMail() ;
	$mail->transportType='smtp';
	$mail->transportOptions = 	array(
					'host'=>'relay-hosting.secureserver.net', 
					'username'=>'cs@yclean.nl',
					'password'=>'Ajay2013',
					);
    $message = new YiiMailMessage(); //, $contentType, $charset)
    $message->setBody($body, 'text/html');
    $message->subject = $subject ;
    $message->addTo($to);
    $message->setFrom(array('cs@yclean.nl' => 'Support - YClean Team'));
    if(isset($attachmentPath)) $message->
    $numsent = $mailer->send($message);


		$mail->From = "cs@yclean.nl";
		$mail->FromName = "YClean Customer Support";
		$mail->AddAddress("$model->email" );
		$mail->AddAddress("ajay.aneja@spectrumin.co.in");                  // name is optional

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$body = strtr(
				'Hello, {username}. Please create your account with this url: {activation_url}', array(
					'{username}' => $model->username,
					'{activation_url}' => $invite_url));
		$mail->Subject = "Invitation to join Yclean ";
		$mail->Body    = $body ; 
		$mail->AltBody = "Activate your account click ".$invite_url;

		if(!$mail->Send())
		{
		   Yii::log( "Message could not be sent. <p>");
//		   throw new CHttpException(999, "Mailer Error: " . $mail->ErrorInfo);
		}
	
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