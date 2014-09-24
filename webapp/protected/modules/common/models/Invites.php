<?php

Yii::import('application.modules.common.models._base.BaseInvites');

class Invites extends BaseInvites
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}