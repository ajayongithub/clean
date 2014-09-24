<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('loc_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->loc)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('sched_date')); ?>:
	<?php echo GxHtml::encode($data->sched_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('recurrence')); ?>:
	<?php echo GxHtml::encode($data->recurrence); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('day')); ?>:
	<?php echo GxHtml::encode($data->day); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ts_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->ts)); ?>
	<br />

</div>