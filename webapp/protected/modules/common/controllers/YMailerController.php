<?php

class YMailerController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public static function sendMail($to,$from,$subject,$body,$attachmentPath,$attachment){
	/*	Yii::import('ext.phpmailer.*');
		$mail  = new JPhpMailer() ;
		$mail->IsSMTP();                // set mailer to use SMTP
		// setting for production setup at godaddy:::::
		$mail->Host = "relay-hosting.secureserver.net";  // specify main and backup server
		//$mail->Host = "smtp.office365.com";  // developer : host testing server
		$mail->SMTPDebug = false ;     // turn on SMTP authentication
		$mail->Username = "cs@yclean.nl";  // SMTP username
		$mail->Password = "Ajay2013"; // SMTP password
		//setting for developer testing 
		//$mail->port = 587 ;
		//$mail->SMTPAuth = true ;
		//$mail->SMTPSecure = 'tls' ;

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
		}*/
  Yii::log("Starting mail send");
     $email = new Postmark();
     Yii::log("Created email");
     Yii::log("Set debug flags");
     $email->addTo($to,'')
           ->addTo('cs@yclean.nl','YClean')

					 ->subject($subject);
//					 ->messagePlain($body);
			if($attachment!=null)
		      $email->addAttachment($attachmentPath.'/'.$attachment) ;
		  $email->messageHtml($body);
		  $email->send();
		 Yii::log("Sent email");
		
		
		return true ;
}

	public static function sendActivationMail($profile,$order,$payment){
		Yii::log("Rendering mail");
		Yii::log( "order ". $order->id);
		Yii::log( "plan ". Plans::getPlanName($order->plan_id));
		Yii::log( "payment ". $payment->payment_type);
		Yii::log( "amount ".$payment->amount);
 $bdy = Yii::app()->controller->renderPartial('start_sub',array('profile'=>$profile,
  												'order'=>$order->id,
  												'plan'=>Plans::getPlanName($order->plan_id),
  												'payment'=>$payment->payment_type,
  												'amount'=>$payment->amount),true,false);
  $subject = "Account Activation at YClean";
		YMailerController::sendMail($profile->email, 'cs@yclean.nl', $subject, $bdy, null,null);
	}

	
	public static function sendMandateMail($profile,$attachmentPath,$attachment){
		$bdy = Yii::app()->controller->renderPartial('mandate_email',array('profile'=>$profile,),true,false);
		$subject = "Mandate file for Yclean signup";
		return YMailerController::sendMail($profile->email, 'cs@yclean.nl', $subject, $bdy, $attachmentPath,$attachment);
	}
	public static function sendPasswordMail($to,$recoveryUrl){
		$bdy = Yii::app()->controller->renderPartial('password_email',array('url'=>$recoveryUrl,),true,false);
		$subject = "Password recovery for Yclean signup";
		return YMailerController::sendMail($to, 'cs@yclean.nl', $subject, $bdy, null,null);
	}

	
}


?>
