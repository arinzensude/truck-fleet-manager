<?php
//use Account;

class Trip extends MvcModel {

    var $display_field = 'invoice_no';
    var $belongs_to = array('Truck', 'Driver', 'Route', 'Client');

    var $validate = array(
        // Use a custom regex for the validation
        'invoice_no' => 'not_empty',
        'invoice_date' => 'not_empty',
        'truck' => 'not_empty',
        'driver' => 'not_empty',
        'client' => 'not_empty',
        'route' => 'not_empty',
        'quantity' => array(
            'pattern' => '/^[0-9]/',
            'message' => 'Quantity: Please enter only numbers!'
        ),
        'rate' => 'not_empty',
        'driver_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Driver Allowance: Please enter only numbers!'
        ),
        'motorboy_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Motorboy Allowance: Please enter only numbers!'
        ),
        'trip_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Trip Allowance: Please enter only numbers!'
        ),
        'fuel_per_litre' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Fuel per Litre: Please enter only numbers!'
        ),
        'total_fuel_cost' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Total Fuel Cost: Please enter only numbers!'
        ),
        'price' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Price: Please enter only numbers!'
        ),
        'total_price' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Total Price: Please enter only numbers!'
        ),
        'other_expenses' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Other Expenses: Please enter only numbers!'
        ),
    );

    public function after_save($object) {
  		if($this->is_trip_account($object->id)) {
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'driver_allowance', $object->driver_allowance, 0);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'motorboy_allowance', $object->motorboy_allowance, 0);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'trip_allowance', $object->trip_allowance, 1);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'total_fuel_cost', $object->total_fuel_cost, 1);
        $this->debit_account_save('DEBIT', 'Trip', $object->id, 'other_expenses', $object->other_expenses, 1);
  			$this->debit_account_save('CREDIT', 'Trip', $object->id, 'amount_paid', $object->amount_paid, 1);
  		} else {
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'driver_allowance', $object->driver_allowance, 0);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'motorboy_allowance', $object->motorboy_allowance, 0);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'trip_allowance', $object->trip_allowance, 1);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'total_fuel_cost', $object->total_fuel_cost, 1);
        $this->debit_account_create('DEBIT', 'Trip', $object->id, 'other_expenses', $object->other_expenses, 1);
  			$this->debit_account_create('CREDIT', 'Trip', $object->id, 'amount_paid', $object->amount_paid, 1);
  		}
  	}

  	public function is_trip_account($id) {
  		$account = new Account();
  		$find_account = $account->find_by_type_id($id);
  		if($find_account)
  			return TRUE;
  		else
  			return FALSE;
  	}

  	//Used to update an Account record that already exists
  	public function debit_account_save($mode, $type, $object_id, $description, $amount, $paid) {
  		$account = new Account();
  		$find_account = $account->find(array(
  			'selects' => array('Account.id'),
  			'conditions' => array('Account.type_id'=>$object_id, 'Account.description' => $description )
  		));
  		$params = array('Account' => array(
  			'id' => $find_account[0]->id,
  			'mode' => $mode,
  			'type' => $type,
  			'type_id' => $object_id,
  			'description' => $description,
  			'amount' => $amount,
  			'paid_or_received' => $paid,
  			'paid_by' => get_current_user_id(),
  			'updated_on' => date('Y-m-d')
  		));
  		$account->save($params);
  	}

  	public function debit_account_create($mode, $type, $object_id, $description, $amount, $paid) {
  		$params = array('Account' => array(
  			'mode' => $mode,
  			'type' => $type,
  			'type_id' => $object_id,
  			'description' => $description,
  			'amount' => $amount,
  			'paid_or_received' => $paid,
  			'paid_by' => get_current_user_id(),
  			'created_on' => date('Y-m-d'),
  			'updated_on' => date('Y-m-d')
  		));
  		$account = new Account();
  		$account->create($params);
  	}

  	public function before_delete($object) {
  		$account = new Account();
  		$account->delete_all(array('conditions' => array( 'type' => 'Trip', 'type_id' => $object->id)));
  	}

}
