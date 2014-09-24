
<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile'=>false,
	'attributes' => array(
//'id',
array(
	'label'=>'Name',
			//'name' => 'user',
			'type' => 'raw',
		'value' => $model->user->username,
			),
array(
			'label'=>'Location',
			'name' => 'schedule',
			'type' => 'raw',
			'value' => MasterLocations::getLocationNameFromId($model->schedule->loc_id),
			),
'status',
'reserved_on',
array(
			'name' => 'service_type',
			'type' => 'raw',
			'value' => Plans::$service_type[$model->service_type] ,
),

//'changed_by',
//'remarks',
//'e1',
//'e2',
//'last_status_changed_on',
	),
)); 

echo CHtml::link('Back',Yii::app()->createUrl('/reservation/reservation/admin'),array('class'=>'btn'));
?>

