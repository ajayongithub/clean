<?php

class RelatedController extends Controller
{
	//public $layout="//layouts/adminLayout" ;
	public function actionAdmin()
	{
		Yii::import('application.modules.testMod.models.*') ;
		 $model=new PaymentDetails('search');
    	$model->unsetAttributes();
    if(isset($_GET['Profile']))
        $model->attributes=$_GET['Profile'];
		$this->render('admin',array('model'=>$model));
	}
	
	
	
	public function actionJquery(){
		$this->render('jquery') ;
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