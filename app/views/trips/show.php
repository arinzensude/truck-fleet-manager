<h2><?php echo 'Trip: '.$object->__name; ?></h2>
<table class="model-show">
	<tr>
		<td class="label">Invoice No</td>
		<td class="data"><?php echo $object->invoice_no ?></td>
	</tr>
	<tr>
		<td class="label">Invoice Date</td>
		<td class="data"><?php echo $object->invoice_date ?></td>
	</tr>
	<tr>
		<td class="label">Truck</td>
		<td class="data"><?php echo $this->truckfleet->back_to_model_public_link($object->truck) ?></td>
	</tr>
	<tr>
		<td class="label">Driver</td>
		<td class="data"><?php echo $this->truckfleet->back_to_model_public_link($object->driver) ?></td>
	</tr>
	<tr>
		<td class="label">Client</td>
		<td class="data"><?php echo $this->truckfleet->back_to_model_public_link($object->client) ?></td>
	</tr>
	<tr>
		<td class="label">Route</td>
		<td class="data"><?php echo $this->truckfleet->back_to_model_public_link($object->route) ?></td>
	</tr>
	<tr>
		<td class="label">Quantity</td>
		<td class="data"><?php echo $object->quantity ?></td>
	</tr>
	<tr>
		<td class="label">Rate</td>
		<td class="data"><?php echo $object->rate ?></td>
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
	<tr>
		<td class="label">Fuel per Litre (NGN)</td>
		<td class="data"><?php echo $object->fuel_per_litre ?></td>
	</tr>
	<tr>
		<td class="label">Total Fuel Cost (NGN)</td>
		<td class="data"><?php echo $object->total_fuel_cost ?></td>
	</tr>
	<tr>
		<td class="label">Price (NGN)</td>
		<td class="data"><?php echo $object->price ?></td>
	</tr>
	<tr>
		<td class="label">Total Price (NGN)</td>
		<td class="data"><?php echo $object->total_price ?></td>
	</tr>
	<tr>
		<td class="label">Other Expenses (NGN)</td>
		<td class="data"><?php echo $object->other_expenses ?></td>
	</tr>
	<tr>
		<td class="label">Other Expenses Description</td>
		<td class="data"><?php echo $object->other_expenses_description ?></td>
	</tr>
	<tr>
		<td class="label">Amount Paid (NGN)</td>
		<td class="data"><?php echo $object->amount_paid ?></td>
	</tr>
	<tr>
		<td class="label">Is Paid in Full?</td>
		<td class="data"><?php echo ($object->paid_in_full == 0) ? 'No' : 'Yes' ?></td>
	</tr>
	<tr>
		<td class="label">Is Complete?</td>
		<td class="data"><?php echo ($object->complete == 0) ? 'No' : 'Yes' ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Trips', array('controller' => 'trips')); ?>
</p>