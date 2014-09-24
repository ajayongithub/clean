<div class="row">
<img src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/images/main/contact.jpg"  style="width: 1200px; height: 200px;">
</div>

<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBwxRknxtfuEBHAzU4z0e4r6TvNOUhw61c&sensor=false">
</script>

<script>
var myCenter=new google.maps.LatLng(28.617735,77.384653);

function initialize()
{
var mapProp = {
  center: myCenter,
  zoom:15,
  mapTypeId: google.maps.MapTypeId.ROADMAP
  };

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position: myCenter,
  title:'Click to zoom'
  });

marker.setMap(map);

// Zoom to 9 when clicking on marker
google.maps.event.addListener(marker,'click',function() {
  map.setZoom(9);
  map.setCenter(marker.getPosition());
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="row well">

<div class="span6"><!-- Middle one -->



<div class="well">




<h2>OPAC Labs Software Pvt. Ltd. </h2>


<h3><u>Head Office</u></h3>

<address>
<strong>OPAC Labs Software Pvt. Ltd..</strong>
<br>
C-78, Sector 63, Noida-201301
<br>
UttarPradesh, India
<br>
</address>



<hr>


<span class="label label-info pull-left" style="height: 14px; width: 65px;">Phone : </span><p> &nbsp;+91-1204280186, +91-9958202825</p>

<hr>


<span class="label label-info pull-left" style="height: 14px; width: 65px;">Visit Us : </span><a href="<?=Yii::app()->createUrl('/', array())?>"> &nbsp;http://www.opaclabs.com</a>

<br><hr>

<span class="label label-info pull-left" >contact us :</span><p> &nbsp;enquiry@opaclabs.com</p>


</div>


</div>


<div class="span5">


<div class="well">

<div id="googleMap" style="width:420px;height:360px;"></div>
</div>

</div>






</div>