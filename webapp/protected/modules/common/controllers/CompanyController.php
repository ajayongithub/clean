<?php

class CompanyController extends GxController {

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
				'actions'=>array('admin','create','delete','view','update'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->layout = "//layouts/adminLayout" ;

		$this->render('view', array(
			'model' => $this->loadModel($id, 'Company'),
		));
	}

	public function actionCreate() {
		$model = new Company;


		if (isset($_POST['Company'])) {
			$model->setAttributes($_POST['Company']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$this->layout = "//layouts/adminLayout" ;
		$model = $this->loadModel($id, 'Company');


		if (isset($_POST['Company'])) {
			$model->setAttributes($_POST['Company']);

			if ($model->save()) {
				$this->redirect(array('admin', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			try{			
			$this->loadModel($id, 'Company')->delete();
			}catch(Exception $ex){
				throw new CHttpException(500,Yii::t('app','Company Data is present, cannot delete.'));
			}

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Company');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->layout = "//layouts/adminLayout" ;
		$model = new Company('search');
		$model->unsetAttributes();
		$model->dbCriteria->order='ho_city, company_name ASC';
		if (isset($_GET['Company']))
			$model->setAttributes($_GET['Company']);

		$this->render('myAdmin', array(
			'model' => $model,
		));
	}

}