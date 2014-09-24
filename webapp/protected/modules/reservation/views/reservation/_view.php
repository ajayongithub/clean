<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
	<?php echo GxHtml::encode($data->user_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('schedule_id')); ?>:
	<?php echo GxHtml::encode($data->schedule_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('reserved_on')); ?>:
	<?php echo GxHtml::encode($data->reserved_on); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('changed_by')); ?>:
	<?php echo GxHtml::encode($data->changed_by); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('e1')); ?>:
	<?php echo GxHtml::encode($data->e1); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('e2')); ?>:
	<?php echo GxHtml::encode($data->e2); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('last_status_changed_on')); ?>:
	<?php echo GxHtml::encode($data->last_status_changed_on); ?>
	<br />
	*/ ?>

</div>