<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id', array('maxlength' => 10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'user_id'); ?>
		<?php echo $form->dropDownList($model, 'user_id', GxHtml::listDataEx(User::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'timestamp'); ?>
		<?php echo $form->textField($model, 'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'privacy'); ?>
		<?php echo $form->textField($model, 'privacy', array('maxlength' => 9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'lastname'); ?>
		<?php echo $form->textField($model, 'lastname', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'firstname'); ?>
		<?php echo $form->textField($model, 'firstname', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'show_friends'); ?>
		<?php echo $form->dropDownList($model, 'show_friends', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'allow_comments'); ?>
		<?php echo $form->dropDownList($model, 'allow_comments', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'street'); ?>
		<?php echo $form->textField($model, 'street', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'city'); ?>
		<?php echo $form->textField($model, 'city', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'about'); ?>
		<?php echo $form->textArea($model, 'about'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'initials'); ?>
		<?php echo $form->textField($model, 'initials', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'telephone_work'); ?>
		<?php echo $form->textField($model, 'telephone_work', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'telephone_private'); ?>
		<?php echo $form->textField($model, 'telephone_private', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'address_zipcode'); ?>
		<?php echo $form->textField($model, 'address_zipcode', array('maxlength' => 15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company_name'); ?>
		<?php echo $form->textField($model, 'company_name', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company_address'); ?>
		<?php echo $form->textField($model, 'company_address', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company_zipcode'); ?>
		<?php echo $form->textField($model, 'company_zipcode', array('maxlength' => 15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company_city'); ?>
		<?php echo $form->textField($model, 'company_city', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_make'); ?>
		<?php echo $form->textField($model, 'car_make', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_model'); ?>
		<?php echo $form->textField($model, 'car_model', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_color'); ?>
		<?php echo $form->textField($model, 'car_color', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_type'); ?>
		<?php echo $form->textField($model, 'car_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_lease_company'); ?>
		<?php echo $form->textField($model, 'car_lease_company', array('maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'car_number_plate'); ?>
		<?php echo $form->textField($model, 'car_number_plate', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'company_id'); ?>
		<?php echo $form->textField($model, 'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'location_id'); ?>
		<?php echo $form->textField($model, 'location_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'bank_account'); ?>
		<?php echo $form->textField($model, 'bank_account', array('maxlength' => 128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'profile_complete_status'); ?>
		<?php echo $form->textField($model, 'profile_complete_status', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'country'); ?>
		<?php echo $form->textField($model, 'country', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'bank_name'); ?>
		<?php echo $form->textField($model, 'bank_name', array('maxlength' => 128)); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
