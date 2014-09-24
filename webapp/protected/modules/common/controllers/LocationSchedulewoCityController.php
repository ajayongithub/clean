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
				'actions'=>array('index','view','locationSched'),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
		//	array('deny', 
		//		'users'=>array('*'),
		//		),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'LocationSchedule'),
		));
	}

	public function actionCreate() {
		$model = new LocationSchedule;


		if (isset($_POST['LocationSchedule'])) {
			$model->setAttributes($_POST['LocationSchedule']);

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
		$model = $this->loadModel($id, 'LocationSchedule');


		if (isset($_POST['LocationSchedule'])) {
			$model->setAttributes($_POST['LocationSchedule']);

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
		$this->layout = '//layouts/adminLayout';
		$model = new LocationSchedule('search');
		$model->unsetAttributes();

		if (isset($_GET['LocationSchedule']))
			$model->setAttributes($_GET['LocationSchedule']);

		$this->render('myAdmin', array(
			'model' => $model,
		));
	}
	public function actionLocationSched(){
		$user = YumUser::model()->findByPk(Yii::app()->user->id);
		$locid = 2;
		$dataProvider=LocationSchedule::model()->findAllByAttributes( 
				array('loc_id'=>$locid)
		);
		echo $this->renderPartial('_locSchedules',array('model'=>$dataProvider),true);
	}

}