<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('order_id')); ?>:
	<?php echo GxHtml::encode($data->order_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_id')); ?>:
	<?php echo GxHtml::encode($data->payment_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_issue_date')); ?>:
	<?php echo GxHtml::encode($data->payment_issue_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_confirm_date')); ?>:
	<?php echo GxHtml::encode($data->payment_confirm_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('amount')); ?>:
	<?php echo GxHtml::encode($data->amount); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('payment_type')); ?>:
	<?php echo GxHtml::encode($data->payment_type); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('extra1')); ?>:
	<?php echo GxHtml::encode($data->extra1); ?>
	<br />
	*/ ?>

</div>