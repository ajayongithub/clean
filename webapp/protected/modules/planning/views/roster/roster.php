<div class="row mt30">
<div class="span11">
<div id="date" class="span2">
	<?php echo CHtml::dropDownList('schedDate',null,$sdates,array());
		echo CHtml::button('Get Schedules',array('class'=>'btn btn-mini',
											'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('roster/getSchedules'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#schedules', //selector to update
					'data'=>array('schedDate'=>'js:$("#schedDate option:selected").val()'),
					//leave out the data key to pass all form values through
				),
											'id'=>'schedBtn')) ;
	?>
</div>
<div id="schedules" class="span7"></div>
</div>
</div>
<div class="row">
<div id="personnel" class="span7"></div>
</div>
<div class="row">
<div id="reservations" class="span4"></div>
</div>
<?php
	$cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'roster-main-script-1',
  ' 
  	$("#schedBtn").click(function(){
  			$("select.componentSelect").each(function() { 
  			console.log($(this).children("option").filter(":selected").text());
			}); 
  	});
	',
  CClientScript::POS_READY
);
?>