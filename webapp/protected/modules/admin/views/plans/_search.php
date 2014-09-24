<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'plan_name'); ?>
		<?php echo $form->textField($model, 'plan_name', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'plan_cost'); ?>
		<?php echo $form->textField($model, 'plan_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'plan_duration'); ?>
		<?php echo $form->textField($model, 'plan_duration'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 128)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
