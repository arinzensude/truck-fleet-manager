<h2>Add Payment Approval</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->belongs_to_dropdown('Truck', $trucks, array('style' => 'width: 100px;', 'empty' => true)); ?>
<?php echo $this->form->input('amount'); ?>
<?php echo $this->form->textarea_input('description', array('label' => 'Description')); ?>
<?php echo $this->form->date_input('created_on', array('label' => 'Date')); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>