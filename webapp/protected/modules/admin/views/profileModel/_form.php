<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'profile-model-form',
	'enableAjaxValidation' => true,
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
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model, 'timestamp'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'privacy'); ?>
		<?php echo $form->textField($model, 'privacy', array('maxlength' => 9)); ?>
		<?php echo $form->error($model,'privacy'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model, 'lastname', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'lastname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model, 'firstname', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'firstname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'show_friends'); ?>
		<?php echo $form->checkBox($model, 'show_friends'); ?>
		<?php echo $form->error($model,'show_friends'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'allow_comments'); ?>
		<?php echo $form->checkBox($model, 'allow_comments'); ?>
		<?php echo $form->error($model,'allow_comments'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model, 'street', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'street'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model, 'city', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'city'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'about'); ?>
		<?php echo $form->textArea($model, 'about'); ?>
		<?php echo $form->error($model,'about'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'initials'); ?>
		<?php echo $form->textField($model, 'initials', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'initials'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'telephone_work'); ?>
		<?php echo $form->textField($model, 'telephone_work', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'telephone_work'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'telephone_private'); ?>
		<?php echo $form->textField($model, 'telephone_private', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'telephone_private'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'address_zipcode'); ?>
		<?php echo $form->textField($model, 'address_zipcode', array('maxlength' => 15)); ?>
		<?php echo $form->error($model,'address_zipcode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model, 'company_name', array('maxlength' => 200)); ?>
		<?php echo $form->error($model,'company_name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_address'); ?>
		<?php echo $form->textField($model, 'company_address', array('maxlength' => 200)); ?>
		<?php echo $form->error($model,'company_address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_zipcode'); ?>
		<?php echo $form->textField($model, 'company_zipcode', array('maxlength' => 15)); ?>
		<?php echo $form->error($model,'company_zipcode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_city'); ?>
		<?php echo $form->textField($model, 'company_city', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'company_city'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_make'); ?>
		<?php echo $form->textField($model, 'car_make', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'car_make'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_model'); ?>
		<?php echo $form->textField($model, 'car_model', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'car_model'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_color'); ?>
		<?php echo $form->textField($model, 'car_color', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'car_color'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_type'); ?>
		<?php echo $form->textField($model, 'car_type'); ?>
		<?php echo $form->error($model,'car_type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_lease_company'); ?>
		<?php echo $form->textField($model, 'car_lease_company', array('maxlength' => 50)); ?>
		<?php echo $form->error($model,'car_lease_company'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'car_number_plate'); ?>
		<?php echo $form->textField($model, 'car_number_plate', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'car_number_plate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model, 'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'location_id'); ?>
		<?php echo $form->textField($model, 'location_id'); ?>
		<?php echo $form->error($model,'location_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bank_account'); ?>
		<?php echo $form->textField($model, 'bank_account', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'bank_account'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'profile_complete_status'); ?>
		<?php echo $form->textField($model, 'profile_complete_status', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'profile_complete_status'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model, 'country', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'country'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bank_name'); ?>
		<?php echo $form->textField($model, 'bank_name', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'bank_name'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->