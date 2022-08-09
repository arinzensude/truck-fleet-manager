<h2><?php echo MvcInflector::titleize($this->action); ?></h2>

<p>
	<span>Choose month and year</span>
	<select id="choose-month">
		<option value="1">January</option>
		<option value="2">February</option>
		<option value="3">March</option>
		<option value="4">April</option>
		<option value="5">May</option>
		<option value="6">June</option>
		<option value="7">July</option>
		<option value="8">August</option>
		<option value="9">September</option>
		<option value="10">October</option>
		<option value="11">November</option>
		<option value="12">December</option>
	</select>
	<select id="choose-year">
		<?php
		for ($i=2020; $i <= date("Y") ; $i++) { 
			?>
			<option value="<?php echo $i?>"><?php echo $i?></option>
			<?php
		}
		?>
	</select>
	<input type="submit" name="" value="Enter" id="choose-monthly-fin-report">
</p>

<p><b>This is the financial report for <?php echo !empty($month) ? date('F', mktime(0, 0, 0, $month, 10))." ".$year : date('F Y'); ?>.</b></p>
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

<p><h3>List of Account entries for <?php echo !empty($month) ? date('F', mktime(0, 0, 0, $month, 10))." ".$year : date('F Y');; ?>.</h3></p>

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