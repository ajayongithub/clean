<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'company-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model, 'company_name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'company_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ho_address'); ?>
		<?php echo $form->textField($model, 'ho_address', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'ho_address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ho_number'); ?>
		<?php echo $form->textField($model, 'ho_number', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'ho_number'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ho_zipcode'); ?>
		<?php echo $form->textField($model, 'ho_zipcode', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'ho_zipcode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ho_city'); ?>
		<?php echo $form->textField($model, 'ho_city', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'ho_city'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'contact_firstname'); ?>
		<?php echo $form->textField($model, 'contact_firstname', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'contact_firstname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'contact_init'); ?>
		<?php echo $form->textField($model, 'contact_init', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'contact_init'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'contact_lastname'); ?>
		<?php echo $form->textField($model, 'contact_lastname', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'contact_lastname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'contact_email'); ?>
		<?php echo $form->textField($model, 'contact_email', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'contact_email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'extra_column'); ?>
		<?php echo $form->textField($model, 'extra_column', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'extra_column'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'start_date',
			'value' => $model->start_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'start_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'end_date',
			'value' => $model->end_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'end_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'duration'); ?>
		<?php echo $form->textField($model, 'duration', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'duration'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('companyLocations')); ?></label>
		<?php echo $form->checkBoxList($model, 'companyLocations', GxHtml::encodeEx(GxHtml::listDataEx(CompanyLocation::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->