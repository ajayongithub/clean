<?php
?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'reservations-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass' => 'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'filter' => $model,
	'columns' => array(
		/*array(
		'header'=>'Reserved For',
		'name'=>'schedule.sched_date' ,
		'value'=>'$data->schedule->sched_date',	
		),*/
		/*array(
				'header'=>'User',
				'name'=>'user_id',
				//'value'=>'GxHtml::valueEx($data->user->username)',
				'value'=>'$data->user->username',
				//'filter'=>GxHtml::listDataEx(YumUser::model()->findAllAttributes(null, true)),
				),*/
		'sched_date',
		'username',
		'location_address',
		/*array(

				'header'=>'Location',
				'name'=>'schedule_id',
				//'value'=>'GxHtml::valueEx($data->schedule)',
//				'value'=>'Company::getCompanyName($data->schedule->company_id)',
				'value'=>' MasterLocations::getLocationNameFromId($data->schedule->loc_id)',
				//'filter'=>GxHtml::listDataEx(LocationSchedule::model()->findAllAttributes(null, true)),
				),
*/
		'status',
		
		/*array(
		'name'=>'reserved_on',
		'value'=>'Yii::app()->dateFormatter->format("d MMM y",strtotime($data->reserved_on))'
		),*/
				array(
						'name'=>'service_type',
						'value'=>'Plans::$service_type[$data->service_type]' ,
						'filter'=>CHtml::dropDownList('Reservations[service_type]','',Plans::getServiceTypeForList()),
				),

		/*
		'changed_by',
		'remarks',
		'e1',
		'e2',
		'last_status_changed_on',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>
