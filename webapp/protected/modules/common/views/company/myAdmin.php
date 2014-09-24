<div class="row ">
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<div class="span3">
		<?php echo $this->renderPartial('_myForm',array('model'=>$model),TRUE)?>
</div>
<div class="span7">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'company-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass' => 'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),

	'filter' => $model,
	'columns' => array(
		//'id',
		'company_name',
		'ho_city',
		'contact_email',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{view}{update}{delete}',
		),
	),
)); ?></div></div>