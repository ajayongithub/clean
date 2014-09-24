<?php

Yii::import('application.modules.common.models._base.BaseCompany');

class Company extends BaseCompany
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public static  function getCompanyList($companyId){
		 $criteria = new CDbCriteria;
		 $criteria->condition = 'id = '.$companyId ;
		 $companies = Company::model()->findAll($criteria) ;
		 return  CHtml::listData($companies,'id','company_name');
	}
	public static  function getCompanyName($companyId){
		 $companies = Company::model()->findByPk($companyId);
		 return $companies->company_name;
	}
 	public static function getUsersForCompanies(){
		 $count = Yii::app()->db->createCommand()
		 ->select(' count(*) as numbers, c.company_name ') 
		 ->from(' profile p, company c')
		 ->where(' p.company_id = c.id ')
		 ->order(' numbers DESC, c.company_name ')
		 ->group(' c.company_name ')
		 ->limit(5)
		 ->queryAll();	
		return $count ; 
	}
}