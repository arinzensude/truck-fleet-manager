<h2>Add Trip</h2>
<div id="add-trip">
<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('invoice_no'); ?>
<?php echo $this->form->date_input('invoice_date', array('label' => 'Invoice Date')); ?>
<?php echo $this->form->belongs_to_dropdown('Truck', $trucks, array('style' => 'width: 100px;', 'empty' => false)); ?>
<?php echo $this->form->belongs_to_dropdown('Driver', $drivers, array('style' => 'width: 100px;', 'empty' => false)); ?>
<?php echo $this->form->belongs_to_dropdown('Client', $clients, array('style' => 'width: 100px;', 'empty' => false)); ?>
<?php echo $this->form->belongs_to_dropdown('Route', $routes, array('style' => 'width: 100px;', 'empty' => false)); ?>
<?php echo $this->form->input('quantity', array('label' => 'Quantity (for rate = per bag)')); ?>
<?php echo $this->form->input('rate', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('driver_allowance', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('motorboy_allowance', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('trip_allowance', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('fuel_per_litre', array('label' => 'Fuel Price per Litre')); ?>
<?php echo $this->form->hidden_input('litres_of_fuel'); ?>
<?php echo $this->form->input('total_fuel_cost', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('other_expenses'); ?>
<?php echo $this->form->textarea_input('other_expenses_description', array('label' => 'Description for Other Expenses')); ?>
<?php echo $this->form->input('price', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('total_price', array('readonly'=>'readonly')); ?>
<?php echo $this->form->input('amount_paid'); ?>
<?php echo $this->form->checkbox_input('paid_in_full', array('label' => 'Paid in Full')); ?>
<?php echo $this->form->checkbox_input('complete', array('label' => 'Complete')); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Add'); ?>
</div>