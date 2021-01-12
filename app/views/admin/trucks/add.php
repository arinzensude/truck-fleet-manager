<h2>Add Truck</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('name'); ?>
<?php echo $this->form->input('model'); ?>
<?php echo $this->form->input('year'); ?>
<?php echo $this->form->input('image', array('label' => 'Image URL', 'style' => 'width: 300px;')); ?>
<?php echo $this->form->input('plate_no'); ?>
<?php echo $this->form->input('particulars', array('label' => 'Particulars URL', 'style' => 'width: 300px;')); ?>
<?php echo $this->form->date_input('particulars_expiry', array('label' => 'Particulars Expiry Date')); ?>
<?php echo $this->form->belongs_to_dropdown('TruckType', $types, array('style' => 'width: 100px;', 'empty' => true)); ?>
<?php echo $this->form->input('capital_expenditure'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>