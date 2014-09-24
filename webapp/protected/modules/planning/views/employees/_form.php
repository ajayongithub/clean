<div class="span6">
<div class="bulle">
<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'employees-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'emp_num'); ?>
		<?php echo $form->textField($model, 'emp_num'); ?>
		<?php echo $form->error($model,'emp_num'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_name'); ?>
		<?php echo $form->textField($model, 'emp_name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'emp_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_init'); ?>
		<?php echo $form->textField($model, 'emp_init', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'emp_init'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_last_name'); ?>
		<?php echo $form->textField($model, 'emp_last_name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'emp_last_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_gender'); ?>
		<?php echo $form->dropDownList($model, 'emp_gender', array('Male' => 'Male','Female'=>'Female')); ?>
		<?php echo $form->error($model,'emp_gender'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_phone_no'); ?>
		<?php echo $form->textField($model, 'emp_phone_no', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'emp_phone_no'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_email'); ?>
		<?php echo $form->textField($model, 'emp_email', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'emp_email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_driving_license'); ?>
		<?php echo $form->textField($model, 'emp_driving_license', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'emp_driving_license'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_base_location'); ?>
		<?php echo $form->textField($model, 'emp_base_location', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'emp_base_location'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_work_hr_begin'); ?>
		<?php echo $form->textField($model, 'emp_work_hr_begin'); ?>
		<?php echo $form->error($model,'emp_work_hr_begin'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_work_hr_end'); ?>
		<?php echo $form->textField($model, 'emp_work_hr_end'); ?>
		<?php echo $form->error($model,'emp_work_hr_end'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_designation'); ?>
		<?php //echo //$form->textField($model, 'emp_designation', array('maxlength' => 16)); ?>
		<?php echo  $form->dropDownList($model, 'emp_designation', array('Cleaner' => 'Cleaner','Team Leader'=>'Team Leader')); ?>
		<?php echo $form->error($model,'emp_designation'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'emp_contract_end_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'emp_contract_end_date',
			'value' => $model->emp_contract_end_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'emp_contract_end_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sunday'); ?>
		<?php echo $form->checkBox($model, 'sunday'); ?>
		<?php echo $form->error($model,'sunday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'monday'); ?>
		<?php echo $form->checkBox($model, 'monday'); ?>
		<?php echo $form->error($model,'monday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'tuesday'); ?>
		<?php echo $form->checkBox($model, 'tuesday'); ?>
		<?php echo $form->error($model,'tuesday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'wednesday'); ?>
		<?php echo $form->checkBox($model, 'wednesday'); ?>
		<?php echo $form->error($model,'wednesday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'thursday'); ?>
		<?php echo $form->checkBox($model, 'thursday'); ?>
		<?php echo $form->error($model,'thursday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'friday'); ?>
		<?php echo $form->checkBox($model, 'friday'); ?>
		<?php echo $form->error($model,'friday'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'saturday'); ?>
		<?php echo $form->checkBox($model, 'saturday'); ?>
		<?php echo $form->error($model,'saturday'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- form -->
</div><!-- bulle -->
</div><!-- span -->