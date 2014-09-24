<?php

Yii::import('application.modules.admin.models._base.BaseProfileModel');

class ProfileModel extends BaseProfileModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}