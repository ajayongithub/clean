<?php

class TimeSlotsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TimeSlots'),
		));
	}

	public function actionCreate() {
		$this->layout = '//layouts/adminLayout' ;
		$model = new TimeSlots;


		if (isset($_POST['TimeSlots'])) {
			$model->setAttributes($_POST['TimeSlots']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin',));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$this->layout = '//layouts/adminLayout' ;
		$model = $this->loadModel($id, 'TimeSlots');


		if (isset($_POST['TimeSlots'])) {
			$model->setAttributes($_POST['TimeSlots']);

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
			$this->loadModel($id, 'TimeSlots')->delete();
			}catch(Exception $ex){
				throw new CHttpException(500,Yii::t('app','Time Slot is being used, cannot delete'));
			}
			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('TimeSlots');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$this->layout = '//layouts/adminLayout' ;
		
		$model = new TimeSlots('search');
		$model->unsetAttributes();

		if (isset($_GET['TimeSlots']))
			$model->setAttributes($_GET['TimeSlots']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function actionInlineCreate(){
		$model = new TimeSlots;
		if (isset($_POST['TimeSlots'])) {
			$model->setAttributes($_POST['TimeSlots']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$retObj = array();
					$retObj->s = 1 ;
					echo CJSON::encode($retObj);
				}
			}
		}

		$this->render('create', array( 'model' => $model));
	}

}