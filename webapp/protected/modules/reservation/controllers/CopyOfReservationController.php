<?php

class ReservationController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view'),
				'roles'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'roles'=>array('UserCreator'),
				),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
			//array('deny', 
			//	'users'=>array('*'),
			//	),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Reservations'),
		));
	}

	public function actionCreate() {
		$model = new Reservations;

		$this->performAjaxValidation($model, 'reservations-form');

		if (isset($_POST['Reservations'])) {
			$model->setAttributes($_POST['Reservations']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Reservations');

		$this->performAjaxValidation($model, 'reservations-form');

		if (isset($_POST['Reservations'])) {
			$model->setAttributes($_POST['Reservations']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Reservations')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	private function getSchedulesForLocation($companyId,$locId,$user){
		 $locSchedules = Yii::app()->db->createCommand()
		 ->select(' ls.id, ls.sched_date ,ts.slot_name, ts.slot_begin, ts.slot_end  ')
		 ->from(' location_schedule ls, time_slots ts ')
		 ->where('ls.ts_id = ts.id and ls.loc_id = '.$locId.' and ls.company_id='.$companyId.' and ls.sched_date > CURRENT_DATE and ls.sched_date < CURRENT_DATE + 60 and '
		        .' ls.id not in (select schedule_id from reservations where user_id = '.$user. ' and status = "Reserved" ) ' )
		 ->order(' ls.sched_date asc ')
		 ->queryAll();		
		 return $locSchedules ;
	}
	private function getReservationHistory($user){
		 $history = Yii::app()->db->createCommand()
		 ->select(' ls.sched_date,ts.slot_name ,r.reserved_on, r.status,r.id  ')
		 ->from(' location_schedule ls, reservations r, time_slots ts ')
		 ->where(' ls.ts_id = ts.id and ls.id = r.schedule_id and r.user_id = '.$user)
		 ->order(' ls.sched_date desc ')
		 ->queryAll();		
		 return $history ;	
	}
	private function getProfileStatus($userId){
		
		return  Yii::app()->db->createCommand()
		 ->select('  profile_complete_status, car_make, car_model, car_color, car_number_plate, location_id,company_id ')
		 ->where('user_id = '.$userId)
		 ->from(' profile ')
		 ->queryAll();	
	}
	public function actionIndex() {
		$this->layout = "//layouts/userLayout" ;
		$dataProvider = new CActiveDataProvider('Reservations');

		$id = Yii::app()->user->id;
		$profileStatus = $this->getProfileStatus($id);
		$locationId = $profileStatus[0]['location_id'];
		$companyId = $profileStatus[0]['company_id'];
		$locationName = MasterLocations::getLocationNameFromId($locationId) ;
		//check for status  created, mandate generated, ideal payment on, 
		 if(strcmp($profileStatus[0]['profile_complete_status'],'Created')==0){
		 	$this->redirect(array('/reservation/subscription/order'),true);
		 }
		 if(strcmp($profileStatus[0]['profile_complete_status'],'Mandate Generated')==0){
		 	$this->redirect(array('/reservation/subscription/order'),true);
		 }
		 if(empty($profileStatus[0]['car_make'])||
		 	(empty($profileStatus[0]['car_model']))||
		 	(empty($profileStatus[0]['car_color']))||
		 	(empty($profileStatus[0]['car_number_plate']))){
		 			$this->redirect(array('/reservation/account/update'),true);
		 	}else{	
			//check for expiry of subscription here
			$reservations = $this->getReservationHistory($id);
			$lsched = $this->getSchedulesForLocation($companyId,$locationId,$id);
			$this->render('index', array(
					'history' => $reservations,
					'location' => $locationName,
					'newSched' => $lsched
			));
		 	}
	
	}
	public function actionCancel(){
		if(isset($_POST['id'])){
			$schedId = $_POST['id'] ;
			$reserve = Reservations::model()->findByPk($schedId) ;
			$reserve->status = 'Cancelled';
			$now = new DateTime('now');
			$reserve->last_status_changed_on = $now->format('Y-m-d H:i') ;
			$reserve->changed_by = 'You';
			if($reserve->save())
				$this->redirect('index');
			else throw CHttpException(920,"Unable to reserve.");
		}
	}
	public function actionReserve(){
		if(isset($_POST['id'])){
			$schedId = $_POST['id'] ;
			$reserve = new Reservations ;
			$reserve->user_id = Yii::app()->user->id ;
			$reserve->schedule_id = $schedId ;
			$reserve->status = 'Reserved';
			$now = new DateTime('now');
			$reserve->reserved_on = $now->format('Y-m-d H:i') ;
			$reserve->changed_by = 'You';
			if($reserve->save())
				$this->redirect('index');
			else throw CHttpException(920,"Unable to reserve.");
		}
	}
	public function actionAdmin() {
		$model = new Reservations('search');
		$model->unsetAttributes();

		if (isset($_GET['Reservations']))
			$model->setAttributes($_GET['Reservations']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}