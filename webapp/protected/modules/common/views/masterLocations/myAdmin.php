<div class="row">
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>


<div class="span3">
<?php echo $this->renderPartial('_myForm',array('model'=>$model),TRUE) ; ?>
<a></a></div>
<div class="span8">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'master-locations-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),

	'filter' => $model,
	'columns' => array(
	//	'id',
		'location_city',
		'location_address',
	//	'location_no',
		'location_zipcode',
		'remarks',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?></div></div>