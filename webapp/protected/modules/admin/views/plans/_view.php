<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('plan_name')); ?>:
	<?php echo GxHtml::encode($data->plan_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('plan_cost')); ?>:
	<?php echo GxHtml::encode($data->plan_cost); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('plan_duration')); ?>:
	<?php echo GxHtml::encode($data->plan_duration); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />

</div>