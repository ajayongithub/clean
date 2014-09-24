<?php

class InvitesController extends GxController {
public $layout = '//layouts/adminLayout';
public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view','accept'),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','create','delete','view'),
				'users'=>array('admin'),
				),
//			array('deny', 
//				'users'=>array('*'),
//				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Invites'),
		));
	}

	public function actionCreate() {
		$model = new Invites;

		$this->performAjaxValidation($model, 'invites-form');

		if (isset($_POST['Invites'])) {
			$model->setAttributes($_POST['Invites']);
			$date = new DateTime('now');
			$cre_date = $date->add(new DateInterval('P60D'))->format('Y-m-d H:i:s');
			$model->cre_date = $cre_date ; 
			$actKey = mt_rand().mt_rand().mt_rand() ;
			$model->invite_key = $actKey ;
			if($model->save()) {
				if(isset($model->email)){
					if($this->sendInviteMail($model))
						Yii::log( "Mail sent Successfully");
					else{
						Yii::log( "mail could not be sent") ;
						Yii::app()->end();
					}

				}
						
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{
					$this->redirect('admin');
						
				}
			}
		}

		//$this->render('create', array( 'model' => $model));
	}
	private function sendInviteMail($model){
		if(!isset($model)) return false;
		$invite_url = Yii::app()->createAbsoluteUrl('/common/invites/accept', array('inviteId'=>$model->invite_key));
		$body = strtr(
				'Hello, {username}. Please create your account with this url: {activation_url}', array(
					'{username}' => $model->username,
					'{activation_url}' => $invite_url));
		$subject = "Invitation to join Yclean ";
		//echo $model->email ;
		Yii::import('application.modules.common.controllers.YMailerController');

		$retVal = YMailerController::sendMail($model->email, 'cs@yclean.nl', $subject, $body,NULL, NULL); 	
		return $retVal ; 
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Invites');

		$this->performAjaxValidation($model, 'invites-form');

		if (isset($_POST['Invites'])) {
			$model->setAttributes($_POST['Invites']);

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
			$this->loadModel($id, 'Invites')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('myAdmin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Invites');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Invites('search');
		$model->unsetAttributes();

		if (isset($_GET['Invites']))
			$model->setAttributes($_GET['Invites']);

		$this->render('myAdmin', array(
			'model' => $model,
		));
	}
	public function actionAccept($inviteId){
		$this->layout = "//layouts/main";
		Yii::log('Invite Id is :'.$inviteId);
		$myModel = Invites::model()->findByAttributes(array('invite_key'=>$inviteId));
		if($myModel!=null){
			$this->render('accept',array('company_id'=>$myModel->company_id));
		}else{
			throw new CHttpException(400,Yii::t('app', 'Your request is invalid'));
		}
		
		
	}

}