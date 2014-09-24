<?php

Yii::import('application.modules.reservation.models._base.BasePaymentDetails');

class PaymentDetails extends BasePaymentDetails
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getLatestPayments(){
		 $payments = Yii::app()->db->createCommand()
		 ->select(' p.order_id as order, p.payment_type as type ,p.amount as amt ')
		 ->from(' payment_details p ')
		 ->order(' p.payment_issue_date DESC ')
		 ->limit(5)
		 ->queryAll();	
		return $payments ; 
	}	
}