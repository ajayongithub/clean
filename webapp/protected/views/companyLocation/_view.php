<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('company_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->company)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('location_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->location)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('start_date')); ?>:
	<?php echo GxHtml::encode($data->start_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('end_date')); ?>:
	<?php echo GxHtml::encode($data->end_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remark')); ?>:
	<?php echo GxHtml::encode($data->remark); ?>
	<br />

</div>