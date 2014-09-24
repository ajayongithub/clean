
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
<title>Welcome to Yclean...your car, handled with care</title>
<meta name="description" content="Yclean. . . the Car Dry Clean">
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
<div id="globalWrapper">
  <!-- header -->
  
  <!-- header -->
  <header id="mainHeader" class="clearfix" >

    <div class="navbar navbar-fixed-top "  >
      <div class="navbar-inner" >
        <div class="container"> 
        <a href="<?php echo Yii::app()->baseUrl;?>../../index.html" class="brand"><img src="<?php echo Yii::app()->baseUrl;?>/images/main-logo.png" alt="yclean"/></a>
          <nav id="mainMenu">
             <ul>
              <li><a href="<?php echo Yii::app()->baseUrl;?>/../index.html" id='home' class="firstLevel " ><?php echo Yii::t('layout','Home');?></a> </li>
               <li> <a href="<?php echo Yii::app()->baseUrl;?>/../about_us.html" id='philosophy' class="firstLevel"><?php echo Yii::t('layout','About Us');?></a> </li>
              <li> <a href="<?php echo Yii::app()->baseUrl;?>/../services.html" id='services' class="firstLevel"><?php echo Yii::t('layout','Our Services');?></a>
              <li> <a href="<?php echo Yii::app()->baseUrl;?>/../sustainability.html" id='sustainabilty' class="firstLevel"><?php echo Yii::t('layout','Sustainability');?></a> </li>
              <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/auth" id='myYclean' class="firstLevel active"><?php echo Yii::t('layout','My Yclean'); ?></a> </li>
            </ul>
          </nav>
        </div>
      	<section class="center-align">
            <div class="link">
				<a> <?php echo Yii::t('layout','Hello').' '.Yii::app()->user->data()->profile->firstname ?> </a>
                <a href="<?php echo Yii::app()->createUrl('/reservation/account/update'); ?>" class="linkLeft"><?php echo Yii::t('layout','Your Profile');?></a>
                <a href="<?php echo Yii::app()->createUrl('/reservation/subscription/order');?>"><?php echo Yii::t('layout','Your Subscription');?></a>
                <a href="<?php echo Yii::app()->createUrl('/reservation/reservation/index');?>" ><?php echo Yii::t('layout','Your Reservations');?></a>
                <a href="<?php echo Yii::app()->createUrl('/reservation/feedback/index');?>"><?php echo Yii::t('layout','Your Feedback');?></a>
                <a href="<?php echo Yii::app()->createUrl('/user/auth/logout');?>"><?php echo Yii::t('layout','Logout');?></a>
            </div>
            </section>
      </div>
<!--        <div class="navbar-inner preHeader">
      	<section class="center-align">
            <div class="link">
				<a>Hello <?php //echo Yii::app()->user->data()->profile->firstname ?> </a>
                <a href="<?php //echo Yii::app()->createUrl('/reservation/account/update'); ?>" class="linkLeft">Your Profile</a>
                <a href="<?php //echo Yii::app()->createUrl('/reservation/subscription/order');?>">Your Subscription</a>
                <a href="<?php //echo Yii::app()->createUrl('/reservation/reservation/index');?>" >Your Reservations</a>
                <a href="<?php //echo Yii::app()->createUrl('/reservation/feedback/index');?>">Your Feedback</a>
                <a href="<?php //echo Yii::app()->createUrl('/user/auth/logout');?>">Logout</a>
            </div>
            </section>
      </div>-->
  </header>
  
  <!-- header -->
  
  
   <section id="content" class="home mt30">
  <!--3 cols-->
<section class="color1 slice">
      <div class="container container-margin  ">
        <div class="row mt30">
        <div class="span12 h-margin2">
			  <?php echo $content;?>
      	</div>
      </div> 
      </div>
    </section>
    </section>  
  <!-- content -->
  <!-- footer -->
  <footer class="footer2">
    <!--<section class="newsletter slice color4">
      <div class="container">
        <div class="row">
          <div class="span3">
            <h2>Our mailing list<br />
              <small>Keep in touch with us</small></h2>
          </div>
          <form method="post" action="#" id="newsletterform" data-mailchimp="xtrue">
            <div class="span3">
              <label for="newsletter-name">Enter your name</label>
              <input type="text" class="input-field" id="newsletter-name" name="newsletter-name" value="">
            </div>
            <div class="span3">
              <label for="newsletter-email">Enter your email</label>
              <input type="text" class="input-field" id="newsletter-email" name="newsletter-email" value="">
            </div>
            <div class="span3"> <a id="btn-newsletter" href="#" title="Subscribe now" class="btn">Subscribe now</a> </div>
          </form>
        </div>
      </div>
    </section>-->
	
	
	
	
	
	
  <!--<section id="mainFooter">
     <div id="backToTop">
        <div class="container" > <a href="#" class="iconWrapper"><i class="icon-up-open"></i></a> </div>
      </div>
      <div class="container" id="footer">
       <div class="row">
          <div class="span3 testimonialWidget"> <img src="images/main-logo.png" alt="latest Little Neko news" />
            <p><a href="http://www.little-neko.com" title="Little Neko, website template creation">Little Neko</a> is a web design and development studio. We build responsive HTML5 and CSS3 templates, integrating best web design practises and up-to-date web technologies to create great user experiences. We love what we do and we hope you too ! </p>
          </div>
          <div class="span3 projectWidget">
            <h3><span>Latest Projects</span></h3>
            <ul class="media-list">
              <li class="media"> <a class="pull-left" href="#"> <img class="media-object" src="images/works/footer-work1.jpg" alt="latest Little Neko news"> </a>
                <div class="media-body">
                  <p>Nullam sed tortor odio. Suspendisse tincidunt dictum nisi, nec convallis odio. </p>
                </div>
              </li>
              <li class="media"> <a class="pull-left" href="#"> <img class="media-object" src="images/works/footer-work2.jpg" alt="latest Little Neko news"> </a>
                <div class="media-body">
                  <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="span3 newsWidget">
            <h3><span>Latest News</span></h3>
            <ul>
              <li>
                <h4><i class="icon-calendar"></i><span>2013/03/21</span> Lauching a new project</h4>
                <p> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae<br />
                  <a href="#">read more</a></p>
              </li>
              <li>
                <h4><i class="icon-calendar"></i><span>2013/03/23</span> Check out our new premium website template: Snowflake</h4>
                <p> Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Cura<br />
                  <a href="#">read more</a></p>
              </li>
            </ul>
          </div>
          <div class="span3 contactWidget">
            <h3><span>Contact us</span></h3>
            <address>
            <strong>Little NEKO</strong>
            <p> <i class="icon-location"></i>&nbsp;77 Mass. Ave., E14/E15<br/>
              Cambridge, MA 02139-4307 USA <br />
              <i class="icon-phone"></i>&nbsp;615.987.1234 <br />
              <i class="icon-mail-alt"></i>&nbsp;<a href="mailto:little@little-neko.com">little@little-neko.com</a> </p>
            </address>
          </div>
        </div>
      </div>
    </section>-->
	
	
	
	
	
	<section class="center-align">	
 		   <div class="container">	
   <div class="link">
    <a href="<?php echo Yii::app()->baseUrl?>/../terms_and_conditions.html"><?php echo Yii::t('layout','Terms and Conditions');?></a> <a href="<?php echo Yii::app()->baseUrl;?>/../faq.html"><?php echo Yii::t('layout','FAQ');?></a> <a  href="<?php echo Yii::app()->baseUrl?>/../contact_us.html"><?php echo Yii::t('layout','Contact Us');?></a> 
   <a href="<?php echo Yii::app()->baseUrl?>/../sitemap.html"><?php echo Yii::t('layout','Sitemap'); ?></a>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php Yii::app()->baseUrl ;?>/js-plugin/jquery-ui/jquery-ui-1.8.23.custom.min.js"></script>
<!-- third party plugins  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/bootstrap/js/bootstrap-carousel-ie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/pretty-photo/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/easing/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/hoverdir/jquery.hoverdir.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ;?>/js-plugin/validate/jquery.validate.min.js"></script>
<?php if(strcmp(Yii::app()->language,'nl')==0){
	echo '<script type="text/javascript" src="'.Yii::app()->baseUrl.'/js-plugin/validate/messages-nl.js"></script>';
}
?>
<!-- jQuery Revolution Slider  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js-plugin/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- Custom  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/custom.js"></script>
</body>
</html>
<?php  $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-main-script-1',
  ' function setActiveMenuItem(item){
		$("#"+item).addClass("active");	
	}
$.validator.addMethod("nl_zipCode",function(value,element){
		return this.optional(element)||/^[0-9]{4}\s*[a-zA-Z]{2}/.test(value);
		},"Please enter the valid zipcode");
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
?>
	
