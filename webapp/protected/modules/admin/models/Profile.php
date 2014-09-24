<?php

Yii::import('application.modules.admin.models.._base.BaseProfile');

class Profile extends BaseProfile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}