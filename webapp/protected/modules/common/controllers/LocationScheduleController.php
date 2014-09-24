<?php

class LocationScheduleController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('getLocationsForCompany'),
				'roles'=>array('?'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','create','update','delete','getLocationsForCompany'),
				'users'=>array('admin'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'LocationSchedule'),
		));
	}

	public function actionCreate() {
		$model = new LocationSchedule;

		$this->performAjaxValidation($model, 'location-schedule-form');

		if (isset($_POST['LocationSchedule'])) {
			$model->setAttributes($_POST['LocationSchedule']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin' ));
			}
		}

		$this->render('admin');
	}

	public function actionUpdate($id) {
		$this->layout="//layouts/adminLayout" ;
		$model = $this->loadModel($id, 'LocationSchedule');

		$this->performAjaxValidation($model, 'location-schedule-form');

		if (isset($_POST['LocationSchedule'])) {
			$model->setAttributes($_POST['LocationSchedule']);

			if ($model->save()) {
				$this->redirect(array('admin' ));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'LocationSchedule')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('LocationSchedule');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->layout="//layouts/adminLayout" ;
		$model = new LocationSchedule('search2');
		$model->unsetAttributes();
		
		if (isset($_GET['LocationSchedule'])){
			$model->setAttributes($_GET['LocationSchedule']);
		//var_dump($model);
		Yii::log("model company name is ".$model->company_name) ;
		Yii::log("Get companyName is ".$_GET['LocationSchedule']['company_name']) ;
		Yii::log("model underscore company name is ".$model->_company_name) ;
		}

		$this->render('myAdmin', array(
			'model' => $model,
		));
	}
	public function actionGetLocationsForCompany(){
		if(isset($_POST['companyId'])){
			$company_id = $_POST['companyId'];
			$arr = array();
			$arr[0]="Hello" ;
			echo json_encode(CompanyMasterLocations::getLocationsForCompany($company_id));

		}	
	}
}