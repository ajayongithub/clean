<div class="form span8">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'reservations-form',
	'enableAjaxValidation' => false,
));
?>


	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php //echo $form->labelEx($model,'user_id'); ?>
		<?php echo 'User:'.$model->user->username; ?>
		<?php echo $form->hiddenField($model, 'user_id'); //, GxHtml::listDataEx(User::model()->findAllAttributes(null, true))); ?>
		<?php //echo $form->error($model,'user_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'schedule_id')." :".MasterLocations::getLocationNameFromId($model->schedule->loc_id); ?>
		<?php echo $form->hiddenField($model, 'schedule_id');// GxHtml::listDataEx(LocationSchedule::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'schedule_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('Reserved' => 'Reserved','Cancelled'=>'Cancelled','Serviced'=>'Serviced')); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'reserved_on').' :'. $model->reserved_on; ?>
		<?php echo $form->error($model,'reserved_on'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'service_type'); ?>
		<?php echo $form->dropDownList($model, 'service_type',Plans::$service_type); ?>
		<?php echo $form->error($model,'service_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php //echo $form->labelEx($model,'changed_by'); ?>
		<?php //echo $form->textField($model, 'changed_by', array('maxlength' => 128)); ?>
		<?php //echo $form->error($model,'changed_by'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textArea($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->
		<div class="row">
		<?php //echo $form->labelEx($model,'e1'); ?>
		<?php //echo $form->textField($model, 'e1', array('maxlength' => 128)); ?>
		<?php //echo $form->error($model,'e1'); ?>
		</div><!-- row -->
		<div class="row">
		<?php //echo $form->labelEx($model,'e2'); ?>
		<?php //echo $form->textField($model, 'e2', array('maxlength' => 128)); ?>
		<?php //echo $form->error($model,'e2'); ?>
		</div><!-- row -->
		<div class="row">
		<?php //echo $form->labelEx($model,'last_status_changed_on'); ?>
		<?php //echo $form->textField($model, 'last_status_changed_on'); ?>
		<?php //echo $form->error($model,'last_status_changed_on'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- form -->