<div class="slice">
<div class="span10">

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<a href="<?php echo Yii::app()->createUrl('planning/cleaningCars/create');?>" class="btn btn-mini">Add Cars</a>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'cleaning-cars-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass' => 'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'filter' => $model,
	'columns' => array(
		//'id',
		'number_plate',
		'car_make',
		'car_model',
		'car_color',
		'base_city',
		'leasing_company',
		'lease_expires_on',
	/*	'remarks',
		'extra',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>
</div>
</div>