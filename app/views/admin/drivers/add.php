<h2>Add Driver</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('name'); ?>
<?php echo $this->form->input('address', array('style' => 'width: 400px;')); ?>
<?php echo $this->form->input('phone_no', array('label' => 'Phone Number')); ?>
<?php echo $this->form->input('bank_name'); ?>
<?php echo $this->form->input('account_no'); ?>
<?php echo $this->form->belongs_to_dropdown('Motorboy', $motorboys, array('style' => 'width: 100px;', 'empty' => true)); ?>
<?php echo $this->form->input('license', array('label' => 'License URL', 'style' => 'width: 300px;')); ?>
<?php echo $this->form->input('passport', array('label' => 'Passport URL', 'style' => 'width: 300px;')); ?>
<?php echo $this->form->input('reference_name'); ?>
<?php echo $this->form->input('reference_phone'); ?>
<?php echo $this->form->input('next_of_kin_name'); ?>
<?php echo $this->form->input('next_of_kin_phone'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>