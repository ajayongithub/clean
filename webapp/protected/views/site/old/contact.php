<div class="content">
   <div class="container">
      <div class="row">
         <div class="span12">
            
            <!-- Contact starts -->
            
            <div class="contact">
               <div class="row">
                  <div class="span12">
                  
                     <!-- Contact hero -->
                     <div class="hero">
                        <!-- Title. Don't forget the <span> tag -->
                        <h3><span>Contact</span></h3>
                        <!-- para -->
                        <p>Head office - Noida, India</p>
                     </div>
                     <!-- Contact -->
                     
                     <div class="contact">
                        <div class="row">
                           <div class="span12">
                              
                           </div>
                        </div>
                        <div class="row">
                           <div class="span6">
                              <div class="cwell">
                                 <!-- Contact form -->
                                    <h5>Contact Form</h5>
                                    <hr />
                                    <div class="form">
                                      <!-- Contact form (not working)-->
                                      <?php if(!$model)$model= new ContactForm();?>
                                      <?php $form=$this->beginWidget('CActiveForm', array(
                                            'htmlOptions'=>array('class'=>"form-horizontal")
                                      
                                      )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {?>
<div class="alert alert-info">
    <?php
    //var_dump($flashMessages);
    foreach($flashMessages as $key => $message) {
    	//var_dump($message);
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
</div>
<?php }?>

    <?php if($model->hasErrors()){?>
    <div class="alert alert-info">
	<?php echo CHtml::errorSummary($model); ?>
	</div>
                                   <?php }?>   
                                      <form class="form-horizontal">
                                          <!-- Name -->
                                          <div class="control-group">
                                            <label class="control-label" for="name">Name</label>
                                            <div class="controls">
                                            <?php echo $form->textField($model,'name',array('class'=>"input-medium")); ?>
                                              
                                            </div>
                                          </div>
                                          <!-- Email -->
                                          <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                            <?php echo $form->textField($model,'email',array('class'=>"input-medium")); ?>
                                            
                                             
                                            </div>
                                          </div>
                                          <!-- Website -->
                                          <div class="control-group">
                                            <label class="control-label" for="website">Website</label>
                                            <div class="controls">
                                             <?php echo $form->textField($model,'website',array('class'=>"input-medium")); ?>
                                            
                                            </div>
                                          </div>
                                          <!-- Comment -->
                                          <div class="control-group">
                                            <label class="control-label" for="comment">Comment/Body</label>
                                            <div class="controls">
                                              <?php echo $form->textArea($model,'body',array('class'=>"input-large",'rows'=>10,'cols'=>60)); ?>
                                            
                                            </div>
                                          </div>
                                          
                                           <!-- Phone -->
                                          <div class="control-group">
                                            <label class="control-label" for="phone">Phone</label>
                                            <div class="controls">
                                             <?php echo $form->textField($model,'phone',array('class'=>"input-medium")); ?>
                                            
                                            </div>
                                          </div>
                                          
                                           <!-- Email -->
                                          <div class="control-group">
                                            <label class="control-label" for="cell">Cell</label>
                                            <div class="controls">
                                              <?php echo $form->textField($model,'cell',array('class'=>"input-medium")); ?>
                                            
                                            </div>
                                          </div>
                                          <!-- Buttons -->
                                          <div class="form-actions">
                                             <!-- Buttons -->
                                            <button type="submit" class="btn">Submit</button>
                                            <button type="reset" class="btn">Reset</button>
                                          </div>
                                      <?php $this->endWidget(); ?>
                                    </div>
                                    <hr />
                                    
                                       <div class="csoci">  
                                           <!-- Social media icons -->
                                           <strong>Get in touch:</strong>
                                           <div class="social">
                                                <a href="#"><i class="icon-facebook"></i></a>
                                                <a href="#"><i class="icon-twitter"></i></a>
                                                <a href="#"><i class="icon-linkedin"></i></a>
                                                <a href="#"><i class="icon-google-plus"></i></a>
                                                <a href="#"><i class="icon-pinterest"></i></a>
                                           </div>
                                       </div>
                                 </div>
                           </div>
                           <div class="span6">
                                 <div class="cwell">
                              <!-- Google maps -->
                              <div class="gmap">
                              <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=c-78,sector+63,+noida,india&amp;aq=&amp;sll=28.536275,77.54837&amp;sspn=0.342029,0.676346&amp;ie=UTF8&amp;hq=&amp;hnear=Sector+63,+Noida,+Gautam+Buddh+Nagar,+Uttar+Pradesh&amp;t=m&amp;z=14&amp;ll=28.620987,77.381161&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.in/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=c-78,sector+63,+noida,india&amp;aq=&amp;sll=28.536275,77.54837&amp;sspn=0.342029,0.676346&amp;ie=UTF8&amp;hq=&amp;hnear=Sector+63,+Noida,+Gautam+Buddh+Nagar,+Uttar+Pradesh&amp;t=m&amp;z=14&amp;ll=28.620987,77.381161" style="color:#0000FF;text-align:left">View Larger Map</a></small>
                                 </div>
                              
                                    <!-- Address section -->
                                       <h5>Address</h5>
                                       <hr />
                                       <div class="address">
                                           <address>
                                              <!-- Company name -->
                                              <strong>OPAC Labs Software Private Limited.</strong><br>
                                              <!-- Address -->
                                              C-78, Sector 63, Noida,UttarPradesh, India - (201301) 
<br>
                                              <!-- Phone number -->
                                              <abbr title="Phone">P:</abbr> (+91)-1204280186.<br> (+91)-9958202825.
                                           </address>
                                            
                                           <address>
                                              <!-- Name -->
                                              <strong>Sales/Enquiry</strong><br>
                                              <!-- Email -->
                                              <a href="mailto:enquiry@opaclabs.com">enquiry@opaclabs.com</a>
                                               <a class="hide" href="mailto:lokendra@opaclabs.com">lokendra@opaclabs.com</a>
                                           </address>
                                       </div>
                                 </div>
                           </div>
                        </div>
                        
                     </div>
                     
                  </div>
               </div>
            </div>
            
            
            <!-- Service ends -->
            
            <!-- CTA starts -->
            
            <div class="cta hide">
               <div class="row">
                  <div class="span9">
                     <!-- First line -->
                     <p class="cbig">Lorem ipsum consectetur dolor sit amet, consectetur adipiscing.</p>
                     <!-- Second line -->
                     <p class="csmall">Duis vulputate consectetur malesuada eros nec odio consect eturegestas et netus et in dictum nisi vehicula.</p>
                  </div>
                  <div class="span2">
                     <!-- Button -->
                     <div class="button"><a href="#">Get A Free Trail</a></div>
                  </div>
               </div>
            </div>
            
            <!-- CTA Ends -->
            
         </div>
      </div>
   </div>
</div>   

<!-- Content ends --> 
