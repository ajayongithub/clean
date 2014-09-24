<?php

Yii::import('application.modules.admin.models._base.BaseUserModel');

class UserModel extends BaseUserModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}