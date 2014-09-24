<?php
Yii::import(
        'application.modules.registration.controllers.YumRegistrationController'); 

class RegistrationController extends YumRegistrationController 
{
	public $layout = '//layouts/main';
public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('registerForCompany','checkEmail','checkUsername','index'),
				'users'=>array('?'),
				),
			array('allow', 
				'actions'=>array('admin','create','delete','view'),
				'users'=>array('admin'),
				),
//			array('deny', 
//				'users'=>array('*'),
//				),
			);
}

	public function actionCheckEmail(){
		if(!isset($_POST['YumProfile'])){
			echo false ;
		}else{
			$param = $_POST['YumProfile'] ;
			$email = $param['email'] ;
			$count = Yii::app()->db->createCommand()
					->select(' count(*) as t ')
					->from(' profile ')
					->where(' email = "'.$email.'"')->queryAll() ;
			if($count[0]['t'] == 0)   echo 'true';
			else echo 'false' ; 
			
		}
	}
public function actionCheckUsername(){
		if(!isset($_POST['YumRegistrationForm'])){
			echo false ;
		}else{
			$param = $_POST['YumRegistrationForm'] ;
			$username = $param['username'] ;
			$count = Yii::app()->db->createCommand()
					->select(' count(*) as t ')
					->from(' user ')
					->where(' username = "'.$username.'"')->queryAll() ;
			if($count[0]['t'] == 0)   echo 'true';
			else echo 'false' ; 
			
		}
	}
	
	public static function getLatestUsers(){
		 $users = Yii::app()->db->createCommand()
		 ->select(' u.username, p.email ')
		 ->where(' u.id = p.user_id ')
		 ->from(' user u, profile p ')
		 ->order(' u.id DESC ')
		 ->limit(5)
		 ->queryAll();	
		return $users ; 
	}	
	public static function getTotalUsers(){
		 $count = Yii::app()->db->createCommand()
		 ->select(' count(*) as numbers ')
		 ->from(' user u ')
		 ->queryAll();	
		return $count[0]['numbers'] ; 
	}	

	

	public function actionIndex(){
		
		 Yii::import('application.modules.profile.models.*');
		 Yii::import('application.modules.users.models.*');
		 $profile = new YumProfile;
		 $form = new YumRegistrationForm ;
		 	
		 if (isset($_POST['YumProfile'])) {
		 	$form->attributes = $_POST['YumRegistrationForm'];
		 	$profile->attributes = $_POST['YumProfile'];
		 	$form->validate();
		 	$profile->validate();
	
			if(!$form->hasErrors() && !$profile->hasErrors()) {
				$user = new YumUser;
				$user->register($form->username, $form->password, $profile);
		
			$status = YumUser::activate($profile->email, $user->activationKey);
			//this should take the user automatically to the user login page, as configured
			// below is just a fall back mechanism
			if($status instanceOf YumUser){
				 $this->redirect(Yii::app()->createUrl('/user/auth/login'));
			}
			else throw new Exception('Error Registering User.', 900) ;
			}
		 }

		 $this->render('registration', array(
							'form' => $form ,
		                    'profile' => $profile,
		 					'companies' => null,
		 					'locations' => null,
		 )
		 );
	}
	/*
	 * This function is called when the user clicks on the invite url and 
	 * is redirected to this action for registration as we know the company
	 * Also the company id is available in the parameter,
	 */
	public function actionRegisterForCompany($companyId){
		
		 Yii::import('application.modules.profile.models.*');
		 Yii::import('application.modules.users.models.*');
		 $profile = new YumProfile;
		 $form = new YumRegistrationForm ;
		 	
		 if (isset($_POST['YumProfile'])) {
		 	$form->attributes = $_POST['YumRegistrationForm'];
		 	$profile->attributes = $_POST['YumProfile'];
		 	$form->validate();
		 	$profile->validate();
	
			if(!$form->hasErrors() && !$profile->hasErrors()) {
				$user = new YumUser;
				$user->register($form->username, $form->password, $profile);
		
			$status = YumUser::activate($profile->email, $user->activationKey);
			//this should take the user automatically to the user login page, as configured
			// below is just a fall back mechanism
			if($status instanceOf YumUser){
				 $this->redirect(Yii::app()->createUrl('/user/auth/login'));
			}
			else throw new Exception('Error Registering User.', 900) ;
			}
		 }
		 $companyList = Company::getCompanyList($companyId);
		 $locationList = CompanyLocation::getLocationsForComapny($companyId);

		 $this->render('registration', array(
							'form' => $form ,
		                    'profile' => $profile,
		 					'companies' => $companyList,
		 					'locations' => $locationList,
		 )
		 );
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