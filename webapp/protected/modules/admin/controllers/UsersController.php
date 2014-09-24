<?php

class UsersController extends Controller
{
	public $layout="//layouts/adminLayout" ;
	public $_model ;
	public $_profile ;
	public $VAT = 21 ;
/*	public function actionAdmin(){
		if(Yum::hasModule('role'))
			Yii::import('application.modules.role.models.*');
//		$this->layout = Yum::module()->adminLayout;
		$model = new YumUser('search');
		if(isset($_GET['YumUser']))
			$model->attributes = $_GET['YumUser'];
		$this->render('admin', array('model'=>$model));
	}*/
	
	public function actionAdmin(){
		$model = new ProfileModel('search');
		$model->unsetAttributes();

		if (isset($_GET['ProfileModel']))
			$model->setAttributes($_GET['ProfileModel']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionUpdate() {
		$profile=$this->loadProfile();
		$model = $this->loadUser($profile->user_id);
		$passwordform = new YumUserChangePassword();
		if(isset($_POST['YumUser'])) {
			if(!isset($model->salt) || empty($model->salt))
				$model->salt = YumEncrypt::generateSalt();
			
			$model->attributes = $_POST['YumUser'];
			if(Yum::hasModule('role')) {
				Yii::import('application.modules.role.models.*');
				// Assign the roles and belonging Users to the model
				$model->roles = Relation::retrieveValues($_POST);
			}

			if(Yum::hasModule('profile')) {
				$profile = $model->profile;

				if(isset($_POST['YumProfile']) )
					$profile->attributes = $_POST['YumProfile'];
			}

			// Password change is requested ?
			if(isset($_POST['YumUserChangePassword'])
					&& $_POST['YumUserChangePassword']['password'] != '') {
				$passwordform->attributes = $_POST['YumUserChangePassword'];
				if($passwordform->validate())
					$model->setPassword($_POST['YumUserChangePassword']['password'], $model->salt);
			}

			if(!$passwordform->hasErrors() && $model->save()) {
				if(isset($profile)) 
					$profile->save();

				$this->redirect(array('//admin/users/view', 'id' => $model->profile->id));
			}
		}

		$this->render('update', array(
					'model'=>$model,
					'passwordform' =>$passwordform,
					'profile' => isset($profile) ? $profile : $this->loadProfile(),
					));
					
	}
	public function actionDelete($id = null) {
		if(!$id)
			$id = Yii::app()->user->id;

		$user = YumUser::model()->findByPk($id);

		if(Yii::app()->user->isAdmin()) {
			//This is necesary for handling human stupidity.
			if($user && ($user->id == Yii::app()->user->id)) {
				Yum::setFlash('You can not delete your own admin account');
				$this->redirect(array('//admin/users/admin'));
			}

			if($user->delete()) {
				Yum::setFlash('The User has been deleted');
				if(!Yii::app()->request->isAjaxRequest)
					$this->redirect('//admin/users/admin');
			}
		}else throw new CHttpException(403,"You are not authorized to perform this action") ; 
		$this->render('confirmDeletion', array('model' => $user));
	}
	
	public function actionView()
	{
		$profile = $this->loadProfile() ;
		$model = $this->loadUser($this->_profile->user_id);
		$subsDetail = Subscription::model()->findByAttributes(array('user_id'=>$model->id));
		
		$this->render('view',array(
					'model'=>$model,'location'=>MasterLocations::getLocationNameFromId($model->profile->location_id),
					'company'=>Company::getCompanyName($model->profile->company_id),
					'subscription'=>$subsDetail,
					));
	}
/**
	 * Loads the User Object instance
	 * @return YumUser
	 */
	public function loadUser($uid = 0)
	{
		if($this->_model === null)
		{
			if($uid != 0)
				$this->_model = YumUser::model()->findByPk($uid);
			elseif(isset($_GET['id']))
				$this->_model = YumUser::model()->findByPk($_GET['id']);
			if($this->_model === null)
				throw new CHttpException(404,'The requested User does not exist.');
		}
		return $this->_model;
	}
	public function loadProfile1($uid=0){
		if($this->_profile===null){
			if($uid!=0)
				$this->_profile = YumProfile::model()->findByAttributes(array('user_id'=>$uid));
			elseif(isset($_GET['id']))
				$this->_profile = YumProfile::model()->findByAttributes(array('user_id'=>$_GET['id']));
			if($this->_profile===null)
				throw new CHttpException(404,'The user details do not exist.') ;
		}
		return $this->_profile;
	}
	
	public function loadProfile($uid=0){
		if($this->_profile===null){
			if($uid!=0)
				$this->_profile = YumProfile::model()->findByPk($uid);
			elseif(isset($_GET['id']))
				$this->_profile = YumProfile::model()->findByPk($_GET['id']);
			if($this->_profile===null)
				throw new CHttpException(404,'The user details do not exist.') ;
		}
		return $this->_profile;
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