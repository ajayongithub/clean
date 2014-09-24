<div class="form">


<?php 
$formAction = (strcmp($this->action->id,'update')==0)?'update/id/'.$model->id:'create';
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'invites-form',
	'enableAjaxValidation' => FALSE,
	'action'=>Yii::app()->createUrl('/common/invites/').'/'.$formAction
));
?>
<div class="bulle">
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">

		<?php //echo $form->labelEx($model,'cre_date'); ?>
		<?php 
			$date = new DateTime('now');
			$cre_date = $date->add(new DateInterval('P60D'))->format('Y-m-d H:i:s');
		echo $form->hiddenField($model, 'cre_date',array('value'=>$cre_date,'readonly'=>'readonly')); ?>
		<?php //echo $form->error($model,'cre_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'company_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model, 'lastname', array('maxlength' => 128)); ?>
		<?php echo $form->error($model,'lastname'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'remarks'); ?>
		<?php echo $form->textField($model, 'remarks', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'remarks'); ?>
		</div><!-- row -->


<?php
$btnLabel = (strcmp($this->action->id,'update')==0)?Yii::t('app','Update'):Yii::t('app','Create');
echo GxHtml::submitButton($btnLabel,array('class'=>'btn'));
$this->endWidget();
?></div>
</div><!-- form -->
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'ls-validation-script',
  ' 
	$("#invites-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"Invites[email]":{
					email:true	
				}
			},
		}
	);
	
	
	 ',
  CClientScript::POS_END
);
?>