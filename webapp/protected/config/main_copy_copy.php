<?php
require_once(dirname(__FILE__) . '/system.config.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'YClean',

// preloading 'log' component
	'preload'=>array('log'),

// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.controllers.*',
        'ext.YiiMongoDbSuite.*',
        'ext.AweCrud.components.*',
 'application.extensions.yii-mail.*',
 'application.extensions.When-master.*',
 'application.extensions.recur.*',
 'application.extensions.AweCrud.components.*',
 'application.extensions.yiiext.behaviors.*',
 'application.models.*',
            'application.components.*',
            'ext.giix-components.*', // giix components
            'application.modules.user.models.*',
            'application.models.*',
            'application.modules.common.models.*',
            'application.components.*',
            'application.modules.user.components.*',
            'application.modules.role.models.*',
            'application.modules.profile.models.*',
            'application.modules.profile.components.*',
            'application.modules.common.controllers.*',
            'application.modules.reservation.models.*',
            'application.modules.profile.components.Widgets.*',
            'bootstrap.helpers.TbHtml',
         'application.vendors.phpexcel.PHPExcel', 
         'application.vendors.phpexcel.PHPExcel.*', 
),

	'defaultController'=>'site',

	'modules' => array(
				'registration' => array(),
				'ycleanapp' => array(),
				'admin' => array(),
				'planning' => array(),
				'common' => array(),
       			'signup'=>array(),
        'testMod'=>array(),
        'reservation'=>array(),
        'avatar' => array(),
				'user' => array(
					'debug' => false,
					'userTable' => 'user',
					'translationTable' => 'translation',
					'mailer'=>'PHPMailer',
					'phpmailer'=>array(
						'transport'=>'smtp',
						'html'=>true,
						'properties'=>array(
							'CharSet' => 'UTF-8',
            //  'Host' => 'smtp.office365.com', // SMTP server 
              'Host' => 'relay-hosting.secureserver.net', // SMTP server 
              //'Host' => 'smtpout.europe.secureserver.com', // SMTP server 
					//		 'SMTPDebug' => TRUE,     // enables SMTP debug information (for testing)
							 //'SMTPAuth' => true,        // enable SMTP authentication
               //'SMTPSecure' => 'ssl',         // sets the prefix to the servier
							 //'Host' => 'smtp.office365.com',    // sets GMAIL as the SMTP server
							// 'Port' => 465,                   // set the SMTP port for the GMAIL server
							 'Username' => 'cs@yclean.nl',  // GMAIL username
							 'Password' => 'Ajay2013', 
						),
						'msgOptions'=>array(
               'fromName'=>'Registration System',
               'toName'=>'Invited User',
            ),
					),
				),
'usergroup' => array(
'usergroupTable' => 'usergroup',
'usergroupMessageTable' => 'user_group_message',
),
'membership' => array(
'membershipTable' => 'membership',
'paymentTable' => 'payment',
),
'friendship' => array(
'friendshipTable' => 'friendship',
),
'profile' => array(
'privacySettingTable' => 'privacysetting',
'profileFieldTable' => 'profile_field',
'profileTable' => 'profile',
'profileCommentTable' => 'profile_comment',
'profileVisitTable' => 'profile_visit',
),
'role' => array(
'roleTable' => 'role',
'userRoleTable' => 'user_role',
'actionTable' => 'action',
'permissionTable' => 'permission',
),
'message' => array(
'messageTable' => 'message',
),
// uncomment the following to enable the Gii tool
'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',

			'generatorPaths'=>array(
		     		'ext.giix-core',
            'ext.gtc' ,// a path alias,
            'ext.YiiMongoDbSuite.gii',
            'ext.bootstrap.gii', // Since 0.9.1
			'ext.AweCrud.generators',
			'bootstrap.gii',

				),

//'ipFilters'=>array('127.0.0.1','::1'),
         'newFileMode'=>0666,
         'newDirMode'=>0777,


	),
),

// application components
	'components'=>array(

'cache' => array(
 //               'class' => 'system.caching.CFileCache',
               'class' => 'system.caching.CDummyCache',
),
//'messages'=>array(
//	'extensionPaths' => array(
//				'AweCrud'=>'application.extensions.AweCrud.messages'
//				),
//),
	'user'=>array(
      'class' => 'application.modules.user.components.YumWebUser',
      'allowAutoLogin'=>true,
      'loginUrl' => array('//user/user/login'),

),
		'user2'=>array(
// enable cookie-based authentication
			'allowAutoLogin'=>true,
),
/*'db2'=>array(
 'connectionString' => 'sqlite:protected/data/blog.db',
 'tablePrefix' => 'tbl_',
 ),*/
'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),

		'db' => array(
               // 'connectionString' => 'mysql:host=localhost;dbname=yclean',
                'connectionString' => 'mysql:host=188.121.40.218;dbname=yclean',
                'emulatePrepare' => true,
                'username' => 'yclean',
                'password' => 'Yclean@123!',
                'charset' => 'utf8',
                'tablePrefix' => '',
),
// uncomment the following to use a MySQL database
/*
 'db'=>array(
 'connectionString' => 'mysql:host=localhost;dbname=blog',
 'emulatePrepare' => true,
 'username' => 'root',
 'password' => '',
 'charset' => 'utf8',
 'tablePrefix' => 'tbl_',
 ),
 */
		'errorHandler'=>array(
// use 'site/error' action to display errors
			'errorAction'=>'site/error',
),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'view/<view:\w+>'=>'site/page',
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
),
),


			'mail' => array(
        'class' => 'application.extensions.yii-mail.YiiMail',
        'transportType'=>'smtp', /// case sensitive!
        'transportOptions'=>array(
           'host'=>'smtp.office365.com',
            'username'=>'cs@yclean.nl',
			'password'=>'Ajay2013',


//'username'=>'no-reply@makersbay.com',
// or email@googleappsdomain.com
//'password'=>'no-reply@123!',
            'port'=>'587',
            'encryption'=>false,//'ssl',
),
        'viewPath' => 'application.views.mail',
        'logging' => true,
        'dryRun' => false
),
/*'db'=>array(
 'connectionString' => 'mysql:host=localhost;dbname=opaclabs1',
 'emulatePrepare' => true,
 'username' => 'root',
 'password' => 'mkb@123!',
 'charset' => 'utf8',
 'enableParamLogging' => true,
 'schemaCachingDuration' => 1,
 'tablePrefix' => 'tbl_',
 ),*/

			'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
array(
					'class'=>'CFileLogRoute',
					 'levels'=>'error, warning',
					 'logFile'=>'myerors.txt',
),
array(
					'class'=>'CFileLogRoute',
					 'levels'=>'trace, info',
					 'logFile'=>'mytrace.txt',
),
// uncomment the following to show log messages on web pages
/**
 array(
 'class'=>'CWebLogRoute',
 //
 // I include *trace* for the
 // sake of the example, you can include
 // more levels separated by commas
 'levels'=>'trace',
 //
 // I include *vardump* but you
 // can include more separated by commas
 //'categories'=>'application,vardump',
 //
 // This is self-explanatory right?
 'showInFireBug'=>true

 )**/
),
),


			 'mongodb' => array(
        'class'            => 'EMongoDB',
//mongodb://fred:foobar@localhost/baz
        'connectionString' => 'mongodb://localhost',
        'dbName'           => 'testme',
        'fsyncFlag'        => true,
        'safeFlag'         => true,
        'useCursor'        => false
),

      'dbService' => array(
           'class'            => 'DbService',

),

	'clientScript'=>array(
						'packages'=>array(
								'jquery'=>array(
									'baseUrl' => Yii::app()->request->baseUrl.'/js',
						//			'js'=>array('jquery.1.8.2.min.js'),
									'js'=>array('jquery.js'),
									)
							)
					),

),

// application-level parameters that can be accessed
// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
