	
	
<?php $activeform = $this->beginWidget('CActiveForm', array(
            'id'=>'roster-form','action'=>'saveRoster',
			             'enableAjaxValidation'=>false,
			            
             ));
?>
	<div id="schedDiv">
<h3>Schedules for <?php echo $sDate; ?></h3>
<?php echo CHtml::hiddenField('schedDate',$sDate) ;?>

	<table class="table  table-hover">
	<thead>
	<th><a>City</a> </th><th><a>Company</a></th><th><a>Location</a> </th><th><a>Time Slot</a> </th>
	</thead>

<?php
	foreach($schedules as $schedule){
		echo '<tr><td>'.$schedule["location_city"].'</td><td>'.$schedule["company_name"].'</td><td>'.$schedule["location_address"].'</td><td>'.$schedule["slot_name"].'</td></tr>' ;
		$bookings = $reserv[$schedule['id']];
			echo '<tr><td colspan="4">';
			echo '<table class="table-bordered table-condensed ">';
		foreach($bookings as $booking){
			$userDetail = $profiles[$booking->id] ;
			echo '<tr>' ;
			echo '<td>';
			echo  $userDetail->firstname .' '.$userDetail->initials.' '.$userDetail->lastname;
			echo '</td>' ;
			echo '<td>';
			echo  $userDetail->telephone_work;
			echo '</td>' ;
			echo '<td>';
			echo  $userDetail->car_make.' '.$userDetail->car_model.' '.$userDetail->car_color.' '.$userDetail->car_number_plate;
			echo '</td>' ;
			echo '<td>';
			echo  Plans::$service_type[$booking->service_type];
			echo '</td>' ;
			echo "</tr>" ;
		}
		echo '</table>';
		echo '</td></tr>';
		echo '<tr><td>Cleaners:<br/>';
		if(isset( $scheduled[$schedule['id']])){
			$sCleaners = $scheduled[$schedule['id']];
	//		$models = Employees::model()->findAllByAttributes(array('emp_base_location'=>$schedule['location_city']));
			//$models = Employees::model()->findAll();//ByAttributes(array('emp_base_location'=>$schedule['location_city']));
			$models = Employees::model()->findAllByAttributes(array('emp_designation'=>'Cleaner'));
			$leads = Employees::model()->findAllByAttributes(array('emp_designation'=>'Team Leader'));
			$listData = CHtml::listData($models,'id','fullName');
			$leadsList = CHtml::listData($leads,'id','fullName');
			$cIndex = 0 ;
			foreach($sCleaners as $cleaner){
				echo CHtml::dropDownList('schd['.$schedule['id'].']['.$cIndex++.']',$cleaner,$listData);
			}
		}else echo 'No Cleaners found' ; 
		echo '  </td>';
		echo '<td>Additional Cleaner<br/>'. CHtml::dropDownList('extra['.$schedule['id'].']',null,$listData,array('prompt'=>'--Extra Cleaner--')).'</td>';
				
		echo '<td>Team Leader <br/>'. CHtml::dropDownList('teamLead['.$schedule['id'].']',null,$leadsList,array('prompt'=>'--Team Leader --')).'</td>';
		echo '<td>Cars:'.' <br/>';
		$displayListData = CleaningCars::model()->findAll();
		$displayList = CHtml::listData($displayListData,'id','number_plate') ;
		if(isset($vehicles[$schedule['id']])){
			$listOfCars = $vehicles[$schedule['id']] ;
			$carIndex = 0 ;
			foreach($listOfCars as $car){
				echo CHtml::dropDownList('cars['.$schedule['id'].']['.$carIndex++.']',$car,$displayList) ;
			}		
			/*for($carIndex = 0 ; $carIndex < count($listOfCars); $carIndex++){
				$car = $listOfCars[$carIndex] ;
				echo "Car number ".$car ;
				echo "Car numbers ".var_dump($displayList) ;
				echo CHtml::dropDownList('car['.$schedule['id'].']['.$carIndex.']',$car,$displayList);
			}*/
			
		}
		echo '</tr>';
	}
?>
	</table>
	<?php /*echo CHtml::button('Get Reservations',array('class'=>"btn btn-mini",
													'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('roster/getReservations'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#reservations', //selector to update
					'data'=>array('scheds'=>'js:$("#schedDiv input:checkbox:checked").serialize()'),
					//leave out the data key to pass all form values through
				),
											'id'=>'reservBtn')) ;*/
														?>
	<?php /*echo CHtml::button('Get Personnel',array('class'=>"btn btn-mini",
													'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('roster/getPersonnel'), //url to call.
					//'url'=>CController::createUrl('roster/generateRoster'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#personnel', //selector to update
					'data'=>array('scheds'=>'js:$("#schedDiv input:checkbox:checked").serialize()'),
					//leave out the data key to pass all form values through
				),
											'id'=>'persButton')) ;*/
														?>
</div>
	<div class="submit">
					    <?php //echo CHtml::submitButton(Yum::t('Save'),array('class'=>'btn','id'=>'saveBtn'));?>
					    <?php echo CHtml::button(Yum::t('Save'),array('class'=>'btn','id'=>'myBtn'));?>
					    <?php echo CHtml::button(Yum::t('Print'),
							    		array('class'=>'btn','id'=>'myPrintBtn','hidden'=>'hidden','onClick'=>'
    									w=window.open(null, "Print_Page", "scrollbars=yes");
    									var content = "<html><head>";
    									var myStyle = "<link rel=\"stylesheet\" href=\"/bootstrap/css/bootstrap.css\" />";
    									content += myStyle;
    									content +="</head>"
    									content+=$("#schedDiv").html()+"</html></body>";
    									w.document.write(content);
    									w.document.close();
    									w.print();
											    ')); ?>
		</div>
<?php $this->endWidget(); ?>
<?php
$action = Yii::app()->createUrl("planning/roster/saveRoster");
	$cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'roster-main-script-2',
  ' 
  	$("#myBtn").click(function(){

	  function replaceDropDowns(){
	  	console.log("Starting replacements");
  		$("#schedDiv select").each(function(){
		  	console.log("Starting counter");
  			var selVal = $(this).children("option").filter(":selected").text();
  			if (selVal.indexOf("--") >= 0) selVal = "--";
  			$(this).replaceWith("<em>"+selVal+"</em>");
  		});
  		}

  		var sendData  =  $("#roster-form").serialize();
  		$.ajax({
			type: "POST",
			 url:"'.$action.'", 
			data:sendData, 
			success:	function(data){
				alert(data.status);
				console.log("After Alert");
				if(data.s==1){
					replaceDropDowns();
					//$("#myPrintBtn").hidden(false);
					////$(this).hide();
				}
				}, 
			dataType: "json"
		});
  	//	replaceDropDowns();	
  	});
	',
  CClientScript::POS_READY
);
?>