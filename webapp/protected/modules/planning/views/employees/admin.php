<div class="bulle">
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<a href="<?php echo Yii::app()->createUrl('planning/employees/create');?>" class="btn btn-mini">Add Employees</a>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'employees-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'filter' => $model,
	'columns' => array(
//		'id',
//		'emp_num',
		'emp_name',
//		'emp_init',
		'emp_last_name',
		'emp_designation',
		'emp_base_location',
		'emp_phone_no',
//		'emp_gender',
		/*
		'emp_phone_no',
		'emp_email',
		'emp_driving_license',
	
		'emp_working_days',
		'emp_work_hr_begin',
		'emp_work_hr_end',
		'emp_designation',
		'emp_contract_end_date',
		'remarks',
		'emp_ex1',
		array(
					'name' => 'sunday',
					'value' => '($data->sunday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'monday',
					'value' => '($data->monday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'tuesday',
					'value' => '($data->tuesday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'wednesday',
					'value' => '($data->wednesday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'thursday',
					'value' => '($data->thursday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'friday',
					'value' => '($data->friday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'saturday',
					'value' => '($data->saturday === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?></div>