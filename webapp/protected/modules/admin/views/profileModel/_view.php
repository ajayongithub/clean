<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('user_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->user)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('timestamp')); ?>:
	<?php echo GxHtml::encode($data->timestamp); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('privacy')); ?>:
	<?php echo GxHtml::encode($data->privacy); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('lastname')); ?>:
	<?php echo GxHtml::encode($data->lastname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('firstname')); ?>:
	<?php echo GxHtml::encode($data->firstname); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('show_friends')); ?>:
	<?php echo GxHtml::encode($data->show_friends); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('allow_comments')); ?>:
	<?php echo GxHtml::encode($data->allow_comments); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
	<?php echo GxHtml::encode($data->email); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('street')); ?>:
	<?php echo GxHtml::encode($data->street); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('city')); ?>:
	<?php echo GxHtml::encode($data->city); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('about')); ?>:
	<?php echo GxHtml::encode($data->about); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('initials')); ?>:
	<?php echo GxHtml::encode($data->initials); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('telephone_work')); ?>:
	<?php echo GxHtml::encode($data->telephone_work); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('telephone_private')); ?>:
	<?php echo GxHtml::encode($data->telephone_private); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('address_zipcode')); ?>:
	<?php echo GxHtml::encode($data->address_zipcode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('company_name')); ?>:
	<?php echo GxHtml::encode($data->company_name); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('company_address')); ?>:
	<?php echo GxHtml::encode($data->company_address); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('company_zipcode')); ?>:
	<?php echo GxHtml::encode($data->company_zipcode); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('company_city')); ?>:
	<?php echo GxHtml::encode($data->company_city); ?>
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
	<?php echo GxHtml::encode($data->getAttributeLabel('car_type')); ?>:
	<?php echo GxHtml::encode($data->car_type); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('car_lease_company')); ?>:
	<?php echo GxHtml::encode($data->car_lease_company); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('car_number_plate')); ?>:
	<?php echo GxHtml::encode($data->car_number_plate); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('company_id')); ?>:
	<?php echo GxHtml::encode($data->company_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('location_id')); ?>:
	<?php echo GxHtml::encode($data->location_id); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('bank_account')); ?>:
	<?php echo GxHtml::encode($data->bank_account); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('profile_complete_status')); ?>:
	<?php echo GxHtml::encode($data->profile_complete_status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('country')); ?>:
	<?php echo GxHtml::encode($data->country); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('bank_name')); ?>:
	<?php echo GxHtml::encode($data->bank_name); ?>
	<br />
	*/ ?>

</div>