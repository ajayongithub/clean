<?
$profiles = Yum::hasModule('profile');
$updateableFields = array('firstname','lastname','email','telephone_work','street','city','address_zipcode','bank_account','bank_name', 'car_make','car_model','car_color','car_number_plate');	

if(Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL & $profiles)


echo Yum::renderFlash();

if(Yii::app()->user->isAdmin()) {
	$attributes = array(
			'id',
	);

	if(!Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL)
		$attributes[] = 'username';
		

	if($profiles) {
		$profileFields = YumProfileField::model()->forOwner()->findAll();
		if ($profileFields && $model->profile) {
			foreach($profileFields as $field) {
				if(in_array($field->varname,$updateableFields)){
					array_push($attributes, array(
							'label' => Yum::t($field->title),
							'type' => 'raw',
							'value' => is_array($model->profile)
					? $model->profile->getAttribute($field->varname)
					: $model->profile->getAttribute($field->varname) ,
					));
				}
			}
			array_push($attributes,array('label'=>Yii::t('app','Company'),
										'type'=>'raw',
										'value'=>$company
					));
			array_push($attributes,array('label'=>Yii::t('app','Location'),
					'type'=>'raw',
					'value'=>$location,
			));
			if(isset($subscription)){
				$plan =Plans::model()->findByPk($subscription->plan_id);
			array_push($attributes,array('label'=>Yii::t('app','Subscription'),
					'type'=>'raw',
					'value'=> $plan->plan_name,
			));
			array_push($attributes,array('label'=>Yii::t('app','Start Date'),
					'type'=>'raw',
					'value'=>$subscription->start_date,
			));
			array_push($attributes,array('label'=>Yii::t('app','End Date'),
					'type'=>'raw',
					'value'=>$subscription->expiry_date,
			));
			$charge = number_format($plan->plan_cost*( 1 +($this->VAT/100)),2);
			array_push($attributes,array('label'=>Yii::t('app','Monthly Charge'),
					'type'=>'raw',
					'value'=>$charge,
			));

			}else{
				array_push($attributes,array('label'=>Yii::t('app','Subscription'),
						'type'=>'raw',
						'value'=>'No Current Subscription',
				));
				
			}
			
		}
	}

		/*
		There is no added value to showing the password/salt/activationKey because 
		these are all encrypted 'password', 'salt', 'activationKey',*/
	/*array_push($attributes,
		array(
			'name' => 'createtime',
			'value' => date(UserModule::$dateFormat,$model->createtime),
			),
		array(
			'name' => 'lastvisit',
			'value' => date(UserModule::$dateFormat,$model->lastvisit),
			),
		array(
			'name' => 'lastpasswordchange',
			'value' => date(UserModule::$dateFormat,$model->lastpasswordchange),
			),
		array(
			'name' => 'superuser',
			'value' => YumUser::itemAlias("AdminStatus",$model->superuser),
			),
		array(
			'name' => Yum::t('Activation link'),
			'value' =>$model->getActivationUrl()),
		array(
				'name' => 'status',
			'value' => YumUser::itemAlias("UserStatus",$model->status),
			)
		);*/

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'cssFile'=>false ,
				'attributes'=>$attributes,
				));

} else {
	// For all users
	$attributes = array(
			'username',
			);

	if($profiles) {
		$profileFields = YumProfileField::model()->forAll()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				if(in_array($field->varname,$updateableFields)){
					array_push($attributes,array(
							'label' => Yii::t('UserModule.user', $field->title),
							'name' => $field->varname,
							'value' => $model->profile->getAttribute($field->varname),
							));
				}
			}
		}
	}

	array_push($attributes,
			array(
				'name' => 'createtime',
				'value' => date(UserModule::$dateFormat,$model->createtime),
				),
			array(
				'name' => 'lastvisit',
				'value' => date(UserModule::$dateFormat,$model->lastvisit),
				)
			);

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>$attributes,
				));
}

echo CHtml::link("Back",Yii::app()->createUrl('admin/users/admin'),array('class'=>'btn')) ;



	?>
