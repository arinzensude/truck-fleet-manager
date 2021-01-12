<h2>Edit Client</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('name'); ?>
<?php echo $this->form->input('address', array('style' => 'width: 400px;')); ?>
<?php echo $this->form->input('phone_no', array('label' => 'Phone Number')); ?>
<?php echo $this->form->select('data[Client][rate]', array('label'=>'Rate (per bag/per trip)', 'value'=>$this->object->rate, 'options'=>$rate)); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Update'); ?>
<br/>
<?php echo $back_link; ?>