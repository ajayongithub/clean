<div class="form">


<?php
$formAction = (strcmp($this->action->id,'update')==0)?'update/id/'.$model->id:'create';
$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'location-schedule-form',
	'enableAjaxValidation' => true,
	'action'=>Yii::app()->createUrl('/common/locationSchedule/').'/'.$formAction
));
?>

<div class="bulle">
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>
		<div class="row ">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownList($model, 'company_id', GxHtml::listDataEx(Company::model()->findAllAttributes(null, true)),array('prompt'=>'--Select a Company--')); ?>
		<?php echo $form->error($model,'company_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'loc_id'); ?>
		<?php echo $form->dropDownList($model, 'loc_id',array(),array('prompt'=>'--Select a Location--') ); ?>
		<?php echo $form->error($model,'loc_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'sched_date'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'sched_date',
			'value' => $model->sched_date,
			'options' => array(
				'showButtonPanel' => true,
					'changeMonth' => true,
				'changeYear' => true,
				'minDate'=>'1d',
				'dateFormat' => 'yy/mm/dd',
				),
			));
; ?>
		<?php echo $form->error($model,'sched_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ts_id'); ?>
		<?php echo $form->dropDownList($model, 'ts_id', GxHtml::listDataEx(TimeSlots::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'ts_id'); ?>
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
	$("#location-schedule-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"LocationSchedule[sched_date]":{
				required:true
			},
			"LocationSchedule[company_id]":{
				required:true
			},
			"LocationSchedule[loc_id]":{
				required:true
			},
		}
	});
	$("select#LocationSchedule_company_id").change(function(){
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
      				$("select#LocationSchedule_loc_id").html(options);
    			}
			})
			});
	
	
	 ',
  CClientScript::POS_END
);
?>