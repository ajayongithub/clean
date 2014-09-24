<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('username')); ?>:
	<?php echo GxHtml::encode($data->username); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('password')); ?>:
	<?php echo GxHtml::encode($data->password); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('salt')); ?>:
	<?php echo GxHtml::encode($data->salt); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('activationKey')); ?>:
	<?php echo GxHtml::encode($data->activationKey); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('createtime')); ?>:
	<?php echo GxHtml::encode($data->createtime); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('lastvisit')); ?>:
	<?php echo GxHtml::encode($data->lastvisit); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('lastaction')); ?>:
	<?php echo GxHtml::encode($data->lastaction); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('lastpasswordchange')); ?>:
	<?php echo GxHtml::encode($data->lastpasswordchange); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('superuser')); ?>:
	<?php echo GxHtml::encode($data->superuser); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
	<?php echo GxHtml::encode($data->status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('avatar')); ?>:
	<?php echo GxHtml::encode($data->avatar); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('notifyType')); ?>:
	<?php echo GxHtml::encode($data->notifyType); ?>
	<br />
	*/ ?>

</div>