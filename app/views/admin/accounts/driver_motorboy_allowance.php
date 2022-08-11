<h2><?php echo MvcInflector::titleize($this->action); ?></h2>

<p><h3>Unpaid Driver Allowances</h3></p>
<table class="widefat post fixed striped driver-allowances" cellspacing="0">
	<thead>
        <tr>
        	<th scope="col" class="manage-column">Name</th>
        	<th scope="col" class="manage-column">Phone Number</th>
        	<th scope="col" class="manage-column">Bank</th>
        	<th scope="col" class="manage-column">Account Number</th>
        	<th scope="col" class="manage-column">Amount</th>
        	<th scope="col" class="manage-column">Trip IDs</th>
        	<th scope="col" class="manage-column"></th>
        </tr>    
    </thead>
    <tbody>
    	
    </tbody>
</table>


<p><h3>Unpaid Motorboy Allowances</h3></p>
<table class="widefat post fixed striped motorboy-allowances" cellspacing="0">
	<thead>
        <tr>
        	<th scope="col" class="manage-column">Name</th>
        	<th scope="col" class="manage-column">Phone Number</th>
        	<th scope="col" class="manage-column">Bank</th>
        	<th scope="col" class="manage-column">Account Number</th>
        	<th scope="col" class="manage-column">Amount</th>
        	<th scope="col" class="manage-column">Trip IDs</th>
        	<th scope="col" class="manage-column"></th>
        </tr>    
    </thead>
    <tbody>
    	
    </tbody>
</table>


<p><h3>Paid Driver & Motorboy Allowances</h3></p>

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