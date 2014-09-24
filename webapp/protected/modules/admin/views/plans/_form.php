<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'plans-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'plan_name'); ?>
		<?php echo $form->textField($model, 'plan_name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'plan_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'plan_cost'); ?>
		<?php echo $form->textField($model, 'plan_cost'); ?>
		<?php echo $form->error($model,'plan_cost'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'plan_duration'); ?>
		<?php echo $form->textField($model, 'plan_duration'); ?>
		<?php echo $form->error($model,'plan_duration'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->