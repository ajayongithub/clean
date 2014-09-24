<?
if(Yum::module()->rtepath != false)
Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);                                                                         
if(Yum::module()->rteadapter != false)
Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter); 

if($profile)
foreach($profile->loadProfileFields() as $field) {
	$updateableFields = array('email','telephone_work','bank_account','bank_name',
		'car_make','car_model','car_color','car_number_plate');	

	if(in_array($field->varname,$updateableFields)){
	echo CHtml::openTag('div',array('class'=>'row'));
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
	}else if(strcmp($field->varname,'company_id')==0){
		echo CHtml::openTag('div',array('class'=>'row'));
		echo CHtml::activeLabelEx($profile, $field->varname);
		echo CHtml::activeDropDownList($profile, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),array('prompt'=>'--Select a Company--'));
		echo CHtml::closeTag('div');
	}else if(strcmp($field->varname,'location_id')==0){
		echo CHtml::openTag('div',array('class'=>'row'));
		$locList = CompanyLocation::getLocationsForComapny($profile->company_id);
		echo CHtml::activeLabelEx($profile, $field->varname);
		echo CHtml::activeDropDownList($profile, 'location_id',$locList,array('prompt'=>'--Select a Location--') ); 
		echo CHtml::closeTag('div');
		
	}
}
else 
	echo "Profile is null";
?>
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
							alert("Email is already subscribed.");
					}
				}
		},
			"YumUser[username]":{
				required:true,
				remote:{
					url:"'.Yii::app()->createAbsoluteUrl('/signup/registration/checkUsername').'",
					type:"post",
					complete:function(data){
						if(data.responseText!="true")
							alert("Username already taken, please choose another one.");
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