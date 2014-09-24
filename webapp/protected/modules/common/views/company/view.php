<div class="span4 bulle">
<h1>View Details : <?php echo $model->company_name?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile' => false,
	'attributes' => array(
//'id',
'company_name',
'ho_address',
//'ho_number',
'ho_zipcode',
'ho_city',
'contact_firstname',
'contact_init',
'contact_lastname',
'contact_email',
//'extra_column',
'remarks',
//'start_date',
//'end_date',
//'duration',
	),
)); ?>

<h2><?php //echo GxHtml::encode($model->getRelationLabel('companyLocations')); ?></h2>
<?php
//	echo GxHtml::openTag('ul');
//	foreach($model->companyLocations as $relatedModel) {
//		echo GxHtml::openTag('li');
//		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('companyLocation/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
//		echo GxHtml::closeTag('li');
//	}
//	echo GxHtml::closeTag('ul');
?></div>