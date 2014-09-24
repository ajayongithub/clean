<div class="row">
 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>Reservations</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>Date</th><th>Reservations</th></thead>
    			<?php foreach($reserves as $reserv ){
    				echo "<tr><td>".$reserv['sched_date']."</td><td>".$reserv['numbers']."</td></tr>" ;
    			}
    			?>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  	
  	 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>Schedules</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>Date</th><th>Locations</th></thead>
    			<?php foreach($schedules as $sched ){
    				echo "<tr><td>".$sched['sched_date']."</td><td>".$sched['numbers']."</td></tr>" ;
    			}
    			?>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  	
  	 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>Company wise users</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>Company</th><th>No Of Users</th></thead>
    			<?php foreach($companies as $company ){
    				echo "<tr><td>".$company['company_name']."</td><td>".$company['numbers']."</td></tr>" ;
    			}
    			?>
    		</table>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  </div>	
  <div class="row">	
  	 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>City wise users</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>City</th><th>No Of Users</th></thead>
    			<?php foreach($cityUsers as $city ){
    				echo "<tr><td>".$city['city_name']."</td><td>".$city['numbers']."</td></tr>" ;
    			}
    			?>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  	 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>Users (<?php echo $userCount; ?>)</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>Name</th><th>Email</th></thead>
    			
    			<?php foreach($users as $user ){
    				echo "<tr><td>".$user['username']."</td><td>".$user['email']."</td></tr>" ;
    			}
    			?>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  	 <div class="span3 mt15 boxWrapper" >
    	<div class="boxContent color1">
    		<div class="color4"><h3>Last 5 Payments</h3></div>
    <article class="" style="overflow:auto;height:200px">
    	<section >
    		<table class="table table-condensed">
    			<thead><th>Order</th><th>Type</th><th>Amount</th></thead>
    			<?php foreach($payments as $paid ){
    				echo "<tr><td>".$paid['order']."</td><td>".$paid['type']."</td><td>".number_format($paid['amt'],2)."</td></tr>" ;
    			}
    			?>
    		</table>
    		</section>
  	</article>  
  	</div></div>
  	</div>