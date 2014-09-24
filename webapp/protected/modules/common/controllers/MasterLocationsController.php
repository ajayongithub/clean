<?php

class MasterLocationsController extends GxController {

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
				'actions'=>array('admin','create','delete','update'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'MasterLocations'),
		));
	}

	public function actionCreate() {
		$model = new MasterLocations;


		if (isset($_POST['MasterLocations'])) {
			$model->setAttributes($_POST['MasterLocations']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin', 'id' => $model->id));
			}
		}

		//$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$this->layout = '//layouts/adminLayout';
		$model = $this->loadModel($id, 'MasterLocations');

		if (isset($_POST['MasterLocations'])) {
			$model->setAttributes($_POST['MasterLocations']);

			if ($model->save()) {
				$this->redirect(array('admin', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
//		if (Yii::app()->getRequest()->getIsPostRequest()) {
			try {
				$this->loadModel($id, 'MasterLocations')->delete();
			} catch (Exception $e) {
				Yii::log("Exception got in ML del") ;
				//echo "Invalid Request dependent data present" ;
				throw new CHttpException(500, Yii::t('app', 'Dependent Data is present, cannot delete.'));
			}

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
//		} else
//			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('MasterLocations');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->layout = '//layouts/adminLayout';
		$model = new MasterLocations('search');
		$model->unsetAttributes();
		$model->dbCriteria->order='location_city,location_address ASC';
		if (isset($_GET['MasterLocations']))
			$model->setAttributes($_GET['MasterLocations']);

		$this->render('myAdmin', array(
			'model' => $model,
		));
	}

}