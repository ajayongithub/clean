<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('location_address')); ?>:
	<?php echo GxHtml::encode($data->location_address); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('location_no')); ?>:
	<?php echo GxHtml::encode($data->location_no); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('location_zipcode')); ?>:
	<?php echo GxHtml::encode($data->location_zipcode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('location_city')); ?>:
	<?php echo GxHtml::encode($data->location_city); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />

</div>