<?php
 $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-script-1',
'function calc(){
	var_cars = document.getElementById("num_cars").value;
	var_water = document.getElementById("num_water");
	var_fuel = document.getElementById("num_fuel");
	var_phos = document.getElementById("num_phos");
	var_ammonia = document.getElementById("num_ammonia");
	var_surf = document.getElementById("num_surf");
	var_solid = document.getElementById("num_solid");
	
	if( var_cars == null || var_cars == "" || var_cars < 1 ){
		alert("Please enter postive value for Number of registered cars");
	}else{
                var_water.value = (var_cars * 0.38) * 26 * 20;
		var_fuel.value = (var_cars/10000) * 30.6;
		var_phos.value = (var_cars/10000) * 64.51;
		var_ammonia.value = (var_cars/10000) * 9.7;
		var_surf.value = (var_cars/10000) * 355;
		var_solid.value = (var_cars/10000) * 4838;
	}
}',CClientScript::POS_END
);
?>

    <!-- main content -->
  
    <section class="color1 slice">
      <div class="container container-margin">
        <div class="row">
          <div class="span3">
            <aside id="sidebar">
              <nav id="subnav">
                <ul class="iconsList">
              <!--    <li><a class="" href="#"><i class="icon-right-open"></i> Sustaibility </a></li>-->
                  <li><a class="active" href="<?php echo Yii::app()->baseUrl?>/view/footprint"><i class="icon-right-open"></i> Calculate you car wash footprint </a></li>
                  <li><a class="" href="<?php echo Yii::app()->baseUrl?>/view/waterImportance"><i class="icon-right-open"></i> Importance of Water </a></li>
                  <li><a class="" href="<?php echo Yii::app()->baseUrl?>/view/saveWater"><i class="icon-right-open"></i> Tips to save Water </a></li>
                </ul>
              </nav>
            </aside>
          </div>
      	<div class="span9">
      	<h3>Water, gasoline, motor oil, phosphorus, nitrogen, ammonia, surfactants, solid waste. . .</h3>
      	<p> What’s the yearly impact of hose and water car cleaning on your community? How many pounds of harmful car wash by-products, oil, and gasoline go untreated to storm sewers and eventually make their way to the ocean or to local rivers and lakes? How much water is wasted?</p>
		<p> We’ve incorporated data from The Residential Car Washwater Monitoring Study conducted by the City of Federal Way, WA to allow you to estimate pollutant loading to storm sewers from traditional hose and water residential car washing.  </p>
      	<div class=" span6 bulle color4" >
            <section>
            <form id="form1" method="post" color="white">
<table cellspacing="0" cellpadding="0" color="white"><colgroup><col width="310"> <col width="88"></colgroup>
<tbody>
<tr>
<td width="310" height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><strong><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Number of registered cars</span></span></span></strong></span></span></td>
<td align="right" width="88"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><label><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_cars" type="text" name="num_cars" value="10000"> </span></span></span></label></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Gallons of water <br></span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_water" type="text" name="num_water" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Gallons of gasoline, diesel and motor oil</span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_fuel" type="text" name="num_fuel" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Pounds of phosphorous and nitrogen</span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_phos" type="text" name="num_phos" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Pounds of ammonia</span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_ammonia" type="text" name="num_ammonia" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Pounds of surfactants</span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_surf" type="text" name="num_surf" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
<tr>
<td height="17"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">Pounds of solid wastes</span></span></span></span></span></td>
<td align="right"><span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="num_solid" type="text" name="num_solid" value="0" disabled="disabled"></span></span></span></span></span></td>
</tr>
</tbody>
</table>
<span style="font-family: verdana,geneva;"><span style="font-size: small;"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><br></span></span></span><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;"><input id="calculate" onclick="calc()" type="button" name="calculate" value="Calculate"></span></span></span><strong><em><span lang="EN"><span style="color: #ffffff;"><span style="font-size: small;"><span style="font-family: verdana, geneva;">&nbsp;</span></span></span></span></em></strong></span></span></form>
          </div>
		  <div class="clearfix"></div>
		  <div>
<h3>Bring those numbers to zero</h3>
<p>
YClean Waterless Car Wash eliminates the discharge of untreated contaminants and conserves water.
</p>

<h4>The calculator is based on the study’s following research-based assumptions:</h4>
<ul>
<li>Thirty-eight percent (38%) of car owners wash their cars in the driveway. (International Carwash Association)</li>
<li>The average frequency of residential car washing in their region is once every two weeks.</li>
<li>80% of driveway car washing effluent drains to storm sewers.</li>
<li>The average amount of water used to wash a vehicle based on field observations and simulations using a low-flow nozzle are 20 gallons.</li>
<li> Smith, Daniel J., Shilley, Hollie. 2009. Residential Car Washwater Monitoring Study. City of Federal Way, Washington, Public Works, Surface Water Management </li>
      </ul>
</div>
		  </div>
          

            </section>
        </div>
      </div>
    </section>
    <!-- end main content -->
  </section>
  <!-- end content -->
