<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */

	public function accessRules2()
	{
		return array(
		array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('deliveryPractices','industry','contact','technology','mobileSolution','products','news'),
				'users'=>array('*'),
		),
		array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
		),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}


	public function actions()
	{
		return array(
		// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
		),
		// page action renders "static" pages stored under 'protected/views/site/pages'
		// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
		),
		);
	}

	public function actionIndex()
	{

		$this->render('index',array(
		));
	}

	public function actionAbout()
	{

		$this->render('my404',array(
		));
	}


	public function actionSites()
	{

		$this->render('sites',array(
		));
	}


	public function actionIndustry()
	{

		$this->render('industry',array(
		));
	}


	
	public function actionCareers()
	{

		$this->render('careers',array(
		));
	}


	public function actionNews()
	{

		$this->render('news',array(
		));
	}


	public function actionClients()
	{

		$this->render('clients',array(
		));
	}

	public function actionBlogs()
	{

		$this->render('blogs',array(
		));
	}





	public function actionDeliveryPractices()
	{

		$this->render('deliveryPractices',array(
		));
	}

	public function actionProducts()
	{

		$this->render('products',array(
		));
	}



	public function actionTechnology()
	{

		$this->render('technology',array(
		));
	}

	public function actionMobileSolution()
	{

		$this->render('mobileSolution',array(
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	
	/**
	 * 
	 * 
	 * Enter description here ...
	 * 
	 
	  http://www.opaclabs1.com/site/promote?promotion=sites&to=lokendra@opaclabs.com
	 
	 */
	public function actionPromote()
	{
		    

			 $message = new YiiMailMessage;
			 
			$promotion = Yii::app()->params['promotions'][$_REQUEST['promotion']];

			 $body = Yii::app()->controller->renderPartial($promotion['template'], array('user'=>$user, 'model'=>$model), true);

			 $message->setBody($body,'text/html');

			 $message->subject = $promotion['subject'];
			 
			 $message->addTo($_REQUEST['to']);
			 
			 $message->setBcc(array('lokendra3777@gmail.com','lokendra@opaclabs.com','kishan3089@gmail.com','jaipratap111@hotmail.com'
			    ,'greaterakash@gmail.com','kanchansingh42@gmail.com'
			    ,'ajay.aneja@gmail.com','avinash8616@gmail.com'
			    ));
			 //$message->addBcc('lokendra3777@gmail.com,lokendra@opaclabs.com,kishan3089@gmail.com,jaipratap111@hotmail.com');
			 
			 //$message->setBcc(Yii::app()->params['supportTeamEmails']);
			 $message->from = Yii::app()->params['adminEmail'];
			 Yii::app()->mail->send($message);

			 echo "message sent!";
			 Yii::app()->end();
/*
			 $this->redirect(array('update','id'=>$model->_id));

			 Yii::app()->end();
			 $this->render('promote',array(
			 ));*/
	}
	
	
	
	
public function actionContact()
	{
		    

		$model = new ContactForm();
		
		if($_REQUEST['ContactForm']){
			$model->attributes = $_REQUEST['ContactForm'];
			
			if($model->validate()){
		
			 $message = new YiiMailMessage;
			 
			//$promotion = Yii::app()->params['promotions'][$_REQUEST['promotion']];

			// $body = Yii::app()->controller->renderPartial($promotion['template'], array('user'=>$user, 'model'=>$model), true);
			
			 $body = CVarDumper::dumpAsString($model->attributes);

			 $message->setBody($body,'text/html');

			 $message->subject = 'Enquiry from - '.$model->name;
			 
			 $message->addTo(Yii::app()->params['adminEmail']);
			 //$message->addCc(array('lokendra3777@gmail.com','lokendra@opaclabs.com,kishan3089@gmail.com','jaipratap111@hotmail.com'));
			 $message->setBcc(Yii::app()->params['supportTeamEmails']);
			 $message->from = Yii::app()->params['adminEmail'];
			 Yii::app()->mail->send($message);
			 
			 
			 Yii::app()->user->setFlash('success', "Thank you. We have received your message!");

			 //echo "message sent!";
			 //Yii::app()->end();
			}else{
				 Yii::app()->user->setFlash('error', "You have errors in form!");
			}
			}
/*
			 $this->redirect(array('update','id'=>$model->_id));

			 Yii::app()->end();
			 $this->render('promote',array(
			 ));*/
			
			$this->render('contact',array('model'=>$model));
	}
	
	public function actionLanguage(){	
		Yii::log('Setting language');
		Yii::app()->language='fr';
		// if (isset($_REQUEST['language']))
         //   Yii::app()->user->setState('applicationLanguage',$_POST['language']);
		//Yii::log('Set language');
        $this->redirect($_REQUEST['url']);
		Yii::log('Redirected language');
	}
	
}
