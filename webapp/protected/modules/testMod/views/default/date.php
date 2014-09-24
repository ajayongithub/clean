<div class='container'>
<div class='row-fluid'>
<div class='span10 mt30' >
 
'This is the div'
<?php 
	
	

?>
 <?php 

 $this->widget('zii.widgets.jui.CJuiDatePicker', array(
 			'flat'=>FALSE,
		//	'model' => $model,
			'attribute' => 'start_date',
		//	'value' => $model->start_date,
			'name'=>'dateSelect',
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
 				'onSelect'=>'js:function(){console.log("selected");}'
				),
			));?>
 'end of div'
 </div>
 </div>
 <div>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 <input name="abcd"/>
 </div>
 </div>