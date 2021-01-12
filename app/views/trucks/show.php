<h2><?php echo 'Truck: '.$object->__name; ?></h2>
<table class="model-show">
	<tr>
		<td class="label">Model</td>
		<td class="data"><?php echo $object->model ?></td>
	</tr>
	<tr>
		<td class="label">Year</td>
		<td class="data"><?php echo $object->year ?></td>
	</tr>
	<tr>
		<td class="label">Image URL</td>
		<td class="data"><?php echo $this->html->link($object->image, $object->image) ?></td>
	</tr>
	<tr>
		<td class="label">Plate Number</td>
		<td class="data"><?php echo $object->plate_no ?></td>
	</tr>
	<tr>
		<td class="label">Particulars URL</td>
		<td class="data"><?php echo $this->html->link($object->particulars, $object->particulars) ?></td>
	</tr>
	<tr>
		<td class="label">Particulars Expiry Date</td>
		<td class="data"><?php echo $object->particulars_expiry ?></td>
	</tr>
	<tr>
		<td class="label">Capital Expenditure</td>
		<td class="data"><?php echo $object->capital_expenditure ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $delete_link ?></td>
	</tr>
	<tr>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Trucks', array('controller' => 'trucks')); ?>
</p>