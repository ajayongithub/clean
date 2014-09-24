<?php

class FeedbackController extends Controller
{
	public $layout = "//layouts/userLayout" ;
	public function actionIndex()
	{
		$msg= null ;
		if (isset($_POST['Feedback'])) {
			$params = $_POST['Feedback'] ;
			$type = $params['fbType'] ;
			$msg = $params['fbMessage'] ;	
			Yii::import('application.modules.common.controllers.YMailerController') ;
			$profile = YumProfile::model()->find('user_id=:userId',array('userId'=>Yii::app()->user->id));
			$retVal = YMailerController::sendMail('cs@yclean.nl', $profile->email, 'Feedback: '.$type.' from '.$profile->firstname.' '.$profile->lastname, $msg, NULL, NULL);
			if($retVal){
				Yum::setFlash(Yii::t('feedback',"Your feedback has been posted. Thank you for sharing your experience."));	
				$this->redirect(array('/reservation/reservation/index'));
			}	
		}
		$this->render('index');
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