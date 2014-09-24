<div class="row offset1">
<div class="span9">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'payment-details-grid',
	'dataProvider' => $model->search(),
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'filter' => $model,
	'itemsCssClass'=>'table',
	'columns' => array(
		//'id',
		//'order_id',
		'payment_id',
		'payment_issue_date',
//		'payment_confirm_date',
		array(
		'header'=>'<a>Amount</a>',
		'name'=>'amount',
		'value'=>function($data){
		            return number_format($data->amount, 2);
								        },

		),
		'firstname',
		'lastname',
		'payment_type',

		'status',
//		'extra1',
		
		array(
			'class' => 'CButtonColumn',
			'template'=>'{view}{update}'
		),
	),
)); ?></div></div>