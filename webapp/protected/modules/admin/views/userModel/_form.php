<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-model-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'password'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'salt'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'activationKey'); ?>
		<?php echo $form->textField($model, 'activationKey', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'activationKey'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'createtime'); ?>
		<?php echo $form->textField($model, 'createtime'); ?>
		<?php echo $form->error($model,'createtime'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lastvisit'); ?>
		<?php echo $form->textField($model, 'lastvisit'); ?>
		<?php echo $form->error($model,'lastvisit'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lastaction'); ?>
		<?php echo $form->textField($model, 'lastaction'); ?>
		<?php echo $form->error($model,'lastaction'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lastpasswordchange'); ?>
		<?php echo $form->textField($model, 'lastpasswordchange'); ?>
		<?php echo $form->error($model,'lastpasswordchange'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'superuser'); ?>
		<?php echo $form->textField($model, 'superuser'); ?>
		<?php echo $form->error($model,'superuser'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model, 'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php echo $form->textField($model, 'avatar', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'avatar'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'notifyType'); ?>
		<?php echo $form->textField($model, 'notifyType', array('maxlength' => 9)); ?>
		<?php echo $form->error($model,'notifyType'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('orders')); ?></label>
		<?php echo $form->checkBoxList($model, 'orders', GxHtml::encodeEx(GxHtml::listDataEx(Orders::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('profiles')); ?></label>
		<?php echo $form->checkBoxList($model, 'profiles', GxHtml::encodeEx(GxHtml::listDataEx(Profile::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('reservations')); ?></label>
		<?php echo $form->checkBoxList($model, 'reservations', GxHtml::encodeEx(GxHtml::listDataEx(Reservations::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('subscriptions')); ?></label>
		<?php echo $form->checkBoxList($model, 'subscriptions', GxHtml::encodeEx(GxHtml::listDataEx(Subscription::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->