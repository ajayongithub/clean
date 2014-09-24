<div class="span12">
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<div class="span3">
<?php 
	$this->renderPartial('_myForm',array('model'=>$model));
	?>
</div>
<div class="span7">


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'invites-grid',
	'dataProvider' => $model->search(),
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
//	'filter' => $model,
	'itemsCssClass'=>'table',
	'columns' => array(
		//'id',
		//'cre_date',
		array(
				'name'=>'company_id',
				'value'=>'GxHtml::valueEx($data->company)',
				'filter'=>GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),
				),
		//'username',
		//'lastname',
		//'email',
		array(
			'name'=>'invite_key',
			'value'=>'Yii::app()->createAbsoluteUrl("/common/invites/accept", array("inviteId"=>$data->invite_key));'
		),

		/*'remarks',
		*/
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?></div></div>