<?php

Yii::import('application.modules.planning.models._base.BaseRoster');

class Roster extends BaseRoster
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static function deletePreviousScheduleEntry($id){
		Yii::app()->db->createCommand('delete from roster where sched_id = '.$id)->execute();
		return ;
	}
}