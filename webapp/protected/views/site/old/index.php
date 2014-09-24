      <div class="jumbotron">
        <h1>YClean</h1>
        <p class="lead">Why clean when we can do it for you.</p>
        <a class="btn btn-large btn-success" href="<?=Yii::app()->createUrl("//registration/registration/registration")?>">Get started today</a>
      </div>
<?php
			$user = Yii::app()->user ;
				if(Yum::hasModule('role'))
					if(Yii::app()->user->hasRole('Demo'))
						if(Yum::hasModule('membership')){
							Yii::import('application.modules.membership.models.*');
							$today  = new DateTime();
							$strDate = $today->format('d-m-Y');
							$memCount = YumMembership::model()->count('user_id=:user and end_date>=:end',array(':user'=>$user->id,':end'=>'{$strDate}')) ;
							if($memCount<1){
								$this->redirect(Yii::app()->createUrl("//membership/membership/order"));
							}
						}
								
		?>
      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
          <h2>Our Services</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Our Philosophy</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>YClean Explained</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>
