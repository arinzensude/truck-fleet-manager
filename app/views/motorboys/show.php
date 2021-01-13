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
		<td><?php echo $edit_link ?></td>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Motorboys', array('controller' => 'motorboys')); ?>
</p>