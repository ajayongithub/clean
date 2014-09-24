<div class="view">

	<?php //echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php //echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('company_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->company)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('username')); ?>:
	<?php echo GxHtml::encode($data->username); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('lastname')); ?>:
	<?php echo GxHtml::encode($data->lastname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php //echo GxHtml::encode($data->getAttributeLabel('invite_key')); ?>:
	<?php //echo GxHtml::encode($data->invite_key); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('cre_date')); ?>:
	<?php echo GxHtml::encode($data->cre_date); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('remarks')); ?>:
	<?php echo GxHtml::encode($data->remarks); ?>
	<br />
	*/ ?>

</div>