<h2>Edit Payment Approval</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php if($object->approved || current_user_can('administrator')) {?>
	<?php echo $this->form->belongs_to_dropdown('Truck', $trucks, array('style' => 'width: 300px;', 'empty' => true, 'disabled'=>'true')); ?>
	<?php echo $this->form->input('amount', array('readonly'=>'readonly')); ?>
	<?php echo $this->form->textarea_input('description', array('label' => 'Description', 'readonly'=>'readonly')); ?>
<?php } else {?>
	<?php echo $this->form->belongs_to_dropdown('Truck', $trucks, array('style' => 'width: 300px;', 'empty' => true)); ?>
	<?php echo $this->form->input('amount'); ?>
	<?php echo $this->form->textarea_input('description', array('label' => 'Description')); ?>
<?php }?>
<?php if(!$object->approved && current_user_can('administrator')) {?>
	<?php echo $this->form->checkbox_input('approved', array('label' => 'Approved')); ?>
<?php }?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Update'); ?>
<br/>
<?php echo $back_link; ?>