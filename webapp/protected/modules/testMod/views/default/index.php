<?php
	echo $cont ;
	?>

<?php $repeat = array(''=>'All','1'=>'First','2'=>'Second','3'=>'Third','4'=>'Fourth','5'=>'Fifth');
	echo CHtml::dropDownList('repeat','',$repeat);
?>
<?php $daysModel = array('MO'=>'Monday','TU'=>'Tuesday','WE'=>'Wednesday','TH'=>'Thursday','FR'=>'Friday','SA'=>'Saturday','SU'=>'Sunday');
	echo CHtml::dropDownList('day','MO',$daysModel);
?>

<?php echo CHtml::button('Add Rule',array('id'=>'addRule'));?>
<script>
var indx = 0 ;
$("document").ready(function(){
$('#addRule').click(function(){
		$('<input>').attr({
    type: 'hidden',
		    id: 'rule['+indx+']',
				    name: 'rule['+']',
						value: $('#repeat').val()+$('#day').val() 
						}).appendTo('#form');
						indx++;
var str = '<em>'+$('#repeat option:selected').text() + '</em>  <em>'+$('#day option:selected').text()+'</em> <p/>' ;
$('#ruleDispl').append(str);
						});

						});
						</script>
<form id='dynForm' action='testMod/default/getList' method='POST'>
 <div id='form'>
 <div id='ruleDispl'>
 </div>
 <p>
<?php
			 echo CHtml::ajaxSubmitButton('GetPreview',Yii::app()->createUrl('testMod/default/getList'), array( 'type'=>'POST','success'=>'js:function(string){ $("#resp").empty() ; $("#resp").append(string); }' ),array());
			 ?>
			 </p>
 </div>
 </form>
 <div id='resp'>
 </div>
 <div class='mb30'>
<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'company-location-form',
	'enableAjaxValidation' => false,
));
?>
 <?php 

 $form->widget('zii.widgets.jui.CJuiDatePicker', array(
 			'flat'=>true,
		//	'model' => $model,
			'attribute' => 'start_date',
		//	'value' => $model->start_date,
			'name'=>'dateSelect',
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));?>
 </div>
 <?php $this->endWidget();?>