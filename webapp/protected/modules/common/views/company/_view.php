<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('company_name')); ?>:
	<?php echo GxHtml::encode($data->company_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ho_address')); ?>:
	<?php echo GxHtml::encode($data->ho_address); ?>
	<br />
	<?php //echo GxHtml::encode($data->getAttributeLabel('ho_number')); ?>:
	<?php //echo GxHtml::encode($data->ho_number); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ho_zipcode')); ?>:
	<?php echo GxHtml::encode($data->ho_zipcode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ho_city')); ?>:
	<?php echo GxHtml::encode($data->ho_city); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('contact_firstname')); ?>:
	<?php echo GxHtml::encode($data->contact_firstname); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('contact_init')); ?>:
	<?php echo GxHtml::encode($data->contact_init); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('contact_lastname')); ?>:
	<?php echo GxHtml::encode($data->contact_lastname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('contact_email')); ?>:
	<?php echo GxHtml::encode($data->contact_email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('extra_column')); ?>:
	<?php echo GxHtml::encode($data->extra_column); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('start_date')); ?>:
	<?php echo GxHtml::encode($data->start_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('end_date')); ?>:
	<?php echo GxHtml::encode($data->end_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('duration')); ?>:
	<?php echo GxHtml::encode($data->duration); ?>
	<br />
	*/ ?>

</div>