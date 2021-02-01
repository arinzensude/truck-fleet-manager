<h2><?php echo 'Route: '.$object->__name; ?></h2>
<table class="model-show">
	<tr>
		<td class="label">Client</td>
		<td class="data"><?php echo $this->truckfleet->back_to_model_public_link($object->client) ?></td>
	</tr>
	<tr>
		<td class="label">Driver Allowance (NGN)</td>
		<td class="data"><?php echo $object->driver_allowance ?></td>
	</tr>
	<tr>
		<td class="label">Motorboy Allowance (NGN)</td>
		<td class="data"><?php echo $object->motorboy_allowance ?></td>
	</tr>
	<tr>
		<td class="label">Trip Allowance (NGN)</td>
		<td class="data"><?php echo $object->trip_allowance ?></td>
	</tr>
	<?php foreach($types as $type) {?>
		<tr>
			<td class="label"><?php echo $type->name ?> (Litres of Fuel)</td>
			<td class="data"><?php echo $type->value ?></td>
		</tr>
	<?php }?>
	<tr>
		<td class="label">Price (NGN)</td>
		<td class="data"><?php echo $object->price ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Routes', array('controller' => 'routes')); ?>
</p>