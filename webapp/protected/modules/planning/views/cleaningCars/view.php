<div class="span6">
<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile' => FALSE,
	'attributes' => array(
'number_plate',
'car_make',
'car_model',
'car_color',
'base_city',
'leasing_company',
'lease_expires_on',
'remarks',
//'extra',
	),
)); ?>

</div>