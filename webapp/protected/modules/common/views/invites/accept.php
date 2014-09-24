<div class="container">
<div class="row">
<div class="span8">
<h3>Welcome to YClean</h3>
<div class="color">
<h4>Company Id : <?php echo $company_id; ?></h4>
<span>Thankyou for accepting the invite.  You can now create your account by following the following steps:</span>
<span><ol><li>Provide Your Details</li><li>Select Service Type</li><li>Make Payments</li><li>And You are Good to Go, Start Making Reservations</li></ol></span>
</div>
<a href="<?php echo Yii::app()->createUrl('/signup/registration/registerForCompany',array('companyId'=>$company_id));?>" class="btn">Create My Account</a>
</div>
</div>
</div>