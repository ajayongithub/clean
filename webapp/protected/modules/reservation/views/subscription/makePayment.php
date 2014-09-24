<div class="row">
<div class="span4 bulle">

	<h3><?php echo Yii::t('subscription','Allow us to automatically debit your account every month, enter your bank details an receive the mandate'); ?></h3>
<form id="mandate-form" method="post" action="<?php echo Yii::app()->createUrl('/reservation/subscription/mandate');?>">
	<input type="hidden" value="<?php echo $order->id; ?>" name="orderId"/>
	<label>BIC</label>
	<input name="bank_name" type ="text"/>
	<br/>
	<label>iBAN/Account Number </label>
	<input name="bank_account" type ="text"/>
	<input type="checkbox" id="auth_mandate_ckb" name="auth_mandate"><h6><?php echo Yii::t('subscription','I hereby authorise Yclean to monthly deduct € amount from my account',array('amount'=>number_format($plan->plan_cost*( 1 +($this->VAT/100)),2))); ?></h6>
<input type="submit" id="mandate_btn" class="btn btn-large" disabled="disabled" value="<?php echo Yii::t('subscription','Pay Via Mandate');?>"/>
</form>
<p><?php echo Yii::t('subscription','Find your BIC and IBN via website');?><a href="https://www.ibanbicservice.nl/" target="_new"> IBAN BIC</a></p>
</div>
<div class="span4 bulle">
	<h3><?php //echo Yii::t('subscription','Pay for 11 months and get 12 months service');?></h3>
	<h3><?php //echo Yii::t('subscription', 'Pay amount via iDeal by clicking the button below', 
	//		array('amount'=>number_format(11*$plan->plan_cost*( 1 +($this->VAT/100)),2))); ?></h3> 
	<form method="post" action="<?php echo Yii::app()->createUrl('/reservation/subscription/ideal');?>">
		<input type="hidden" value="<?php echo $order->id; ?>" name="orderId"/>
	<!--	<input type="submit" class="btn btn-large" value="<?php //echo Yii::t('subscription','iDeal Payment');?>"/>-->
	</form>
	
</div></div>


<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'mkpmt-validation-script',
  ' 
	$("#mandate-form").validate({
		errorPlacement:function(error,element){
			error.appendTo(element.prev("label"));
		},

		rules:{
			bank_name:{
				required:true,
				},
			bank_account:{
				required:true,
				//number:true,
				}
		}
		}
	);
    $("#auth_mandate_ckb").click(function() {
        if ($(this).is(":checked")) {
            $("#mandate_btn").removeAttr("disabled");
        } else {
            $("#mandate_btn").attr("disabled", "disabled");
        }
    });
	 ',
  CClientScript::POS_READY
);
?>
