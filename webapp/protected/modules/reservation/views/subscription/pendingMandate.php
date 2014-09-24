
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'payment-details-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'itemsCssClass'=>'table',
	'columns' => array(
		'id',
		'order_id',
//		'payment_id',
		'payment_issue_date',
//		'payment_confirm_date',
//		'amount',
		/*
		'payment_type',
		'status',
		'extra1',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>
