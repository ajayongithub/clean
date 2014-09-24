<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'location-schedule-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'company_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'loc_id'); ?>
		<?php echo $form->dropDownList($model, 'loc_id', GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'loc_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sched_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'sched_date',
			'value' => $model->sched_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'sched_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'recurrence'); ?>
		<?php echo $form->textField($model, 'recurrence', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'recurrence'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'day'); ?>
		<?php echo $form->textField($model, 'day', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'day'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ts_id'); ?>
		<?php echo $form->dropDownList($model, 'ts_id', GxHtml::listDataEx(TimeSlots::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'ts_id'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('reservations')); ?></label>
		<?php echo $form->checkBoxList($model, 'reservations', GxHtml::encodeEx(GxHtml::listDataEx(Reservations::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->