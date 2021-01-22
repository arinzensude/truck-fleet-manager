<h2><?php echo MvcInflector::titleize($this->action); ?></h2>

<p><b>This is the financial report for <?php echo date('F Y'); ?>.</b></p>
<table class="model-show widefat post fixed striped">
	<tr>
		<td class="label"><b>Revenue</b></td>
		<td class="data"><?php echo number_format($revenue, 2) ?></td>
	</tr>
	<tr>
		<td class="label"><b>Expenditure</b></td>
		<td class="data"><?php echo number_format($expenditure, 2) ?></td>
	</tr>
	<tr>
		<td class="label"><b>Account Receivables</b></td>
		<td class="data"><?php echo number_format($receivables, 2) ?></td>
	</tr>
	<tr>
		<td class="label"><b>Account Payable</b></td>
		<td class="data"><?php echo number_format($payables, 2) ?></td>
	</tr>
</table>

<p><h3>List of Account entries for <?php echo date('F Y'); ?>.</h3></p>

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