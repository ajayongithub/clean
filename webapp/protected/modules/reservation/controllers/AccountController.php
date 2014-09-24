<?php
Yii::import('application.modules.profile.controllers.*');
class AccountController extends YumProfileController
{
	public $layout = "//layouts/userLayout" ;
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionUpdate($id=null)
	{
		if(!$id)
			$id = Yii::app()->user->id;

		$user = $this->loadModel($id);
		$profile = $user->profile;

		if(isset($_POST['YumUser']) || isset($_POST['YumProfile'])) {
			$user->attributes=@$_POST['YumUser'];
			$profile->attributes = @$_POST['YumProfile'];
			$profile->user_id = $user->id;


			$profile->validate();
			$user->validate();

			if(!$user->hasErrors() && !$profile->hasErrors()) {
				if($user->save() && $profile->save()) {
					Yum::setFlash(Yii::t('Your changes have been saved'));
//					$this->redirect(array('//reservation/account/update', 'id'=>$user->id));
					$this->redirect(array('//reservation/reservation/index' ));
				}else{
					Yum::setFlash( Yii::t('account',"Changes could not be saved") );
				}
				
			}
		}

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial(Yum::module('profile')->profileEditView,array(
						'user'=>$user,
						'profile'=>$profile,
						));
		else
			$this->render('update',array(
						'user'=>$user,
						'profile'=>$profile,
						'locationData'=>CompanyLocation::getLocationsForComapny($profile->company_id),
						'companyData'=>Company::getCompanyList($profile->company_id),
						));
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