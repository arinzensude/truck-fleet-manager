<h2>Add Credit Wallet</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->select('data[CreditWallet][manager]', array('label'=>'Manager', 'options'=>$managers)); ?>
<?php echo $this->form->input('amount'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>