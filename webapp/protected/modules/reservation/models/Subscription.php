<?php

Yii::import('application.modules.reservation.models._base.BaseSubscription');

class Subscription extends BaseSubscription
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static  function startSubscription($order,$payment,$profile){
		$plan = Plans::model()->findByPk($order->plan_id) ;
		$subscribe = new Subscription() ;
		$subscribe->amount = $payment->amount;
		$nowDate = date('Y-m-d') ;
		$expiryDate = strtotime('+12 months');
		
		$subscribe->expiry_date = date('Y-m-d',$expiryDate) ;
		$subscribe->plan_id = $order->plan_id ;
		$subscribe->start_date = $nowDate ;
		$subscribe->user_id = $profile->user_id ;
		$subscribe->service_number = 0 ;
		if($subscribe->save()){
			$profile->profile_complete_status="Subscribed";
			$profile->save();
			Yii::log("Profile updated");
		//$body = "Your subscription has been started. Welcome to YClean." ;
		//YMailerController::sendMail($profile->email, 'cs@yclean.nl', $subject, $body, null,null);
		YMailerController::sendActivationMail($profile,$order,$payment);
		}
	}
}