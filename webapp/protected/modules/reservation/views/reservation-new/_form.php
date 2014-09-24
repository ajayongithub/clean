<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'reservations-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'schedule_id'); ?>
		<?php echo $form->dropDownList($model, 'schedule_id', GxHtml::listDataEx(LocationSchedule::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'schedule_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model, 'status', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'reserved_on'); ?>
		<?php echo $form->textField($model, 'reserved_on'); ?>
		<?php echo $form->error($model,'reserved_on'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'serviceType'); ?>
		<?php echo $form->textField($model, 'serviceType'); ?>
		<?php echo $form->error($model,'serviceType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'changed_by'); ?>
		<?php echo $form->textField($model, 'changed_by', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'changed_by'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'e1'); ?>
		<?php echo $form->textField($model, 'e1', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'e1'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'e2'); ?>
		<?php echo $form->textField($model, 'e2', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'e2'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'last_status_changed_on'); ?>
		<?php echo $form->textField($model, 'last_status_changed_on'); ?>
		<?php echo $form->error($model,'last_status_changed_on'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->