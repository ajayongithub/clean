<div class="form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'master-locations-form',
	'enableAjaxValidation' => false,
	'action'=> Yii::app()->createUrl('/common/masterLocations/create') 
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="bulle">
		<div class="row">
		<?php echo $form->labelEx($model,'location_address'); ?>
		<?php echo $form->textField($model, 'location_address', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'location_address'); ?>
		</div><!-- row -->
		<div class="row">
		<?php //echo $form->labelEx($model,'location_no'); ?>
		<?php //echo $form->textField($model, 'location_no', array('maxlength' => 32)); ?>
		<?php //echo $form->error($model,'location_no'); ?>
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
</div>
<?php
$btnLabel = (strcmp($this->action->id,'update')==0)?Yii::t('app','Update'):Yii::t('app','Create');
echo GxHtml::submitButton($btnLabel,array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- form -->
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'ml-validation-script',
  ' 
	$("#master-locations-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"MasterLocations[location_address]":{
				required:true
			},
			//"MasterLocations[location_no]":{
			//	required:true,
			//	number:true,
			//	minlength:2
			//},
			"MasterLocations[location_zipcode]":{
				required:true,
				nl_zipCode:true,
			},
			"MasterLocations[location_city]":{
				required:true
			}
		}
	});
	
	
	 ',
  CClientScript::POS_END
);
?>