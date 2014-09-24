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
		<?php echo $form->label($model, 'emp_num'); ?>
		<?php echo $form->textField($model, 'emp_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_name'); ?>
		<?php echo $form->textField($model, 'emp_name', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_init'); ?>
		<?php echo $form->textField($model, 'emp_init', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_last_name'); ?>
		<?php echo $form->textField($model, 'emp_last_name', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_gender'); ?>
		<?php echo $form->textField($model, 'emp_gender', array('maxlength' => 6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_phone_no'); ?>
		<?php echo $form->textField($model, 'emp_phone_no', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_email'); ?>
		<?php echo $form->textField($model, 'emp_email', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_driving_license'); ?>
		<?php echo $form->textField($model, 'emp_driving_license', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_base_location'); ?>
		<?php echo $form->textField($model, 'emp_base_location', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_working_days'); ?>
		<?php echo $form->textField($model, 'emp_working_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_work_hr_begin'); ?>
		<?php echo $form->textField($model, 'emp_work_hr_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_work_hr_end'); ?>
		<?php echo $form->textField($model, 'emp_work_hr_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_designation'); ?>
		<?php echo $form->textField($model, 'emp_designation', array('maxlength' => 16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_contract_end_date'); ?>
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
	</div>

	<div class="row">
		<?php echo $form->label($model, 'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'emp_ex1'); ?>
		<?php echo $form->textField($model, 'emp_ex1', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'sunday'); ?>
		<?php echo $form->dropDownList($model, 'sunday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'monday'); ?>
		<?php echo $form->dropDownList($model, 'monday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'tuesday'); ?>
		<?php echo $form->dropDownList($model, 'tuesday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'wednesday'); ?>
		<?php echo $form->dropDownList($model, 'wednesday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'thursday'); ?>
		<?php echo $form->dropDownList($model, 'thursday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'friday'); ?>
		<?php echo $form->dropDownList($model, 'friday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'saturday'); ?>
		<?php echo $form->dropDownList($model, 'saturday', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
