	<h3>Reservations </h3>
	<div id="schedDiv">
	<table>
	<thead>
	<th>UserId </th><th>Schedule Id </th><th>Status Slot </th><th>Reserved On</th>
	</thead>
<?php
	foreach($reservations as $reservation){
		echo '<tr><td>'.$reservation["user_id"].'</td><td>'.$reservation["schedule_id"].'</td><td>'.$reservation["status"].'</td>
				<td>'.$reservation["reserved_on"].'</td></tr>' ;
		
	}
?>
	</table>
	<?php echo CHtml::button('Get Perosnnel',array('class'=>"btn btn-mini",
													'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('roster/getReservations'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#reservations', //selector to update
					'data'=>array('scheds'=>'js:$("#schedDiv input:checkbox:checked").serialize()'),
					//leave out the data key to pass all form values through
				),
											'id'=>'reservBtn')) ;
														?>
</div>