


<!-- main content -->
   <section class="color1 slice">
    <div class="container container-margin">
        <div class="row">
          <!-- contact intro -->
          <div class="span5">
            <!-- map -->
            <div class="imgWrapper">
              <div id="mapWrapper"></div>
            </div>
            <!-- map -->
          </div>
          <!-- contact intro -->
          <!-- contact form -->
          <div class="span4">
            <form method="post" action="<?php echo Yii::app()->baseUrl;?>/js-plugin/neko-contact-ajax-plugin/php/form-handler.php" id="contactfrm">
              <label for="name"></label>
              <input type="text" name="name" id="name" placeholder="Name"  title="Please enter your name (at least 2 characters)"/>
              <label for="email"></label>
              <input type="text" name="email" id="email" placeholder="Email" title="Please enter a valid email address"/>
              <label for="phone"></label>
              <input name="phone" type="text" id="phone" size="30" value="" placeholder="Phone" class="required digits" title="Please enter a valid phone number (at least 10 characters)">
              <label for="comments"></label>
              <textarea name="comment" id="comments" cols="3" rows="5" placeholder="Enter your message…" title="Please enter your message (at least 10 characters)"></textarea>
              <fieldset class="clearfix securityCheck">
              <legend>Security</legend>
              <div class="row">
                <div class="span4 pull-left humanCheck">
                  <label for="verify" class="pull-left"><img src="<?php echo Yii::app()->baseUrl;?>/js-plugin/neko-contact-ajax-plugin/php/image.php" alt="Image verification"/></label>
                  <input class="required "  id="verify" name="verify" type="text" >
                </div>
              </div>
              </fieldset>
              <br/>
              <button name="submit" type="submit" class="btn" id="submit"> Submit</button>
            </form>
            <div class="result"></div>
          </div>
          <!-- contact form -->
          <!-- address bloc -->
          <div class="span3">
            <address>
            Address:<br/>
            YClean Corporation <br/>
			De Ruyterkade 5<br/>
			1013 AA Amsterdam <br/>
            <br/>
            phone:<br/>
            315.998.1234<br/>
            </address>
          </div>
          <!-- address bloc -->
        </div>
      </div>
    </section>
    <!-- end main content -->
  <!-- end content -->
  <!-- Custom  -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/custom.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false&callback=initialize"></script>