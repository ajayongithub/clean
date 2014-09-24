<?php

class CompanyLocationController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view'),
				'roles'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','create','delete','update','checkUnique'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'CompanyLocation'),
		));
	}

	public function actionCreate() {
		$model = new CompanyLocation;


		if (isset($_POST['CompanyLocation'])) {
			$model->setAttributes($_POST['CompanyLocation']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin', array('id' => $model->id)));
			}else
				throw new CHttpException(400, Yii::t('app', 'Unable to process.'));
		}

	}

	public function actionUpdate($id) {
		$this->layout ='//layouts/adminLayout';
		$model = $this->loadModel($id, 'CompanyLocation');


		if (isset($_POST['CompanyLocation'])) {
			$model->setAttributes($_POST['CompanyLocation']);

			if ($model->save()) {
				$this->redirect(array('admin', array('id' => $model->id)));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}
	private function getUserCount($companyId,$locId){
		$result = Yii::app()->db->createCommand()
		->select(' count(*) as count ')
		->from(' profile ')
		->where(' location_id = '.$locId.' and company_id = '.$companyId)
		->queryAll();
		return $result[0]['count'] ;
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model=$this->loadModel($id, 'CompanyLocation');
			if($this->getUserCount($model->company_id,$model->location_id)==0) 
					$model->delete();
			else 
				throw new CHttpException(500,Yii::t('app','Users for this Company Location exist, cannot delete')) ;

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('CompanyLocation');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->layout ='//layouts/adminLayout';
		$model = new CompanyLocation('search');
		$model->unsetAttributes();
		//$model->dbCriteria->order='company_id,location_id ASC';
		if (isset($_GET['CompanyLocation']))
			$model->setAttributes($_GET['CompanyLocation']);
		Yii::log("Set in model, rendering");
		$this->render('myAdmin', array(
			'model' => $model,
		));
	}
	public function actionCheckUnique(){
	if(!isset($_POST['CompanyLocation'])){
			echo false ;
		}else{
			$param = $_POST['CompanyLocation'] ;
			$company_id = $param['company_id'] ;
			$location_id = $param['location_id'] ;
			$count = Yii::app()->db->createCommand()
					->select(' count(*) as t ')
					->from(' company_location ')
					->where(' company_id = '.$company_id.' and location_id = '.$location_id)->queryAll() ;
			if($count[0]['t'] == 0)   echo 'true';
			else echo 'false' ; 
			
		}
	}

}