<?php

class PaymentDetailsController extends GxController {
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
				'actions'=>array('admin','delete','view','update','searchMandate','downloadMandate'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'PaymentDetails'),
		));
	}

	public function actionCreate() {
		$model = new PaymentDetails;

		$this->performAjaxValidation($model, 'payment-details-form');

		if (isset($_POST['PaymentDetails'])) {
			$model->setAttributes($_POST['PaymentDetails']);

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
		$model = $this->loadModel($id, 'PaymentDetails');

		$this->performAjaxValidation($model, 'payment-details-form');
		if(strcmp($model->payment_type,'Mandate')==0) 
		if (isset($_POST['PaymentDetails'])) {
			//echo $_POST['PaymentDetails']['status'] ;
			if(strcmp($model->payment_type,'Mandate')==0&&strcmp($model->status,'Pending')==0
					&&strcmp($_POST['PaymentDetails']['status'],'Received')==0)
					$startSubscription = true ;
			else $startSubscription = false ; 

			$model->setAttributes($_POST['PaymentDetails']);

			if ($model->save()) {
				if($startSubscription){
					$order = Orders::model()->findByPk($model->order_id);
					$profile = YumProfile::model()->findByAttributes(array('user_id'=>$order->user_id)); 
					Subscription::startSubscription($order,$model,$profile);
				}
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'PaymentDetails')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('PaymentDetails');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new PaymentDetails('search');
		$model->unsetAttributes();

		if (isset($_GET['PaymentDetails']))
			$model->setAttributes($_GET['PaymentDetails']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function actionSearchMandate() {
		$model = new PaymentDetails('search');
		$model->unsetAttributes();

		if (isset($_GET['PaymentDetails']))
			$model->setAttributes($_GET['PaymentDetails']);

		$model->payment_type='Mandate';
//		$model->status='Pending';

		$this->render('admin', array( 'model' => $model));
	}

	public function actionDownloadMandate($orderId){
		
		$order = Orders::model()->findByPk($orderId);
		$userId = $order->user_id ;
		
		$basePath = Yii::getPathOfAlias('webroot');
		$file= $basePath.'/downloads/'.$userId.'.pdf';
		//echo $file ;
		if (file_exists($file)) {
			//echo "file Exists" ;
			header('Content-Description: File Transfer');
			header('Content-Type: "application/pdf"');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			//exit;
		}
	}
}
