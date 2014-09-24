 <?php
 $cs = Yii::app()->getClientScript();  
$cs->registerScript(
  'my-script-1',
 	'var pageName="home";
 	setActiveMenuItem(pageName);',
  CClientScript::POS_END
); 
?> 
  <a href="<?php echo Yii::app()->createUrl('/language/language/fr') ?>">French</a>
  <a href="<?php echo Yii::app()->createUrl('/language/language/en') ?>">English</a>
<?php echo  Yii::app()->language; ?>
  <!-- slider -->
  <section  id="sliderWrapper">
    <!-- background slider dark bloc -->
    <div class="fullwidthbanner-container">
      <div class="fullwidthbanner" >
        <ul>
          <li data-transition="fade" data-slotamount="1"  data-masterspeed="900"> <img src="images/slider/rs/yclean.jpg" alt="slide" />
            <!--<div class="caption lfr" data-x="0" data-y="20" data-speed="2000" data-start="1000" data-easing="easeOutExpo"><img src="images/slider/rs/hexagones.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfl" data-x="0" data-y="250" data-speed="900" data-start="200" data-easing="easeOutBack"><img src="images/slider/rs/snowflake.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfl" data-x="100" data-y="330" data-speed="900" data-start="200" data-easing="easeOutBack"><img src="images/slider/rs/snowflake2.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfr" data-x="110" data-y="70" data-speed="700" data-start="700" data-easing="easeOutExpo"><img src="images/slider/rs/ipad1.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfl" data-x="400" data-y="240" data-speed="500" data-start="900" data-easing="easeOutExpo"><img src="images/slider/rs/iphone.png" alt="slide" class="ie8PngFix"/></div>-->
            
			<div class="caption sft small_text" data-x="609" data-y="100" data-speed="300" data-start="600" data-easing="easeOutExpo" >
              <h2>...if we can do it for you</h2>
            </div>
            <div class="caption sfb" data-x="610" data-y="164" data-speed="300" data-start="700" data-easing="easeOutExpo">
              <h3> Clear, clean dummy text </h3>
            </div>
            <div class="caption sfl" data-x="610" data-y="226" data-speed="500" data-start="1000" data-easing="easeOutBounce" >
              <p>lorem ipsum dummy text</p>
            </div>
			
            <div class="caption sfb" data-x="610" data-y="264" data-speed="900" data-start="2000" data-easing="easeOutExpo" > <a href="#" target="_blank" class="btn">Read More</a> </div>
          </li>
         <!-- <li data-transition="3dcurtain-vertical" data-slotamount="1"> <img src="images/textures/grey9.jpg" alt="slide"/>
            <div class="caption lfl" data-x="470" data-y="120" data-speed="900" data-start="200"  data-end="3000" data-easing="easeOutBack"><img src="images/slider/rs/header_styles_top.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfl small_text" data-x="70" data-y="120" data-speed="300" data-start="700" data-end="2900" data-easing="easeOutExpo" >
              <h2>5 header style options</h2>
            </div>
            <div class="caption lfl" data-x="71" data-y="184" data-speed="500" data-start="900" data-end="2800" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>Make your website unique!</h3>
            </div>
            <div class="caption lfl" data-x="0" data-y="150" data-speed="700" data-start="3300" data-easing="easeOutExpo"><img src="images/slider/rs/header_styles_footer.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption sft small_text" data-x="480" data-y="100" data-speed="300" data-start="3400" data-easing="easeOutExpo" >
              <h2>5 footer style options</h2>
            </div>
            <div class="caption lfr" data-x="481" data-y="164" data-speed="500" data-start="3600" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>Easy customization!</h3>
            </div>
            <div class="caption sfb" data-x="480" data-y="230" data-speed="900" data-start="3700" data-easing="easeOutExpo" > <a href="#" target="_blank" class="btn">Read More</a> </div>
          </li>
          <li data-transition="slideup" data-slotamount="2"><img src="images/textures/grey6.jpg" alt="slide"/>
            <div class="caption sft small_text" data-x="100" data-y="100" data-speed="300" data-start="300" data-easing="easeOutExpo" >
              <h2 id="font_icons_slider">120+ font icons<br/>
                <i class="icon-ajust"></i><i class="icon-arrows-cw"></i><i class="icon-barcode"></i><i class="icon-ajust"></i><i class="icon-arrows-cw"></i><i class="icon-barcode"></i><i class="icon-plus"></i> <br />
                <i class="icon-minus"></i> <i class="icon-up"></i> <i class="icon-right"></i> <i class="icon-down"></i> <i class="icon-home"></i> <i class="icon-pause"></i><br />
                <i class="icon-right-dir"></i> <i class="icon-down-dir"></i><i class="icon-left-dir"></i><i class="icon-cloud"></i> <i class="icon-umbrella"></i><i class="icon-star"></i><br />
                <i class="icon-star-empty"></i><i class="icon-check"></i> <i class="icon-left-hand"></i> <i class="icon-heart"></i> <i class="icon-right-hand"></i> ...</h2>
            </div>
            <div class="caption lfr" data-x="609" data-y="124" data-speed="300" data-start="1000" data-easing="easeInExpo" >
              <h2>UI retina ready</h2>
            </div>
            <div class="caption lfr" data-x="610" data-y="188" data-speed="300" data-start="1100" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>Sharp graphics!</h3>
            </div>
            <div class="caption lfr" data-x="610" data-y="254" data-speed="300" data-start="1200" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>Easily expandable!</h3>
            </div>
          </li>
          <li data-transition="slidedown" data-slotamount="1"><img src="images/textures/grey8.jpg" alt="slide"/>
            <div class="caption lfr" data-x="120" data-y="130" data-speed="700" data-start="0" data-easing="easeOutExpo"><img src="images/slider/rs/slider_colors1.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfl" data-x="600" data-y="50" data-speed="700" data-start="0" data-easing="easeOutExpo"><img src="images/slider/rs/slider_colors2.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption lfr" data-x="200" data-y="35" data-speed="700" data-start="300" data-easing="easeInExpo" >
              <h2><i class="icon-right-circle"></i>Unlimited colors</h2>
            </div>
            <div class="caption sfl" data-x="400" data-y="220" data-speed="700" data-start="800" data-easing="easeInExpo" >
              <h2><i class="icon-right-circle"></i>20 skins included!</h2>
            </div>
          </li>
          <li data-transition="slideleft" data-slotamount="1"> <img src="images/textures/grey9.jpg" alt="slide"/>
            <div class="caption lfl" data-x="550" data-y="100" data-speed="900" data-start="0" data-easing="easeOutBack"><img src="images/slider/rs/cat.png" alt="slide" class="ie8PngFix"/></div>
            <div class="caption sft small_text" data-x="50" data-y="49" data-speed="300" data-start="200" data-easing="easeOutExpo" >
              <h2>Build with bootstrap</h2>
            </div>
            <div class="caption lfl" data-x="50" data-y="113" data-speed="500" data-start="300" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>&nbsp;Sleek, intuitive, and powerful</h3>
            </div>
            <div class="caption lfl" data-x="50" data-y="179" data-speed="500" data-start="900" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>&nbsp;Mobile-Friendly Development </h3>
            </div>
            <div class="caption lfl" data-x="50" data-y="245" data-speed="500" data-start="1100" data-easing="easeInExpo" >
              <h3><i class="icon-right-circle"></i>&nbsp;Dozens of shortcodes</h3>
            </div>
            <div class="caption sfb" data-x="50" data-y="311" data-speed="300" data-start="1800" data-easing="easeOutExpo" > <a href="#" target="_blank" class="btn">Read More</a> </div>
          </li>-->
		   <li data-transition="fade" data-slotamount="1"  data-masterspeed="900"> <img src="images/slider/rs/yclean1.jpg" alt="slide" />
		  <div class="caption sft small_text" data-x="609" data-y="100" data-speed="300" data-start="600" data-easing="easeOutExpo" >
              <h2>...Banner option 2</h2>
            </div>
            <div class="caption sfb" data-x="610" data-y="164" data-speed="300" data-start="700" data-easing="easeOutExpo">
              <h3> Clear, clean dummy text </h3>
            </div>         
			
            <div class="caption sfb" data-x="610" data-y="264" data-speed="900" data-start="2000" data-easing="easeOutExpo" > <a href="#" target="_blank" class="btn">Read More</a> </div>
          </li>
		  
		   <li data-transition="fade" data-slotamount="1"  data-masterspeed="900"> <img src="images/slider/rs/yclean2.jpg" alt="slide" />
		  <div class="caption sft small_text" data-x="609" data-y="100" data-speed="300" data-start="600" data-easing="easeOutExpo" >
              <h2>...Banner option 3</h2>
            </div>
            <div class="caption sfb" data-x="610" data-y="164" data-speed="300" data-start="700" data-easing="easeOutExpo">
              <h3> Clear, clean dummy text </h3>
            </div>         
			
            <div class="caption sfb" data-x="610" data-y="264" data-speed="900" data-start="2000" data-easing="easeOutExpo" > <a href="#" target="_blank" class="btn">Read More</a> </div>
          </li>
        </ul>
        <div class="tp-bannertimer"></div>
      </div>
    </div>
  </section>
  <!-- slider -->
  <!-- topBox -->
  <!--<section class="topBox color1">
    <div class="container">
      <div class="row">
        <div class="span4"> <a href="http://themeforest.net/item/snowflake-responsive-bootstrap-website-template/4474194?ref=Little-Neko" class="btn btn-large btn-inverse">Buy this template now!</a> </div>
        <div class="span8">
          <div class="topQuote">
            <h1> The snow goose need not bathe to make itself white.</h1>
            <p>Neither need you do anything but be <strong>yourself</strong>.</p>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!-- topBox -->
  <!-- content -->
  <section id="content" class="home">
    <!--3 cols-->
    <section class="color1 slice">
      <div class="container">
        <div class="row">
          <div class="span4"><a href="<?php echo Yii::app()->baseUrl ; ?>/registration/registration/registration" class="btn btn-large">CREATE AN ACCOUNT</a> <br/><br/><br/>
           <a href="<?php echo Yii::app()->baseUrl ;?>/user/auth" class="btn btn-large" >MY YCLEAN</a> </div>
          <div class="span4">
            <h2>Our Services</h2>
            <p>Nullam sed tortor odio. Suspendisse tincidunt dictum nisi, nec convallis odio lacinia ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum auctor enim id lectus vehicula non iaculis mauris sollicitudin. Duis in ligula ligula, vel rutrum tortor. </p>
            <a class="btn btn-3d btnSmall" href="#">read more</a> </div>
          <div class="span4">
            <h2>Our Products</h2>
            <p>Nullam sed tortor odio. Suspendisse tincidunt dictum nisi, nec convallis odio lacinia ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum auctor enim id lectus vehicula non iaculis mauris sollicitudin. Duis in ligula ligula, vel rutrum tortor. </p>
            <a class="btn btn-3d btnSmall" href="#">read more</a> </div>
        </div>
      </div>
    </section>
    <!--3 cols-->
    <!-- 3blocs + video focus -->
    <!--<section class="slice color2 roundedShadow">
      <div class="container">
        <div class="row">
          <div class="span4">
            <div class="bulle bulleRight color4">
              <blockquote>Snowflake, a Premium Website Template that will help you buid your website in no time</blockquote>
              <div class="arrow"></div>
            </div>
          </div>
          <div class="span4">
            <div class="blocFocus color1">
              <h2>Our philosophy </h2>
              <div class="videoWrapper">
                <iframe src="http://player.vimeo.com/video/8432525?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="1280" height="281" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
              </div>
              <p class="credits"><a href="http://vimeo.com/8432525">Falling Snow</a> from <a href="http://vimeo.com/mattsfilms">Matt S</a> on <a href="http://vimeo.com">Vimeo</a>.</p>
            </div>
          </div>
          <div class="span4">
            <h2>Our services </h2>
            <div id="accordion2" class="accordion">
              <div class="accordion-group">
                <div class="accordion-heading"> <a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle active" id="link__inpage_95"> <i class="icon-minus"></i> Consulting </a> </div>
                <div class="accordion-body collapse in" id="collapseOne">
                  <div class="accordion-inner"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur elit et urna tempor ut bibendum dui cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a href="#collapseTwo" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle" id="link__inpage_96"> <i class="icon-plus"></i> Graphic design </a> </div>
                <div class="accordion-body collapse" id="collapseTwo">
                  <div class="accordion-inner"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur elit et urna tempor ut bibendum dui cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a href="#collapsethree" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle" id="link__inpage_97"> <i class="icon-plus"></i> Cooking </a> </div>
                <div class="accordion-body collapse" id="collapsethree">
                  <div class="accordion-inner"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. In consectetur elit et urna tempor ut bibendum dui cursus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </div>
                </div>
              </div>
            </div>
          </div>
          <!-- row-->
        </div>
        <!-- container-->
      </div>
    </section>
    <!-- 3blocs + video focus -->
    <!-- download -->
    <!--<section class="slice mb40">
      <div  class="container">
        <div class="row-fluid callToActionBoxed color4">
          <div class="span7">
            <div class="ctaText">
              <h3>Fully responsive, easy customization!</h3>
              <p><strong>Snowflake Website Template </strong> is perfect for simple and clean presentation of your business, from personal blogs to small business and corporate websites.</p>
            </div>
          </div>
          <div class="span5">
            <div class="btnWrapper color3"> <a href="http://themeforest.net/item/snowflake-responsive-bootstrap-website-template/4474194?ref=Little-Neko" class="btn btn-inverse btn-large" title="Buy This awesome theme"><i class="icon-down-circled"></i>Buy this template now!</a> </div>
          </div>
        </div>
      </div>
    </section>-->
    <!-- download -->
  </section>
  <!-- content -->
