  <!-- content -->
  <section id="page">
    <header class="page-header">
      <div class="container">
        <div class="row">
          <div class="span12">
            <h1>404</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- main content -->
    <section id="pageContent">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="hero-unit hero-color">
              <h1>Ouch!!! Error</h1><br/>
               <h3>An error has occurred</h3> 
                <?php if($error=Yii::app()->errorHandler->error){?>
              <p>The operation you were attempting has returned an error.  </p>
              <p>Error Details : <?php //print_r( $error); ?>.  </p>
              <p>Error type is : <?php echo $error['type']; ?>.  </p>
              <p>Error Number is : <?php echo $error['code']; ?>.  </p>
              <p>Error Description is :  <?php echo $error['message']; ?>.  </p>
              <p>Error file is :  <?php echo $error['file']; ?>.  </p>
              <p>Error line is :  <?php echo $error['line']; ?>.  </p>
              <p>Error Trace is :  <?php echo $error['trace']; ?>.  </p>
              <?php //echo $error['trace']; ?>.
              <?php }?>
              <a href="/index.html" class="btn btn-large btn-inverse">Back to homepage</a> </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end main content -->
  </section>
  <!-- end content -->
