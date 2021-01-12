<h2>Add Route</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('name'); ?>
<?php echo $this->form->belongs_to_dropdown('Client', $clients, array('style' => 'width: 100px;', 'empty' => false)); ?>
<?php echo $this->form->input('driver_allowance'); ?>
<?php echo $this->form->input('motorboy_allowance'); ?>
<?php echo $this->form->input('trip_allowance'); ?>
<?php foreach($types as $type) {?>
	<?php echo '<tr><th scope="row"><label for="data[Route][fuel]['.$type->id.']">'.$type->name.' (Litres of Fuel)</label></th><td><input id="data[Route][fuel]['.$type->id.']" name="data[Route][fuel]['.$type->id.']" type="text" value=""></td></tr>'?>
<?php }?>
<?php echo $this->form->input('price'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>