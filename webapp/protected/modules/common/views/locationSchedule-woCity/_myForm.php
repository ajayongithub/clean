<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'location-schedule-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>
<div class="bulle">
		<div class="row">
		<?php echo $form->labelEx($model,'loc_id'); ?>
		<?php echo $form->dropDownList($model, 'loc_id', GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'loc_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sched_date'); ?>
		<?php  $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'sched_date',
			'value' => $model->sched_date,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
 ?>
		<?php echo $form->error($model,'sched_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ts_id'); ?>
		<?php echo $form->dropDownList($model, 'ts_id', GxHtml::listDataEx(TimeSlots::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'ts_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Schedule'),array('class'=>'btn'));
$this->endWidget();
?></div>
</div><!-- form -->
<?php  
        Yii::app()->assetManager->publish( Yii::getPathOfAlias('webroot').'/js-plugin/jquery-ui/jquery-ui-1.8.23.custom.min.js');
      //  Yii::app()->assetManager->publish( Yii::getPathOfAlias('webroot').'/js/jquery.js');
?>
