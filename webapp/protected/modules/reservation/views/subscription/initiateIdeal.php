
<h2><?php echo Yii::t('subscription','Pay via iDeal');?></h2>
<h4><?php echo Yii::t('subscription','By clicking the button you will now be redirected to the iDeal site');?></h4>
<form method="post" action="https://internetkassa.abnamro.nl/ncol/prod/orderstandard.asp" id="form1" name="form1">
<input type="hidden" NAME="PSPID"  value="cleanY" />
<input type="hidden" NAME="orderID" value="<?php echo $order->id ; ?>" />
<input type="hidden" NAME="amount"  value="<?php echo number_format((1+($this->VAT/100))*$plan->plan_cost*11,2); ?>" />
<input type="hidden" name="currency" value="EUR" />
<input type="hidden" name="language" value="NL_NL" />
<input type="hidden" name="accepturl" value="<?php echo Yii::app()->createAbsoluteUrl('/reservation/subscription/idealResponse',array('status'=>'success','order'=>$order->id,'txid'=>$payment->id,  'user'=>$profile->user_id)) ?>"> 
<input type="hidden" name="declineurl" value="<?php echo Yii::app()->createAbsoluteUrl('/reservation/subscription/idealResponse',array('status'=>'decline','order'=>$order->id,'txid'=>$payment->id,'user'=>$profile->user_id)) ?>"> 
<input type="hidden" name="exceptionurl" value="<?php echo Yii::app()->createAbsoluteUrl('/reservation/subscription/idealResponse',array('status'=>'exception','order'=>$order->id,'txid'=>$payment->id,'user'=>$profile->user_id)) ?>"> 
<input type="hidden" name="cancelurl" value="<?php echo Yii::app()->createAbsoluteUrl('/reservation/subscription/idealResponse',array('status'=>'cancel','order'=>$order->id,'txid'=>$payment->id,'user'=>$profile->user_id)) ?>"> 
<input type="hidden" name="backurl" value="<?php echo Yii::app()->createAbsoluteUrl('/reservation/subscription/idealResponse',array('status'=>'back','order'=>$order->id,'txid'=>$payment->id,'user'=>$profile->user_id)) ?>"> 
<input type="hidden" name="home" value="http://yclean.nl"
<input type="hidden" name="PM" value="iDEAL" />
<button class="iDEALeasy" type="submit" name="submit1" value="submit">
Betalen met<br />
<img src="https://internetkassa.abnamro.nl/images/iDEAL_easy.gif" alt="iDEAL"  />
</button>
</form>	
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-validation-script',
  ' 

var Amount = $("[name=\"amount\"]").val();  
var PSPID = "cleanY";
var AM;

if (isNaN(Amount))
	{
		alert("Amount not a number: " + Amount + " !");
		AM = "";
	}
else
	{
		AM = Math.round(parseFloat(Amount)*100);
	}

var orderID = $("[name=\"orderID\"]").val() ;
mydate = new Date();
tv = mydate.getYear() % 10;
orderID = orderID + tv;
tv = (mydate.getMonth() * 31) + mydate.getDate();
orderID = orderID + ((tv < 10) ? "0" : "") + ((tv < 100) ? "0" : "") + tv;
tv = (mydate.getHours() * 3600) + (mydate.getMinutes() * 60) + mydate.getSeconds();
orderID = orderID + ((tv < 10) ? "0" : "") + ((tv < 100) ? "0" : "") + ((tv < 1000) ? "0" : "") + ((tv < 10000) ? "0" : "") + tv;
tvplus = Math.round(Math.random() * 9);
idVal = (orderID + ((tvplus + 1) % 10)) ;
$("[name=\"PSPID\"]").val(PSPID) ;
$("[name=\"amount\"]").val(AM) ;
$("[name=\"orderID\"]").val(idVal) ;
console.log( $("[name=\"orderID\"]").val()) ;
	 ',
  CClientScript::POS_END
);
?>
