
<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile'=>false ,
	'attributes' => array(
//'id',
'emp_num',
'emp_name',
'emp_init',
'emp_last_name',
'emp_gender',
'emp_phone_no',
'emp_email',
'emp_driving_license',
'emp_base_location',
//'emp_working_days',
'emp_work_hr_begin',
'emp_work_hr_end',
'emp_designation',
'emp_contract_end_date',
'remarks',
//'emp_ex1',
'sunday:boolean',
'monday:boolean',
'tuesday:boolean',
'wednesday:boolean',
'thursday:boolean',
'friday:boolean',
'saturday:boolean',
array
(
     'type'=>'raw',
     'value'=>CHtml::link("Back",Yii::app()->createUrl("planning/employees/admin"),array("class"=>"btn"))
),

),
)); ?>

