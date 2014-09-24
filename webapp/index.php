<?php

// change the following paths if necessary
//$yii=dirname(__FILE__).'/framework/yii.php';
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
 defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
$app = Yii::createWebApplication($config) ;
//Yii::import('application.vendors.*');
//require_once "phpexcel/PHPExcel.php";
//require_once "phpexcel/PHPExcel/Autoloader.php";
//Yii::registerAutoloader(array('PHPExcel_Autoloader','Load'), true);
//PHPExcel_Shared_ZipStreamWrapper::register();
Yii::import('ext.yiiexcel.YiiExcel',true);
Yii::registerAutoloader(array('YiiExcel','autoload'),true);
/*PHPExcel_Shared_ZipStreamWrapper::register();
if (ini_get('mbstring.func_overload') & 2) {
          throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
       }
	      PHPExcel_Shared_String::buildCharacterSets();
*/
$app->run();
