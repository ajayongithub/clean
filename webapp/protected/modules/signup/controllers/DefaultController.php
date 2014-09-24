<?php
Yii::import(
        'application.modules.registration.controllers.YumRegistrationController');
class DefaultController extends YumRegistrationController
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionRegistration() {
    Yii::import('application.modules.profile.models.*');
    Yii::import('application.modules.users.models.*');
     $profile = new YumProfile;
     $form = new YumRegistrationForm ;
		 
		 	Yii::log('Starting action for attributes','trace');
     if (isset($_POST['YumProfile'])) { 
			 $form->attributes = $_POST['YumRegistrationForm'];
       $profile->attributes = $_POST['YumProfile'];
			 $form->validate();
			 $profile->validate();
																									 
			if(!$form->hasErrors() && !$profile->hasErrors()) {
				$user = new YumUser;
				$user->register($form->username, $form->password, $profile);
        $this->sendRegistrationEmail($user);
        Yum::setFlash('Thank you for your registration. Please check your email.');
        $this->redirect(Yum::module()->loginUrl);
				}	
      }
									  
      $this->render('registration', array(
											'form' => $form ,
	                    'profile' => $profile,
		                    )
	                );  

  }

public function sendRegistrationEmail1($user, $password) {
   if (!isset($user->profile->email)) {
     throw new CException(Yum::t('Email is not set when trying to send Registration Email'));
   }
   $activation_url = $user->getActivationUrl();
																				 
   if (is_object($content)) {
      $body = strtr('Hi, {email}, your new password is {password}. Please activate your account by clicking this link: {activation_url}', array(
     '{email}' => $user->profile->email,
     '{password}' => $password,
     '{activation_url}' => $activation_url));

     $mail = array(
          'from' => Yum::module('registration')->registrationEmail,
          'to' => $user->profile->email,
          'subject' => 'Your registration on my example Website',
          'body' => $body,
          );
      $sent = YumMailer::send($mail);
    }

    return $sent;
 }

}
