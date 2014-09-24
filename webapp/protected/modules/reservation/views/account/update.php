<?php if(Yum::hasFlash()) {
echo '<div class="success">';
//echo Yum::getFlash(); 
Yum::renderFlash();
echo '</div>';
} 
?>

<?php echo CHtml::errorSummary(array($user, $profile)); ?>



    		<H2><?php echo Yii::t('account','Personal Data');?></H2>
    		<form id="pers-profile" method="post" >
    	<div class="span4 bulle" id="home">
    			<?php echo CHtml::activeLabelEx($profile,'street');
    				echo CHtml::activeTextField($profile, 'street', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'street');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'city');
    				echo CHtml::activeTextField($profile, 'city', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'city');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'address_zipcode');
    				echo CHtml::activeTextField($profile, 'address_zipcode', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'address_zipcode');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'telephone_work');
    				echo CHtml::activeTextField($profile, 'telephone_work', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'telephone_work');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'company_id');
    				echo CHtml::activeDropDownList($profile, 'company_id',$companyData ,array());
					echo CHtml::error($profile,'company_id');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'location_id');
    				echo CHtml::activeDropDownList($profile, 'location_id',$locationData ,array());
					echo CHtml::error($profile,'location_id');
					?>
  <?php echo CHtml::submitButton($user->isNewRecord 
						? Yum::t('Create my profile') 
						: Yum::t('Save Profile Changes'),array('class'=>'btn')); ?>
    	</div>
    	<div class="span4 bulle" id="car">
    	<?php 
    				echo '<label class="required" for="YumProfile_car_make">'.Yum::t("Car Make").'<span class="required">*</span></label>';
    				echo CHtml::activeTextField($profile, 'car_make', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'car_make');
					?>
    			<?php 
    				echo '<label class="required" for="YumProfile_car_model">'.Yum::t("Car Model").'<span class="required">*</span></label>';
    				echo CHtml::activeTextField($profile, 'car_model', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'car_model');
					?>
    			<?php 
    				echo '<label class="required" for="YumProfile_car_color">'.Yum::t("Car Color").'<span class="required">*</span></label>';
    				echo CHtml::activeTextField($profile, 'car_color', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'car_color');
					?>
    			<?php 
    				echo '<label class="required" for="YumProfile_car_number_plate">'.Yum::t("Car Number Plate").'<span class="required">*</span></label>';
    				echo CHtml::activeTextField($profile, 'car_number_plate', array('size'=>32,'maxlength'=>255,));
					echo CHtml::error($profile,'car_number_plate');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'car_type');
    				echo CHtml::activeDropDownList($profile, 'car_type',array('0'=>Yum::t('Leased'),'1'=>Yum::t('Private')) ,array());
					echo CHtml::error($profile,'car_type');
					?>
    			<?php echo CHtml::activeLabelEx($profile,'car_lease_company');
    				echo CHtml::activeTextField($profile, 'car_lease_company',array());
					echo CHtml::error($profile,'car_lease_company');
					?>
    	</div>
    		</form>
    	<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-validation-script',
  ' 
	$("#pers-profile").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"YumProfile[street]":{ required:true},
			"YumProfile[city]": { required:true},
			"YumProfile[address_zipcode]": { required:true},
			"YumProfile[company_id]": { required:true},
			"YumProfile[location_id]": { required:true}
				}
		}
	);
	 ',
  CClientScript::POS_END
);
?>