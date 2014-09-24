<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('emp_num')); ?>:
	<?php echo GxHtml::encode($data->emp_num); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_name')); ?>:
	<?php echo GxHtml::encode($data->emp_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_init')); ?>:
	<?php echo GxHtml::encode($data->emp_init); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_last_name')); ?>:
	<?php echo GxHtml::encode($data->emp_last_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_gender')); ?>:
	<?php echo GxHtml::encode($data->emp_gender); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_phone_no')); ?>:
	<?php echo GxHtml::encode($data->emp_phone_no); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_email')); ?>:
	<?php echo GxHtml::encode($data->emp_email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_driving_license')); ?>:
	<?php echo GxHtml::encode($data->emp_driving_license); ?>
	<br />
	<?php */echo GxHtml::encode($data->getAttributeLabel('emp_base_location')); ?>:
	<?php echo GxHtml::encode($data->emp_base_location); ?>
	<br />
	<?php /*echo GxHtml::encode($data->getAttributeLabel('emp_working_days')); ?>:
	<?php echo GxHtml::encode($data->emp_working_days); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_work_hr_begin')); ?>:
	<?php echo GxHtml::encode($data->emp_work_hr_begin); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_work_hr_end')); ?>:
	<?php echo GxHtml::encode($data->emp_work_hr_end); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_designation')); ?>:
	<?php echo GxHtml::encode($data->emp_designation); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_contract_end_date')); ?>:
	<?php echo GxHtml::encode($data->emp_contract_end_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('emp_ex1')); ?>:
	<?php echo GxHtml::encode($data->emp_ex1); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('sunday')); ?>:
	<?php echo GxHtml::encode($data->sunday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('monday')); ?>:
	<?php echo GxHtml::encode($data->monday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('tuesday')); ?>:
	<?php echo GxHtml::encode($data->tuesday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('wednesday')); ?>:
	<?php echo GxHtml::encode($data->wednesday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('thursday')); ?>:
	<?php echo GxHtml::encode($data->thursday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('friday')); ?>:
	<?php echo GxHtml::encode($data->friday); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('saturday')); ?>:
	<?php echo GxHtml::encode($data->saturday); ?>
	<br />

	*/
	echo  CHtml::link("Back",Yii::app()->createUrl("planning/employees/admin"),array("class"=>"btn"))
	?>

</div>