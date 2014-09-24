<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('number_plate')); ?>:
	<?php echo GxHtml::encode($data->number_plate); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('car_make')); ?>:
	<?php echo GxHtml::encode($data->car_make); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('car_model')); ?>:
	<?php echo GxHtml::encode($data->car_model); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('car_color')); ?>:
	<?php echo GxHtml::encode($data->car_color); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('base_city')); ?>:
	<?php echo GxHtml::encode($data->base_city); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('leasing_company')); ?>:
	<?php echo GxHtml::encode($data->leasing_company); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('lease_expires_on')); ?>:
	<?php echo GxHtml::encode($data->lease_expires_on); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('extra')); ?>:
	<?php echo GxHtml::encode($data->extra); ?>
	<br />
	*/ ?>

</div>