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
		<td class="label">Rate</td>
		<td class="data"><?php echo $object->rate ?></td>
	</tr>
	<tr>
		<td class="label">Trip Message</td>
		<td class="data"><?php echo $object->trip_message ?></td>
	</tr>
	<tr>
		<td><?php echo $edit_link ?></td>
		<td><?php echo $back_link ?></td>
	</tr>
</table>
<p>
    <?php //echo $this->html->link('&#8592; All Clients', array('controller' => 'clients')); ?>
</p>

<h3>Routes</h3>

<?php $this->render_view('routes/_item', array('collection' => $object->routes)); ?>
