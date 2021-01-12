<h2>Edit Motorboy</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('name'); ?>
<?php echo $this->form->input('address', array('style' => 'width: 400px;')); ?>
<?php echo $this->form->input('phone_no'); ?>
<?php echo $this->form->input('passport', array('label' => 'Passport URL', 'style' => 'width: 300px;')); ?>
<?php echo $this->form->input('bank_name'); ?>
<?php echo $this->form->input('account_no'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Update'); ?>
<br/>
<?php echo $back_link; ?>