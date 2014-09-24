<?php
if(strcmp($status,'success')==0){ 
?>
	<h4><?php echo Yii::t('subscription','Your order no orderNo has been successfully processed',array('orderNo'=>$order));?></h4>
	<h5><?php echo Yii::t('subscription','You can now start making reservations, if you have completed your profile');?></h5>
<?php
}else if(strcmp($status,'decline')==0){
?>
	<h4><?php echo Yii::t('subscription','Your order no orderNo has been declined',array('orderNo'=>$order));?></h4>
	<h5><?php echo Yii::t('subscription','Please try the mandate option to complete your subscription');?></h5>
	
<?php
}else if(strcmp($status,'exception')==0){
?>
	<h4><?php echo Yii::t('subscription','Your order no orderNo has met with an exception',array('orderNo'=>$order));?></h4>
	<h5><?php echo Yii::t('subscription','Please verify with your bank if the transaction has been completed and let us know');?></h5>
<?php
}else if(strcmp($status,'cancel')==0){
	
?>
	<h4><?php echo Yii::t('subscription','Your order no orderNo has been cancelled',array('orderNo'=>$order));?></h4>
	<h5><?php echo Yii::t('subscription','Please try again');?></h5>
<?php
}else{
?>
	<h4><?php echo Yii::t('subscription','Your order no orderNo could not be processed',array('orderNo'=>$order));?></h4>
	<h5><?php echo Yii::t('subscription','Please try again');?></h5>
<?php }?>