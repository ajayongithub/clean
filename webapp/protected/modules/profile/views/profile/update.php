<?php 
$this->pageTitle = Yum::t( "Profile");
$this->breadcrumbs=array(
		Yum::t('Edit profile'));
$this->title = Yum::t('Edit profile');
?>

<div class="form">

<?php echo CHtml::beginForm(); ?>

<?php echo Yum::requiredFieldNote(); ?>

<?php echo CHtml::errorSummary(array($user, $profile)); ?>

<?php if(Yum::module()->loginType & 1) { ?>
<div class="row">
<?php //echo CHtml::activeLabelEx($user,'username'); ?>
<?php //echo CHtml::activeTextField($user,'username',array(
			//'size'=>20,'maxlength'=>20)); ?>
<?php //echo CHtml::error($user,'username'); ?>
</div>
<?php } ?> 

<?php if(isset($profile) && is_object($profile)) {
	// have got the entire _form here in order to restrict the 
	// fields updateable by the user.
	// $this->renderPartial('/profile/_form', array('profile' => $profile)); 
	$updateableFields = array('email','telephone_work','company_name','company_address','company_address','company_zipcode','company_city');	
	if(Yum::module()->rtepath != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);                                                                         
	if(Yum::module()->rteadapter != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter); 

	if($profile)
	foreach($profile->loadProfileFields() as $field) {
	  if(in_array($field->varname,$updateableFields)){
		echo CHtml::openTag('div',array('class'=>'row'));

		if($field->hint)
			echo CHtml::tag('div',array('class'=>'hint'),$field->hint,true);

		echo CHtml::activeLabelEx($profile, $field->varname);
		if ($field->field_type=='BOOLEAN') {
			echo CHtml::activeCheckBox($profile, $field->varname);
		} else
			if ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,
					$field->varname,
					array('rows'=>6, 'cols'=>50));
		} 
		else if($field->field_type == "DROPDOWNLIST") {
			echo CHtml::activeDropDownList($profile,
					$field->varname, 
					CHtml::listData(CActiveRecord::model(ucfirst($field->varname))->findAll(),
						'id',
						$field->related_field_name));
	
		} else {
			echo CHtml::activeTextField($profile,
					$field->varname,
					array('size'=>(($field->field_size_min)?$field->field_size_min:25),'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo CHtml::error($profile,$field->varname); 
	
		echo CHtml::closeTag('div');
	}//check for updateable fields
	}//for loop for profile fields
	}	
	?>

	<div class="row buttons">
	<?
/*
	if(Yum::module('profile')->enablePrivacySetting)
		echo CHtml::button(Yum::t('Privacy settings'), array(
					'submit' => array('/profile/privacy/update')));
*/					
		?>

	<?php 
	/*
		if(Yum::hasModule('avatar'))
			echo CHtml::button(Yum::t('Upload avatar Image'), array(
				'submit' => array('/avatar/avatar/editAvatar')));*/ ?>

	<?php echo CHtml::submitButton($user->isNewRecord 
			? Yum::t('Create my profile') 
			: Yum::t('Save profile changes')); ?>
	</div>

	<?php echo CHtml::endForm(); ?>

	</div><!-- form -->
