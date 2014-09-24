<?
if(empty($tabularIdx))
{

	$this->breadcrumbs = array(
			Yum::t('Users')=>array('index'),
			$model->username=>array('view','id'=>$model->id),
			Yum::t('Update'));
}

echo $this->renderPartial('_userForm', array(
			'model'=>$model,
			'passwordform'=>$passwordform,
			'changepassword' => isset($changepassword) ? $changepassword : false,
			'profile'=>$profile,
			'tabularIdx'=> isset($tabularIdx) ? $tabularIdx : 0)
		);
?>
