<div class='row-fluid span12'>
<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
<a></a>
<div class="span3">
<div class="bulle ">
<form id="time-slots-form" action="/common/timeSlots/create" method="POST">
<?php 

	echo 'Name:'.CHtml::textField('TimeSlots[slot_name]','',array());
	echo "Begin :".CHtml::textField('TimeSlots[slot_begin]','',array());
	echo "End :".CHtml::textField('TimeSlots[slot_end]','',array());
	echo "Remarks :".CHtml::textField('TimeSlots[remarks]','',array());
	
?>
<input type="submit" value="Create" class="btn"/>
</form>
</div>
</div>
<div class="span8">
<form method="POST">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'time-slots-grid',
	'dataProvider' => $model->search(),
	'itemsCssClass'=>'table',
	'pager' => array('class' => 'CLinkPager','htmlOptions'=>array('class'=>'pagination-mini','color'=>'white'),'header'=>'','nextPageCssClass'=>'page',
				'selectedPageCssClass'=>'','internalPageCssClass'=>''),
	'filter' => $model,
	'columns' => array(
//		'id',
		'slot_name',
		'slot_begin',
		'slot_end',
		'remarks',
		array(
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
)); ?></form>
</div>
</div>
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'ts-validation-script',
  ' 
	$("#time-slots-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},
		rules:{
			"TimeSlots[slot_name]":{
				required:true
			},
			"TimeSlots[slot_begin]":{
				required:true,
				timeFormat:true,
				//orderedTimes: true
			},
			"TimeSlots[slot_end]":{
				required:true,
				timeFormat:true,
				//orderedTimes:true
			},
		}
	});
	$.validator.addMethod("orderedTimes",function(value,element){
		console.log(Date.parse($("#TimeSlots_slogs_begin").val()));
		return (Date.parse($("#TimeSlots_slots_begin").val()) < Date.parse($("#TimeSlots_slots_end").val()))?true:false ;
		},"Begin Time Should be less than End Time ");
	
	 ',
  CClientScript::POS_END
);
?>