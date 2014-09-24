<?php

Yii::import('application.modules.common.models._base.BaseTimeSlots');

class TimeSlots extends BaseTimeSlots
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}