<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('profile-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


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
	'id' => 'profile-model-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		/*array(
				'name'=>'user_id',
//`				'value'=>'GxHtml::valueEx($data->user)',
				'filter'=>GxHtml::listDataEx(User::model()->findAllAttributes(null, true)),
				),*/
		'timestamp',
		'privacy',
		'lastname',
		'firstname',
		/*
		array(
					'name' => 'show_friends',
					'value' => '($data->show_friends === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		array(
					'name' => 'allow_comments',
					'value' => '($data->allow_comments === 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
					'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
					),
		'email',
		'street',
		'city',
		'about',
		'initials',
		'telephone_work',
		'telephone_private',
		'address_zipcode',
		'company_name',
		'company_address',
		'company_zipcode',
		'company_city',
		'car_make',
		'car_model',
		'car_color',
		'car_type',
		'car_lease_company',
		'car_number_plate',
		'company_id',
		'location_id',
		'bank_account',
		'profile_complete_status',
		'country',
		'bank_name',
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>