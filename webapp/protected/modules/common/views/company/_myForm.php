<div class="form">


<?php
$formAction = (strcmp($this->action->id,'update')==0)?'update/id/'.$model->id:'create';
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'company-form',
	'enableAjaxValidation' => false,
'action'=>Yii::app()->createUrl('/common/company/').'/'.$formAction
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>
<div class="bulle">
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
		<?php //echo $form->labelEx($model,'ho_number'); ?>
		<?php //echo $form->textField($model, 'ho_number', array('maxlength' => 128)); ?>
		<?php //echo $form->error($model,'ho_number'); ?>
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
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->


<?php
$btnLabel = (strcmp($this->action->id,'update')==0)?Yii::t('app','Update'):Yii::t('app','Create');
echo GxHtml::submitButton($btnLabel,array('class'=>'btn'));
$this->endWidget();
?>
</div></div><!-- form -->

<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'company-validation-script',
  ' 
	$("#company-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"Company[company_name]":{
				required:true
			},
			"Company[ho_street]":{
				required:true
			},
			"Company[ho_number]":{
				required:true,
				number:true,
				minlength:2
			},
			"Company[ho_zipcode]":{
				required:true,
				nl_zipCode:true,
			},
			"Company[ho_city]":{
				required:true
			},
			"Company[contact_firstname]":{
				required:true
			},
			"Company[contact_init]":{
				required:false
			},
			"Company[contact_lastname]":{
				required:true
			},
			"Company[contact_email]":{
				required:true,
				email:true
			},
			
		}
	});
	
	
	 ',
  CClientScript::POS_END
);
?>