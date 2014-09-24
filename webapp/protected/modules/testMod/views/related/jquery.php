<div class="mt30">
<?php

echo CHtml::dropDownList('hello',"",array("0"=>'abcd','1'=>'pqrs'),array('id'=>'dropIt')) ;
echo CHtml::button("Do Magic",array('class'=>'btn btn-mini','id'=>'myBtn'));
?></div>
<?php
	$cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'roster-main-script-1',
  ' 
  	$("#myBtn").click(function(){
  		console.log("clicking my button");	
  		var txt = $("#dropIt").children("option").filter(":selected").text();
  		var txt = $("#dropIt option:selected").text();

  		
  		console.log("Selected text is "+txt);
  		$("#dropIt").replaceWith(txt);
  		console.log("Tried to replace hua kya?");
  	});
	',
  CClientScript::POS_READY
);
?>