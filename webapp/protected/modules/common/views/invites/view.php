
<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' ; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile'=>false,
	'attributes' => array(
//'id',
'cre_date',
array(
			'name' => 'company',
			'type' => 'raw',
			'value' => $model->company !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->company)), array('company/view', 'id' => GxActiveRecord::extractPkValue($model->company, true))) : null,
			),
'username',
'lastname',
'email',
'invite_key',
//'remarks',
	),
)); ?>

