<?php

class CleaningCarsController extends GxController {
public $layout = "//layouts/adminLayout" ;
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
				'actions'=>array('admin','delete','index','view','update','create'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'CleaningCars'),
		));
	}

	public function actionCreate() {
		$model = new CleaningCars;

		$this->performAjaxValidation($model, 'cleaning-cars-form');

		if (isset($_POST['CleaningCars'])) {
			$model->setAttributes($_POST['CleaningCars']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'CleaningCars');

		$this->performAjaxValidation($model, 'cleaning-cars-form');

		if (isset($_POST['CleaningCars'])) {
			$model->setAttributes($_POST['CleaningCars']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'CleaningCars')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('CleaningCars');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new CleaningCars('search');
		$model->unsetAttributes();

		if (isset($_GET['CleaningCars']))
			$model->setAttributes($_GET['CleaningCars']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}