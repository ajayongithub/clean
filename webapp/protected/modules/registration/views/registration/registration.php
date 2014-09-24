<h2> Sign Up</h2>

  
<?php $this->breadcrumbs = array(Yum::t('Registration')); ?>
	 
<div class="form">
<?php $activeform = $this->beginWidget('CActiveForm', array(
            'id'=>'registration-form',
			             'enableAjaxValidation'=>false,
			             'focus'=>array($form,'username'),
             ));
?>
																		  
	<?php echo Yum::requiredFieldNote(); ?>
	<?php echo CHtml::errorSummary($profile); ?>
																				 
 <div class="row"> 
 <div class='span12'>
	 <div class='span3'>
		 <?php echo $activeform->labelEx($profile,'firstname');
							 echo $activeform->textField($profile,'firstname');?>
		
		 <?php echo $activeform->labelEx($profile,'initials');
					 echo $activeform->textField($profile,'initials'); ?>			
		
		 <?php echo $activeform->labelEx($profile,'lastname');
				   echo $activeform->textField($profile,'lastname'); ?>			
		</div>																										  
	 <div class='span3'>
		 <?php echo $activeform->labelEx($profile,'street');
							 echo $activeform->textField($profile,'street');?>
		
		 <?php echo $activeform->labelEx($profile,'city');
					 echo $activeform->textField($profile,'city'); ?>			
		
		 <?php echo $activeform->labelEx($profile,'address_zipcode');
				   echo $activeform->textField($profile,'address_zipcode'); ?>			
		</div>																										  
 		<div class="span3">
 			<?php echo $activeform->labelEx($profile,'telephone_work');
					 echo $activeform->textField($profile,'telephone_work'); ?> 

		  <?php echo $activeform->labelEx($profile,'telephone_private');
			 echo $activeform->textField($profile,'telephone_private'); 
										 echo $activeform->labelEx($profile,'email');
										 echo $activeform->textField($profile,'email');
										 ?> 
		 </div>

 </div>
 </div>
 <hr/>

 <div class='row'>
 <div class='span12'>
 <div class="span3"> 
		<?php echo $activeform->labelEx($form,'password'); ?>
		<?php echo $activeform->passwordField($form,'password'); ?>
		<?php echo $activeform->labelEx($form,'verifyPassword'); ?>
		<?php echo $activeform->passwordField($form,'verifyPassword'); ?>
  </div>  
																										  
																											 
 <div class='span3'>
		<?php echo $activeform->labelEx($profile,'company_name'); ?>
		<?php echo $activeform->textField($profile,'company_name'); ?>
		<?php echo $activeform->labelEx($profile,'company_address'); ?>
		<?php echo $activeform->textField($profile,'company_address'); ?>
		<?php echo $activeform->labelEx($profile,'company_zipcode'); ?>
		<?php echo $activeform->textField($profile,'company_zipcode'); ?>
		<?php echo $activeform->labelEx($profile,'company_city'); ?>
		<?php echo $activeform->textField($profile,'company_city'); ?>
 </div>
 <div class='span3'>
		<?php echo 'Number Plate'; //$activeform->labelEx($form,'username'); ?>
		<?php echo $activeform->textField($form,'username'); ?>
		<?php echo $activeform->labelEx($profile,'car_make'); ?>
		<?php echo $activeform->textField($profile,'car_make'); ?>
		<?php echo $activeform->labelEx($profile,'car_model'); ?>
		<?php echo $activeform->textField($profile,'car_model'); ?>
		<?php echo $activeform->labelEx($profile,'car_color'); ?>
		<?php echo $activeform->textField($profile,'car_color'); ?>
		<?php echo $activeform->labelEx($profile,'car_type'); ?>
		<?php echo $activeform->checkBox($profile,'car_type',array('uncheckValue'=>NULL)); ?>
		<?php echo $activeform->labelEx($profile,'car_lease_company'); ?>
		<?php echo $activeform->textField($profile,'car_lease_company'); ?>
 </div>
 </div>
 </div>
<div class='row'>
<div class='span12'>
 <div class='span3'>
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
					    <?php echo CHtml::submitButton(Yum::t('Registration')); ?>
		</div>
	</div>
	</div>
	</div>
																									 
<?php $this->endWidget(); ?>
