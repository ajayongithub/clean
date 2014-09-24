<?php

Yii::import('application.modules.admin.models.._base.BaseAdminProfile');

class AdminProfile extends BaseAdminProfile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}