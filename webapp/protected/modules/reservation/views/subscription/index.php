
<?php if(Yum::hasFlash()) {
echo '<div class="success">';
//echo Yum::getFlash(); 
Yum::renderFlash();
echo '</div>';
} 
?>
<div class="row offset1">
<h2><?php echo Yii::t('subscription','Subscription Details');?></h2>
	<div class="span8">
		<table class="table">
			<thead>
				<?php echo '<th>'.Yii::t('subscription','Plan').'</th><th>'.Yii::t('subscription','Start Date').'</th><th>'.Yii::t('subscription','Expires On').'</th><th>'.Yii::t('subscription','Amount').'</th><th>'.Yii::t('subscription','Remarks').'</th>';?>
			</thead>
			<tr>
				<td><?php echo $plan->plan_name?></td>
				<td><?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($subscription->start_date, 'dd-MM-yyyy'),'short',null);?></td>
				<td><?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($subscription->expiry_date, 'dd-MM-yyyy'),'short',null);?></td>
				<td><?php echo number_format($subscription->amount,2); ?></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>