<?php

class AdminController extends Controller
{
	public $layout = '//layouts/adminLayout' ;
	public function actionIndex()
	{
		Yii::import('application.modules.signup.controllers.RegistrationController') ;
		$users = RegistrationController::getLatestUsers();
		$userCount = RegistrationController::getTotalUsers();

		$payments = PaymentDetails::getLatestPayments();
		$reservCount = Reservations::getNextReservationsCount() ;
		$schedCount = LocationSchedule::getNextSchedules();
		$compCount = Company::getUsersForCompanies() ;
		$cityCount = MasterLocations::getCityUserCount();
		
		$this->render('index',array('users'=>$users, 'userCount'=>$userCount,
							'payments'=>$payments,'reserves'=>$reservCount,
							'schedules'=>$schedCount ,'companies'=>$compCount,
							'cityUsers'=>$cityCount));
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