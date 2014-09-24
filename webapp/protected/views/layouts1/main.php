<?php $this->layout = 'none';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>OPAC Labs</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- Le styles -->
<link href="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">


 
   

<link href="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/google-code-prettify/prettify.css"
	rel="stylesheet">

<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Quando&subset=latin,latin-ext">


<link href="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/images/main/letter.ico" rel="shortcut icon">
<link rel="apple-touch-icon-precomposed" sizes="144x144"
	href="assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed"
	href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50" style="padding-top: 30px;">


<!-- Navbar
    ================================================== -->
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
				<div class="nav-collapse collapse">
					    
					    <ul class="nav">
					    <li>
					 <a href="<?=Yii::app()->createUrl('/', array())?>"> <h1 style="font-family: 'Quando', serif; font-size: 2.5em; margin-bottom: 0px; margin-top: 0px;">OPAC Labs</h1></a>
					    </li>
					    </ul>
						<ul class="nav pull-right">
						
						<li class="divider-vertical"></li>
						<li class="">
							<a href="<?=Yii::app()->createUrl('//site/industry', array())?>"><h5>Industry</h5></a>
						</li>
						<li class="divider-vertical"></li>
						<li class="">
							<a href="<?=Yii::app()->createUrl('//site/technology', array())?>"><h5>Technology Competency</h5></a>
						</li>
						<li class="divider-vertical"></li>
						<li class="">
							<a href="<?=Yii::app()->createUrl('//site/mobileSolution', array())?>"><h5>Mobile Solutions</h5></a>
						</li>
						<li class="divider-vertical"></li>
						<li class="">
							<a href="<?=Yii::app()->createUrl('//site/products', array())?>"><h5>Products</h5></a>
						</li>
						<li class="divider-vertical"></li>
						<li class="">
							<a href="<?=Yii::app()->createUrl('//site/deliveryPractices', array())?>"><h5>Delivery Practices</h5></a>
						</li>
						<li class="divider-vertical"></li>
						<li class="dropdown">
<a class="dropdown-toggle" href="#" data-toggle="dropdown">
<h5>Company
<b class="caret"></b></h5>
</a>
<ul class="dropdown-menu">
<li>
<a href="<?=Yii::app()->createUrl('//site/news', array())?>">News</a>
</li>
<li class="divider"></li>
<li>
<a href="<?=Yii::app()->createUrl('//site/contact', array())?>">Contact US</a>
</li>
</ul>
</li>
				
					</ul>
					
				</div>
			</div>
		</div>
	</div>


	<div class="container" >
		<div style="margin-top: 50px;">

    <?php echo $content; ?>


</div>


</div>











	 <!-- Footer
    ================================================== -->
   <footer class="footer" style="margin-top: 0px; padding-bottom: 15px; padding-top: 0px;">

<div class="row-fluid" style="height: 15px; margin-top: 21px;">
<div class="span1">
<a href="<?=Yii::app()->createUrl('/', array())?>" class="pull-right">Home</a>
</div>
<div class="span4">
<a href="<?=Yii::app()->createUrl('//site/contact', array())?>">Contact us</a>
</div>

<div class="span7 pull-right">
<font color="white" style="padding-left: 35%;">&#169; All Rights Reserved, OPAC Labs Pvt Ltd | enquiry@opaclabs.com</font>
</div>
</div>


</footer>






	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/jquery.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/google-code-prettify/prettify.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-transition.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-alert.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-modal.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-popover.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-button.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-collapse.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-carousel.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-tab.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/bootstrap-typeahead.js"></script>
	<script src="<?=DOMAIN_URL . Yii::app()->baseUrl; ?>/sites/bootstrap/js/application.js"></script>
	
</body>
</html>
