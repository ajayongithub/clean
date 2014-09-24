<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'master-locations-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'location_address'); ?>
		<?php echo $form->textField($model, 'location_address', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'location_address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'location_no'); ?>
		<?php echo $form->textField($model, 'location_no', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'location_no'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'location_zipcode'); ?>
		<?php echo $form->textField($model, 'location_zipcode', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'location_zipcode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'location_city'); ?>
		<?php echo $form->textField($model, 'location_city', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'location_city'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('companyLocations')); ?></label>
		<?php echo $form->checkBoxList($model, 'companyLocations', GxHtml::encodeEx(GxHtml::listDataEx(CompanyLocation::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('locationSchedules')); ?></label>
		<?php echo $form->checkBoxList($model, 'locationSchedules', GxHtml::encodeEx(GxHtml::listDataEx(LocationSchedule::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->