
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerCoreScript('jquery');?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<!-- Basic Page Needs
  ================================================== -->
<meta charset="utf-8">
<title>Welcome to Yclean...your car,handled with care</title>
<meta name="description" content="Yclean. . . ">
<meta name="author" content="Yclean">
<!-- Mobile Specific Metas


  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- CSS
  ================================================== -->
<!-- Bootstrap  -->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/bootstrap/css/bootstrap.min.css">
<!-- web font  -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,800" rel="stylesheet" type="text/css">
<!-- plugin css  -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/js-plugin/rs-plugin/css/settings.css" media="screen" />
<!-- icon fonts -->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/font-icons/custom-icons/css/custom-icons.css">
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/font-icons/custom-icons/css/custom-icons-ie7.css">
<!-- Custom css -->
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/layout.css">
<!--<link type="text/css" id="colors" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/colors.css">-->
  <link type="text/css" id="colors" rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/css/dark-orange.css">
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
<script src="<?php echo Yii::app()->baseUrl?>/js/modernizr-2.6.1.min.js"></script>

<script> var pageName = 'home' ;</script>
<!-- Favicons
  ================================================== -->
<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl?>/images/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo Yii::app()->baseUrl?>/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::app()->baseUrl?>/images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->baseUrl?>/images/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::app()->baseUrl?>/images/apple-touch-icon-144x144.png">
<style type="text/css">
#cssawards {
	position:fixed;
	top:120px;
	left:0px;
	z-index:21;
}
#cssawards a {
	width:95px;
	height:50px;
	text-indent:-8000px;
	display:block;
	background:url('/light/images/cssa-ribbons-13.png') no-repeat;
}


</style>
</head>
<body >
<!-- Primary Page Layout 
 ================================================== -->
<!-- globalWrapper -->
<div id="globalWrapper 2">
  <!--<div id="cssawards"> <a href="http://cssawards.net/snowflake-bootstrap-website-template" target="_blank">Snowflake</a> </div>-->
  <!-- header -->
  <header id="mainHeader" class="clearfix" >

    <div class="navbar navbar-fixed-top "  >
      <div class="navbar-inner" >
        <div class="container"> 
        <a href="<?php echo Yii::app()->baseUrl;?>../../index.html" class="brand"><img src="<?php echo Yii::app()->baseUrl;?>/images/main-logo.png" alt="yclean"/></a>
          <nav id="mainMenu">
             <ul>
              <li><a href="<?php echo Yii::app()->baseUrl;?>/../index.html" id='home' class="firstLevel " >Home</a> </li>
               <li> <a href="<?php echo Yii::app()->baseUrl;?>/../about_us.html" id='philosophy' class="firstLevel">About Us</a> </li>
              <li> <a href="<?php echo Yii::app()->baseUrl;?>/../services.html" id='services' class="firstLevel">Our Services</a>
              <li> <a href="<?php echo Yii::app()->baseUrl;?>/../sustainability.html" id='sustainabilty' class="firstLevel">Sustainability </a> </li>
              <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/auth" id='myYclean' class="firstLevel active">My Yclean</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="navbar-inner preHeader">
      	<section class="center-align">
            <div class="link">
            <ul>
               <!--   <a href="<?php echo Yii::app()->baseUrl?>/admin/admin/index" class="icon-home"></a>-->
                <a href="<?php echo Yii::app()->baseUrl?>/common/masterLocations/admin">Location</a>
                <a href="<?php echo Yii::app()->baseUrl?>/common/company/admin">Company</a>
                <a href="<?php echo Yii::app()->baseUrl?>/common/companyLocation/admin">Comp. Location</a>
                <a href="<?php echo Yii::app()->baseUrl?>/common/timeSlots/admin">Slot</a>
                <a href="<?php echo Yii::app()->baseUrl?>/common/locationSchedule/admin">Schedule</a>
                <a href="<?php echo Yii::app()->baseUrl?>/reservation/reservation/admin">Reservation</a>
                <a href="<?php echo Yii::app()->baseUrl?>/common/invites/admin">Invite</a>
                <a href="<?php echo Yii::app()->baseUrl?>/admin/users/admin">User</a>
                <a href="<?php echo Yii::app()->baseUrl?>/planning/employees/admin">Employee</a>
                <a href="<?php echo Yii::app()->baseUrl?>/planning/cleaningCars/admin">Car</a>
                <a href="<?php echo Yii::app()->baseUrl?>/reservation/paymentDetails/searchMandate">Mandate</a>
                <a href="<?php echo Yii::app()->baseUrl?>/planning/roster/">Roster</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/auth/logout" class="icon-logout"></a>
            </ul>
            </div>
            </section>
      </div>
    </div>
  </header>
   
<!-- header -->
  <section id="content" class="home"> 
  <!--3 cols-->
<section class="color1 slice">
      <div class="container container-margin offset1">
        <div class="row mt30">
        <div class="span12 h-margin2">
			  <?php echo $content;?>
      	</div>
      </div> 
      </div>
    </section>
    </section>  
  
  <!--
  <div class="container mt30 mb30 offset1">
	<div class="row">
  <?php //echo $content;?>
  </div>
  </div>
  -->
  
  <!-- content -->
  <!-- footer -->
  <footer class="footer2">
	
	<section class="center-align">	
 		   <div class="container">	
   <div class="link"> 
    <a href="<?php echo Yii::app()->baseUrl?>/../terms_and_conditions.html">Terms and Conditions</a> <a href="<?php echo Yii::app()->baseUrl;?>/../faq.html">FAQ</a> <a  href="<?php echo Yii::app()->baseUrl?>/../contact_us.html">Contact Us</a> 
   <a href="<?php echo Yii::app()->baseUrl?>/../sitemap.html">Sitemap</a>
    </div>

    </div>
	</section>
	
    <section  id="footerRights" class="fotter-background-color" >
      <div class="container">
      
          <div class="span12">
            <div class="innerBg">
              <p>Copyright © 2013 Yclean. All rights reserved.</p>
            </div>
          </div>
       
      </div>
    </section>
  </footer>
  <!-- footer -->
</div>
<!-- global wrapper -->
<!-- End Document 
  ================================================== -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/respond/respond.min.js"></script>
 <!--  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
<!--  ><script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js-plugin/jquery-ui/jquery-ui-1.8.23.custom.min.js"></script> -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js-plugin/validate/jquery.validate.min.js"></script>
<!-- third party plugins  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/bootstrap/js/bootstrap-carousel-ie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/pretty-photo/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/easing/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/hoverdir/jquery.hoverdir.js"></script>
<!-- jQuery Revolution Slider  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- Custom  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/custom.js"></script>
</body>
</html>
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerCoreScript('jquery');
$cs->registerScript(
  'my-main-script-1',
  ' function setActiveMenuItem(item){
		$("#"+item).addClass("active");	
	}
	$.validator.addMethod("nl_zipCode",function(value,element){
		return this.optional(element)||/^[0-9]{4}\s*[a-zA-Z]{2}/.test(value);
		},"Please enter the valid zipcode");
	$.validator.addMethod("timeFormat",function(value,element){
		return this.optional(element)||/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/.test(value);
		},"Please enter the valid time in 24Hr format");
	if(!window.jQuery)
	{
   	var script = document.createElement("script");
   	script.type = "text/javascript";
   	script.src = "'.Yii::app()->baseUrl.'/js/jquery.js";
   	document.getElementsByTagName("head")[0].appendChild(script);
	}
	',
  CClientScript::POS_END
);

$cs->registerScript(
  'jquery-script-1',
  ' if(!window.jQuery)
	{
   	var script = document.createElement("script");
   	script.type = "text/javascript";
   	script.src = "'.Yii::app()->baseUrl.'/js/jquery.js";
   	document.getElementsByTagName("head")[0].appendChild(script);
	}
	',
  CClientScript::POS_HEAD
);
?>
	
