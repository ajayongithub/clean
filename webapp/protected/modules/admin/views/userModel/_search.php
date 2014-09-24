<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'activationKey'); ?>
		<?php echo $form->textField($model, 'activationKey', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'createtime'); ?>
		<?php echo $form->textField($model, 'createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'lastvisit'); ?>
		<?php echo $form->textField($model, 'lastvisit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'lastaction'); ?>
		<?php echo $form->textField($model, 'lastaction'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'superuser'); ?>
		<?php echo $form->textField($model, 'superuser'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->textField($model, 'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'avatar'); ?>
		<?php echo $form->textField($model, 'avatar', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'notifyType'); ?>
		<?php echo $form->textField($model, 'notifyType', array('maxlength' => 9)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
