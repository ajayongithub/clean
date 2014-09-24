<?

$this->breadcrumbs = array(
	Yum::t('Users') => array('index'),
	Yum::t('Manage'));

echo Yum::renderFlash();

$this->widget('application.modules.user.components.CsvGridView', array(
	'dataProvider'=>$model->search(),
	'cssFile'=>false,
	'filter' => $model,
		'columns'=>array(
			array(
				'name'=>'username',
				'type'=>'raw',
				/*'value'=>'CHtml::link(CHtml::encode($data->username),
				array("//admin/users/view","id"=>$data->id))',*/
				'value'=>'$data->username'
			),
			array(
				'filter'=>CHtml::activeTextField($model, 'profile_email'),
				'name'=>'profile.email',
				'type'=>'raw',
				'value'=>'$data->profile->email'
			),
			array(
				'name'=>'status',
				'filter' => false,
				'value'=>'YumUser::itemAlias("UserStatus",$data->status)',
			),
			array(
				'class'=>'CButtonColumn',
			),
))); ?>

<?php //echo CHtml::link(Yum::t('Create new User'), array('//user/user/create')); ?>

