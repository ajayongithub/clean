<?php

class RedirectController extends Controller
{
	public function actionIndex()
	{
			if( Yii::app()->user->isAdmin()){
				$this->redirect(Yii::app()->createUrl('/admin/admin')) ;	
			}
			if(Yii::app()->user->isGuest)
				$this->redirect(Yii::app()->createUrl('/')) ;
			$this->redirect(Yii::app()->createUrl('/reservation/reservation'));
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