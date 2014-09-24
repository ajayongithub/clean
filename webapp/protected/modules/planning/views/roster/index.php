<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'schedules-grid',
	'dataProvider' => $ls->search(),
	'itemsCssClass' => 'table',
	'filter' => $ls,
	'columns' => array(
		'id',
		//'number_plate',
		//'car_make',
		//'car_model',
		//'car_color',
		//'base_city',
		//'leasing_company',
		//'lease_expires_on',
	/*	'remarks',
		'extra',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>