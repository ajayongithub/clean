<div class="form">


<?php 
$formAction = (strcmp($this->action->id,'update')==0)?'update/id/'.$model->id:'create';
	$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'company-location-form',
	'enableAjaxValidation' => false,
	'action'=>Yii::app()->createUrl('/common/companyLocation/').'/'.$formAction
));
?>
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="bulle">
		<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'company_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'location_id'); ?>
		<?php echo $form->dropDownList($model, 'location_id', GxHtml::listDataEx(MasterLocations::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'location_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textField($model, 'remark', array('maxlength' => 512)); ?>
		<?php echo $form->error($model,'remark'); ?>
		</div><!-- row -->


<?php
$btnLabel = (strcmp($this->action->id,'update')==0)?Yii::t('app','Update'):Yii::t('app','Create');
echo GxHtml::submitButton($btnLabel,array('class'=>'btn'));
$this->endWidget();
?>
</div><!-- bulle -->
</div><!-- form -->
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'cl-validation-script',
  ' 
	$("#company-location-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"CompanyLocation[company_id]":{
				remote: {
					url: "'.Yii::app()->createAbsoluteUrl('/common/companyLocation/checkUnique').'",
					type: "post",
					data: {
						"CompanyLocation[location_id]":function(){
									return $("#CompanyLocation_location_id option:selected").val();
								}
					},
					complete:function(data){
						if(data.responseText!="true")
							alert("Company and Location already exist, please choose another one.");
					}
				}
			},
			"CompanyLocation[location_id]":{
			
				remote: {
					url: "'.Yii::app()->createAbsoluteUrl('/common/companyLocation/checkUnique').'",
					type: "post",
					data: {
						"CompanyLocation[company_id]":function(){
									return $("#CompanyLocation_company_id option:selected").val();
								}
					},
					complete:function(data){
						if(data.responseText!="true")
							alert("Company and Location already exist, please choose another one.");
					}
				}
			},
		}
	});
	
	
	 ',
  CClientScript::POS_END
);
?>