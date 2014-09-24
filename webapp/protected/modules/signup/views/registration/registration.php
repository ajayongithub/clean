<div class="container">
<div class="row">
<div class="span11 bulle">
<h2><?php echo Yum::t('Sign up');?></h2>

	 
<div class="form">
<?php $activeform = $this->beginWidget('CActiveForm', array(
            'id'=>'registration-form',
			             'enableAjaxValidation'=>false,
			             'focus'=>array($form,'firstname'),
             ));
?>
																		  
	<?php echo Yum::requiredFieldNote(); ?>
																				 
<?php echo CHtml::errorSummary($form); ?>
<?php echo CHtml::errorSummary($profile); ?>
<table class="table">
<caption><?php echo Yum::t('Please Enter your personal details here');?>
</caption>

<tr>
	<td>
		<?php echo $activeform->labelEx($profile,'firstname');
		  echo $activeform->textField($profile,'firstname',array('class'=>'required'));?>
	</td>
	<td >
		 <?php echo $activeform->labelEx($profile,'lastname');
			   echo $activeform->textField($profile,'lastname',array('class'=>'required')); ?>			
		 <?php //echo $activeform->labelEx($profile,'initials');
			 //echo $activeform->textField($profile,'initials'); ?>			
	</td>
	<td >
	</td>
</tr>
<tr>
	<td>
		<?php echo $activeform->labelEx($form,'username'); ?>
		<?php echo $activeform->textField($form,'username',array('class'=>'required')); ?>
	</td>
	<td>
		<?php echo $activeform->labelEx($form,'password'); ?>
		<?php echo $activeform->passwordField($form,'password',array('class'=>'required')); ?>
	</td>
	<td>
		<?php echo $activeform->labelEx($form,'verifyPassword'); ?>
		<?php echo $activeform->passwordField($form,'verifyPassword',array('class'=>'required')); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo $activeform->labelEx($profile,'email');?>
		<?php echo $activeform->textField($profile,'email',array('class'=>'required'));?>
	</td>
	<td>
		 <?php echo $activeform->labelEx($profile,'street');
			 echo $activeform->textField($profile,'street',array('class'=>'required'));?>
	</td>
	<td>
		 <?php echo $activeform->labelEx($profile,'address_zipcode');
		   echo $activeform->textField($profile,'address_zipcode',array('class'=>'required')); ?>			
	</td>

</tr>
<tr>
	<td>
		 <?php echo $activeform->labelEx($profile,'city');
			 echo $activeform->textField($profile,'city',array('class'=>'required')); ?>			
	</td>
	<td>
		<?php echo $activeform->labelEx($profile,'telephone_work');
			 echo $activeform->textField($profile,'telephone_work',array('class'=>'required')); ?> 
	</td>
	<td>
		<?php echo $activeform->labelEx($profile,'country');
		 echo $activeform->dropDownList($profile,'country',array('Netherlands'=>'Netherlands'),array('class'=>'required')); ?> 
	</td>
</tr>
<tr>
	<td>
		<?php echo $activeform->labelEx($profile,'company_id'); ?>
		<?php if($companies!=null)
		
			echo $activeform->dropDownList($profile,'company_id',$companies,array('class'=>'required'));
			else
				echo $activeform->dropDownList($profile, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),array('prompt'=>'--Select a Company--','class'=>'required'));
			?>
	</td>
	<td>
		<?php echo $activeform->labelEx($profile,'location_id'); ?>
		<?php if($locations!=null) echo $activeform->dropDownList($profile,'location_id',$locations,array('class'=>'required'));
				else echo $activeform->dropDownList($profile, 'location_id',array(),array('prompt'=>'--Select a Location--','class'=>'required') );
		?>
	</td>
</tr>
</table>																				 
																				 
<div class='row'>
<div class='span12'>
 <div class='span6'>
<?php if(extension_loaded('gd') 
			&& Yum::module('registration')->enableCaptcha): ?>
		<?php echo CHtml::activeLabelEx($form,'verifyCode'); ?>
		<?php $this->widget('CCaptcha'); ?>
		<p class="hint">
		<?php echo Yum::t('Please enter the letters as they are shown in the image above.'); ?>
		<br/><?php echo Yum::t('Letters are not case-sensitive.'); ?></p>
		<?php echo CHtml::activeTextField($form,'verifyCode'); ?>
	<?php endif; ?>
	<div class="submit">
					    <?php echo CHtml::submitButton(Yum::t('Register'),array('class'=>'btn')); ?>
		</div>
	</div>
	</div>
	</div>
																									 
<?php $this->endWidget(); ?>
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-validation-script',
  ' 
	$("#registration-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"YumProfile[email]":{
				required:true,
				email:true,
				remote:{
					url:"'.Yii::app()->createAbsoluteUrl('/signup/registration/checkEmail').'",
					type:"post",
					complete:function(data){
						if(data.responseText!="true")
							alert("'.Yii::t("signup","Email is already subscribed").'");
					}
				}
		},
			"YumRegistrationForm[username]":{
				required:true,
				remote:{
					url:"'.Yii::app()->createAbsoluteUrl('/signup/registration/checkUsername').'",
					type:"post",
					complete:function(data){
						if(data.responseText!="true")
							alert("'.Yii::t("signup","Username already taken, please choose another one").'");
					}
					
				}
		}
		
		
		}
	});
		$("select#YumProfile_company_id").change(function(){
	$.ajax ({ 
				type: "POST", 
				url: "'.Yii::app()->createUrl('/common/locationSchedule/getLocationsForCompany').'",
				data: {"companyId":$(this).val()},
				cache: false,
				success:function(j){
      				var options = "";
      				var arr = $.parseJSON(j);
      				for (var i = 0; i < arr.length; i++) {
      					var obj = arr[i];
        				options += "<option value=\"" + obj.location_id + "\">" + obj.location_address + "</option>";
      				}
      				$("select#YumProfile_location_id").html(options);
    			}
			})
			});
	 ',
  CClientScript::POS_END
);
?>
</div>	
</div>	
</div>	
