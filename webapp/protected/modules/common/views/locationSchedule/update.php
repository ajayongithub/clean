
<h1><?php echo Yii::t('app', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
<div class="span6">
<?php
$this->renderPartial('_myForm', array(
		'model' => $model));
?></div>