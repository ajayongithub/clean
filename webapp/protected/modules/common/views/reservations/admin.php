<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('reservations-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'reservations-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass' => 'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	//'filter' => $model,
	'columns' => array(
		'id',
		array(
				'name'=>'user_id',
				'value'=>'$data->user_id'
				//'value'=>'GxHtml::valueEx($data->profile->firstname)',
				//'filter'=>GxHtml::listDataEx(::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'schedule_id',
				'value'=>'GxHtml::valueEx($data->loc->location_address)',
				//'filter'=>GxHtml::listDataEx(::model()->findAllAttributes(null, true)),
				),
		'status',
		'reserved_on',
		'changed_by',
		/*
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