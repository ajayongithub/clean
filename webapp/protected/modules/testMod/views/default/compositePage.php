	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

<form id='cityForm' method='POST'>
<?php
	echo Yum::t('Please Select a city') ;
	echo CHtml::dropDownList('cityName','',$cities,
			array(
			'prompt'=>'Select a city',
			'ajax' => array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('default/getCityLocations'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#locationName', //selector to update
					'data'=>array('city'=>'js:$("#cityName option:selected").val()'),
					//leave out the data key to pass all form values through
				)
			)
		);

?></form>
	<br/>
<form id='locationForm' method='POST'>
<?php	echo Yum::t('Please Select a location') ;
	echo CHtml::dropDownList('locationName',null,array(''=>''),
					array(
						'ajax'=>array(
							'type'=>'POST',
							'url'=>CController::createUrl("default/getScheduleRules"),
							'update'=>'#rulesGrid',
							'data'=>array('locId'=>'js:$("#locationName option:selected").val()'),
							),
						)
			) ;
?></form>
<div id="rulesGrid">
</div>
<?php 
	echo CHtml::button('Preview Dates',array(
				'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl("default/getList"),
					'update'=>'#dateGrid',
					'data'=>array('locId'=>'js:$("#locationName option:selected").val()'),
					)
			));
?>
<div id="dateGrid"></div>
