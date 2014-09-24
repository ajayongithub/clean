<?php

Yii::import('application.modules.testMod.models._base.BaseCompanyLocation');

class CompanyLocation extends BaseCompanyLocation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}