<?php if(Yum::hasFlash()) {
echo '<div class="success">';
Yum::renderFlash();
echo '</div>';
} 

?>
<div class="container">


        <div class="row">
          <div class="span12">
            <?php echo '<h1>'.Yii::t('subscription','Our Plans').'</h1>';?>
          </div>
        </div>
      </div>
    <!-- main content -->
    <section>
      <div class="container">
        <div class="row mb30">
          <div class="span12">
          	<?php echo Yii::t('subscription','Please select one plan for your subscription');?>
          </div>
          <?php
			$feature = array('<li><strong>Alleen exterieur cleaning:</strong></li>
								<li>Buitenkant gecleaned</li> <li>Ramen en spiegels</li>
								<li>Vuil en vet wordt van de wielen verwijderd</li> 
								<li>Auto wordt in de was gezet</li> ',
								'<li><strong>Combinatie van Clean en Complete pack:</strong></li>
								<li>6 clean packs</li> <li>6 complete packs</li>
								<li>Afwisselende cleaning van exterieur </li> <li>and exterieur+interieur</li>
								',
								'<li><strong>Zowel exterieur als interieur cleaning:</strong></li>
								<li>De gehele binnenkant wordt gestofzuigd</li> <li>Dashboard
								 + Kofferbak</li> <li>Stoelen</li> <li>Deuren en zijvakken</li>',
					'<li><strong>Alleen exterieur cleaning:</strong></li>
					<li>Buitenkant gecleaned</li> <li>Ramen en spiegels</li>
					<li>Vuil en vet wordt van de wielen verwijderd</li>
					<li>Auto wordt in de was gezet</li> ',
					'<li><strong>Combinatie van Clean en Complete pack:</strong></li>
					<li>6 clean packs</li> <li>6 complete packs</li>
					<li>Afwisselende cleaning van exterieur </li> <li>and exterieur+interieur</li>
					',
					'<li><strong>Zowel exterieur als interieur cleaning:</strong></li>
					<li>De gehele binnenkant wordt gestofzuigd</li> <li>Dashboard
					+ Kofferbak</li> <li>Stoelen</li> <li>Deuren en zijvakken</li>'
							);	
         	$indx = 0 ; 
          foreach($model as $plan){ ?>
          <div class="span4">
            <div id="ext" class="pricingBloc focusPlan">
              <h2><?php echo $plan->plan_name; ?> </h2>
              <h2 style="background-color:#F86D18"><strong style="color:white">€<?php echo number_format($plan->plan_cost,2); ?><small> (excl. BTW)</small><br><?php echo Yii::t('subscription','Per cleaning'); ?></strong></h2>
              <ul>
                <!--  <li><?php //echo $plan->plan_duration;?> Months</li>-->
                <?php echo $feature[$indx];?>
                <li><input type="checkbox" id="chkb-<?php echo $indx?>" name="auth_mandate"><?php echo Yii::t('subscription','I agree with terms and conditions')?></input></li>
              </ul>
              <form action="<?php echo Yii::app()->createUrl('/reservation/subscription/subscribe');?>" method="post">
              	<input type="hidden" name="Plan[id]" value="<?php echo $plan->id; ?>"/>
              	<p class="sign"> <input type="submit" disabled="disabled" class="btn " id="signBtn-<?php echo $indx;?>" style=" " value="<?php echo Yii::t('subscription','Sign Up');?>"> </p>
              </form>
              	<h6><?php //echo Yii::t('subscription','By Clicking the Signup Button you agrere to Yclean\'s Terms and Conditions.');?></h6>
            </div>
          </div>
 	<?php $indx++;
		 }?>

        </div>
      </div>
    </section>
    <!-- end main content -->
    <div class="slice center-align">
    	<div class="container ">
    		<div class="row color4 ">
    		<div class="span3"></div>
    		<div class="span6">
    			<h5><?php //echo Yii::t('subscription','Discount:<p/> If you make upfront payment for 12 cleanings you get one month free, Pay for 11 months and get one month free. <p/> You can Pay by Ideal');?></h5>
    			</div>
    		</div>
    		<div class="span3"></div>
    	</div>
    </div>
    <?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'order-validation-script',
  ' 
    $("#chkb-0").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-0").removeAttr("disabled");
        } else {
            $("#signBtn-0").attr("disabled", "disabled");
        }
    });
    $("#chkb-1").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-1").removeAttr("disabled");
        } else {
            $("#signBtn-1").attr("disabled", "disabled");
        }
    });
    $("#chkb-2").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-2").removeAttr("disabled");
        } else {
            $("#signBtn-2").attr("disabled", "disabled");
        }
    });
	   $("#chkb-3").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-3").removeAttr("disabled");
        } else {
            $("#signBtn-3").attr("disabled", "disabled");
        }
    });
    $("#chkb-4").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-4").removeAttr("disabled");
        } else {
            $("#signBtn-4").attr("disabled", "disabled");
        }
    });
    $("#chkb-5").click(function() {
        if ($(this).is(":checked")) {
            $("#signBtn-5").removeAttr("disabled");
        } else {
            $("#signBtn-5").attr("disabled", "disabled");
        }
    });
	 ',
  CClientScript::POS_READY
);
?>
    