
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<div class="span3">
<?php $this->renderPartial('_myForm',array('model'=>$model)) ;?>
</div>

<div class="span8">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'location-schedule-grid',
	'dataProvider' => $model->search2(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),

	'filter' => $model,
	'columns' => array(
		//'id',
		'company_name',
		'location_address',
	/*	array(
				'name'=>'company_id',
				'value'=>'GxHtml::valueEx($data->company)',
				'filter'=>GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'loc_id',
				'value'=>'GxHtml::valueEx($data->loc)',
				'filter'=>GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true)),
				),
*/		array(
			'name'=>'sched_date',
			//'value'=>'$data->sched_date' ,
            //'value'=>'date("d M Y",strtotime($data["work_date"]))'
           'value'=>'Yii::app()->dateFormatter->format("y-MM-dd",strtotime($data->sched_date))'
		),
		'slot_name',
		//'recurrence',
		//'day',
		
/*		array(
				'name'=>'ts_id',
				'value'=>'GxHtml::valueEx($data->ts)',
				'filter'=>GxHtml::listDataEx(TimeSlots::model()->findAllAttributes(null, true)),
				),*/
		
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?>
</div>