<?php
/* @var $this RelatedController */

$this->breadcrumbs=array(
	'Related'=>array('/testMod/related'),
	'Admin',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p><?php $this->widget('application.modules.user.components.CsvGridView', array(
	'dataProvider'=>$model->search(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'active'),
	'cssFile'=>false,
	'filter'=>$model,
		'columns'=>array(
			'order_id',
			'firstname',
			'id',
			'payment_id',
			'payment_type',
			array(
				'class'=>'CButtonColumn',
			),
))); ?>
</p>
