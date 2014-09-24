<?php 
Yii::app()->clientScript->registerCssFile(
		Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('YumAssets').'/css/yum.css'));

$module = Yii::app()->getModule('user');
$this->beginContent($module->baseLayout); ?>

<div id="usermenu">
<?php Yum::renderFlash(); ?>
<?php 
if(Yum::hasModule('message')) {
	Yii::import('application.modules.message.components.*');
	//Changed by Ajay
//	$this->widget('MessageWidget');
}
if(Yum::hasModule('profile') && Yum::module('profile')->enableProfileVisitLogging) {
	Yii::import('application.modules.profile.components.*');
	//Changed by Ajay
//	$this->widget('ProfileVisitWidget'); 
}
	//Changed by Ajay
//$this->renderMenu(); ?>

</div>

<div id="usercontent">
<?php echo $content;  ?>
</div>

<?php $this->endContent(); ?>
