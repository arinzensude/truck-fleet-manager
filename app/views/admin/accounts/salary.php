<h2><?php echo MvcInflector::titleize($this->action); ?></h2>
<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->hidden_input('mode', array('value'=>'DEBIT')); ?>
<?php echo $this->form->hidden_input('type', array('value'=>'Salary')); ?>
<?php echo $this->form->select('data[Account][type_id]', array('label'=>'Manager/Admin', 'options'=>$users)); ?>
<?php echo $this->form->input('amount', array('required'=>true)); ?>
<?php echo $this->form->input('description', array('value'=>'Salary for', 'required'=>true)); ?>
<?php echo $this->form->date_input('created_on', array('label' => 'Created On Date')); ?>
<?php echo $this->form->hidden_input('paid_or_received', array('value'=>1)); ?>
<?php echo $this->form->hidden_input('paid_by', array('value'=>$paid_by)); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Pay Salary'); ?>

<p><h3>Salary List from Accounts Table</h3></p>

<div class="tablenav">

    <div class="tablenav-pages">
    
        <?php echo paginate_links($pagination); ?>
    
    </div>

</div>

<div class="clear"></div>

<table class="widefat post fixed striped" cellspacing="0">

    <thead>
        <?php echo $helper->admin_header_cells($this); ?>
    </thead>

    <tfoot>
        <?php echo $helper->admin_header_cells($this); ?>
    </tfoot>

    <tbody><?php $options = array(
                'actions' => array(
                    'edit' => false,
                    'view' => false,
                    'delete' => false,
                )
            );
        ?>
        <?php echo $helper->admin_table_cells($this, $objects, $options); ?>
    </tbody>
    
</table>

<div class="tablenav">

    <div class="tablenav-pages">
    
        <?php echo paginate_links($pagination); ?>
    
    </div>

</div>

<br class="clear" />