	<h3>Schedules for $sDate</h3>
	<table>
	<thead>
	<th>Company </th><th>Location </th><th>Time Slot </th>
	</thead>
<?php
	foreach($schedules as $schedule){
		echo '<tr><td>'.$schedule->company_id.'</td><td>'.$schedule->location_id.'</td><td>'.$schedule->ts_id.'</td></tr>' ;
		
	}
?>
	</table>