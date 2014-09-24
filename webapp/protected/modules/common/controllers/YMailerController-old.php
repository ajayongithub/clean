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
}
?>