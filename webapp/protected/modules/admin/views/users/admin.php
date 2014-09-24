<?

$this->breadcrumbs = array(
	Yum::t('Users') => array('index'),
	Yum::t('Manage'));

echo Yum::renderFlash();

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'active','internalPageCssClass'=>''),
	'cssFile'=>false,
	'filter'=>$model ,
		'columns'=>array(
			'firstname',
			'lastname',
			'email',
			'username',
			array(
				'name'=>'status',
				'filter'=>CHtml::dropDownList('ProfileModel[status]', '',  
                array(
                	''=>Yum::t("Status"),
                   '0' => Yum::t('Not active'),
					'1' => Yum::t('Active'),
					'-1' => Yum::t('Banned'),
					'-2' => Yum::t('Deleted'),
                )),
				//'filter'=>CHtml::listData(YumUser::itemAlias("UserStatus"),"status","ProfileModel"),
				'value'=>'YumUser::itemAlias("UserStatus",$data->user->status)',
			),	
			array(
				'class'=>'CButtonColumn',
			),
))); ?>

<?php //echo CHtml::link(Yum::t('Create new User'), array('//user/user/create')); ?>

