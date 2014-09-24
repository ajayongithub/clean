
<?php if(Yum::hasFlash()) {
echo '<div class="success">';
//echo Yum::getFlash(); 
Yum::renderFlash();
echo '</div>';
} 
?>
<div class="row offset1">
<h2>Payment Details</h2>
	<div class="span8">
		<table class="table">
			<thead>
				<th>Plan</th><th>Order Num</th><th>Payment Date</th><th>Payment Type</th><th>Status</th>
			</thead>
			<tr>
				<td><?php echo $plan->plan_name?></td><td><?php echo $order->id;?></td><td><?php echo $payment->payment_issue_date; ?></td>
				<td><?php echo $payment->payment_type; ?></td><td><?php echo $payment->status; ?></td>
				
			</tr>
		</table>
	</div>
</div>
