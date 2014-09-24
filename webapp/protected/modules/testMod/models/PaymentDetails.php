<?php

Yii::import('application.modules.testMod.models._base.BasePaymentDetails');

class PaymentDetails extends BasePaymentDetails
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}