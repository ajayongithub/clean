<div class="span3">
<form action='/common/locationSchedule/create/' method="post">
	<?php echo $this->renderPartial('_myForm',array('model'=>$model));?>
</form>
</div>
<div class="span8">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'location-schedule-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass'=>'table',
//	'filter' => $model,
	'columns' => array(
	//	'id',
		array(
				'name'=>'loc_id',
				'value'=>'GxHtml::valueEx($data->loc)',
				'filter'=>GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true)),
				),
		'sched_date',
	//	'recurrence',
	//	'day',
		array(
				'name'=>'ts_id',
				'value'=>'GxHtml::valueEx($data->ts)',
				'filter'=>GxHtml::listDataEx(TimeSlots::model()->findAllAttributes(null, true)),
				),
		array(
			'class' => 'CButtonColumn',
			'template'=>'{delete}'
		),
	),
)); ?></div>