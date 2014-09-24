<div class="form">
<div class="span6">
<div class="bulle">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'cleaning-cars-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'number_plate'); ?>
		<?php echo $form->textField($model, 'number_plate', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'number_plate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_make'); ?>
		<?php echo $form->textField($model, 'car_make', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'car_make'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_model'); ?>
		<?php echo $form->textField($model, 'car_model', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'car_model'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_color'); ?>
		<?php echo $form->textField($model, 'car_color', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'car_color'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'base_city'); ?>
		<?php echo $form->textField($model, 'base_city', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'base_city'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'leasing_company'); ?>
		<?php echo $form->textField($model, 'leasing_company', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'leasing_company'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lease_expires_on'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'lease_expires_on',
			'value' => $model->lease_expires_on,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'lease_expires_on'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- bulle -->
</div><!-- span -->
</div><!-- form -->