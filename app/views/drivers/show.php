<h2><?php echo $object->__name; ?></h2>
<table class="model-show">
	<tr>
		<td class="label">Address</td>
		<td class="data"><?php echo $object->address ?></td>
	</tr>
	<tr>
		<td class="label">Phone Number</td>
		<td class="data"><?php echo $object->phone_no ?></td>
	</tr>
	<tr>
		<td class="label">Bank Name</td>
		<td class="data"><?php echo $object->bank_name ?></td>
	</tr>
	<tr>
		<td class="label">Account Number</td>
		<td class="data"><?php echo $object->account_no ?></td>
	</tr>
	<tr>
		<td class="label">Motorboy</td>
		<td class="data"><?php echo ($object->motorboy) ? $this->truckfleet->back_to_model_public_link($object->motorboy) : 'Not Set' ?></td>
	</tr>
	<tr>
		<td class="label">License URL</td>
		<td class="data"><?php echo $this->html->link($object->license, $object->license) ?></td>
	</tr>
	<tr>
		<td class="label">Passport</td>
		<td><img src=<?php echo $object->passport ?> ></td>
	</tr>
	<tr>
		<td class="label">Reference Name</td>
		<td class="data"><?php echo $object->reference_name ?></td>
	</tr>
	<tr>
		<td class="label">Reference Phone</td>
		<td class="data"><?php echo $object->reference_phone ?></td>
	</tr>
	<tr>
		<td class="label">Next of Kin Name</td>
		<td class="data"><?php echo $object->next_of_kin_name ?></td>
	</tr>
	<tr>
		<td class="label">Next of Kin Phone</td>
		<td class="data"><?php echo $object->next_of_kin_phone ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Drivers', array('controller' => 'drivers')); ?>
</p>