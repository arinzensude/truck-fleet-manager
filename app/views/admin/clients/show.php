<h2><?php echo $object->__name; ?></h2>

<table class="model-show">
	<tr>
		<td>Address</td>
		<td><?php echo $object->address ?></td>
	</tr>
	<tr>
		<td>Phone Number</td>
		<td><?php echo $object->phone_no ?></td>
	</tr>
	<tr>
		<td>Rate</td>
		<td><?php echo $object->rate ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $delete_link ?></td>
	</tr>
	<tr>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
