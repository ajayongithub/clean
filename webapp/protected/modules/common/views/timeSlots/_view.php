<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('slot_name')); ?>:
	<?php echo GxHtml::encode($data->slot_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('slot_begin')); ?>:
	<?php echo GxHtml::encode($data->slot_begin); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('slot_end')); ?>:
	<?php echo GxHtml::encode($data->slot_end); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />

</div>