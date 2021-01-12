<h2>Edit Credit Wallet</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->belongs_to_dropdown('Users', $managers, array('style' => 'width: 100px;', 'empty' => true)); ?>
<?php echo $this->form->input('amount'); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Update'); ?>