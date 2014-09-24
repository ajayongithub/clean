<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-main-script-1',
		'$("#TimeSlots[slot_begin]").datepicker();
	',
  CClientScript::POS_END
);
?>

<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'time-slots-form',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'slot_name'); 
		 echo $form->textField($model, 'slot_name', array('maxlength' => 128,'style'=>'width:35%')); ?>
		<?php echo $form->error($model,'slot_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'slot_begin'); ?>
		<?php echo $form->textField($model, 'slot_begin',array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'slot_begin'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'slot_end'); ?>
		<?php echo $form->textField($model, 'slot_end',array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'slot_end'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textArea($model, 'remarks', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->

		<label><?php //echo GxHtml::encode($model->getRelationLabel('locationSchedules')); ?></label>
		<?php //echo $form->checkBoxList($model, 'locationSchedules', GxHtml::encodeEx(GxHtml::listDataEx(LocationSchedule::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- form -->