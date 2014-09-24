<?php
if(isset($cleaners)){
			echo '<div id="schedDiv" >';
			echo "<br/>Schedules for Date:".$schedDate."<br/><hr/>";
			foreach($cleaners as $id=>$cleaner){
				
				echo '<br/>'.LocationSchedule::getScheduleDetails($id) ;
				echo "<br/>Cleaners : ";
				if(isset($cleaners[$id])){
					foreach($cleaners[$id] as $clnr){
						echo Employees::getEmployeeName($clnr).',' ;
					}
				}
				if(isset($extras[$id])){
					echo '<br/>Extra Cleaner :'.Employees::getEmployeeName($extras[$id]) ;
				}
				if(isset($teamLead[$id])){
					echo '<br/>Team Lead  :'.Employees::getEmployeeName($teamLead[$id]) ;
				}
				if(isset($cars[$id])){
				foreach($cars[$id] as $car){
						echo CleaningCars::getCarNumber($car).',' ;
					}
				}

			}//<link rel=\"stylesheet\" href=\"mystyle.css\" />  kept for later use in myStyle 
			echo '</div><br/>'.CHtml::button(Yum::t('Print'),
							    		array('class'=>'btn','onClick'=>'
    									w=window.open(null, "Print_Page", "scrollbars=yes");
    									var content = "<html><head>";
    									var myStyle = "";
    									content += myStyle;
    									content +="</head>"
    									content+=$("#schedDiv").html()+"</html></body>";
    									w.document.write(content);
    									w.document.close();
    									w.print();'));
		}
		?>