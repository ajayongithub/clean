<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'payment-details-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->textField($model, 'order_id'); ?>
		<?php echo $form->error($model,'order_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'payment_issue_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'payment_issue_date',
			'value' => $model->payment_issue_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'payment_issue_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'payment_confirm_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'payment_confirm_date',
			'value' => $model->payment_confirm_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'payment_confirm_date'); ?>
		</div><!-- row -->
		<div class="row">
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'payment_type'); ?>
		<?php echo $form->textField($model, 'payment_type', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'payment_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php //echo $form->textField($model, 'status', array('maxlength' => 128)); ?>
		<?php echo $form->dropDownList($model, 'status',array('Pending'=>'Pending','Received'=>'Received'), array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'),array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- form -->