<div class="span6 align-center mt30">
<h2><?php echo Yii::t('feedback','Please post your feedback');?></h2>
<h5></h5>
	<div class="form">
		<form id="feedback-form" method="post">
			<label><?php echo Yii::t('feedback','Feedback Type');?></label>
			<select id="feedback-type" name="Feedback[fbType]">
				<option value="General"><?php echo Yii::t('feedback','General');?></option>
				<option value="Payment"><?php echo Yii::t('feedback','Payment');?></option>
				<option value="Service"><?php echo Yii::t('feedback','Service');?></option>
				<option value="Other"><?php echo Yii::t('feedback','Other');?></option>
			</select><br/>
			<label><?php echo Yii::t('feedback','Feedback').'('.Yii::t('feedback','max length 500 characters').')';?></label>
			<textarea maxlength="500" name="Feedback[fbMessage]"></textarea><br/>
			<input type="submit"  value="<?php echo Yii::t('feedback','Post'); ?>" class="btn"/>
		</form>	
	</div>

</div>