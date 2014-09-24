<div class="row">
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<div class="span3">
	<?php echo $this->renderPartial('_myForm',array('model'=>$model),true);?>
</div>



<div class='span8'>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'company-location-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass'=>'table',
	'filter' => $model,
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'columns' => array(
//		'id',
		'company_name' ,
		'location_address',
		/*array(
				'name'=>'company_id',
				'value'=>'GxHtml::valueEx($data->company)',
				'filter'=>GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'location_id',
				'value'=>'GxHtml::valueEx($data->location)',
				'filter'=>GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true)),
				),*/
//		'start_date',
//		'end_date',
		'remark',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?></div></div>