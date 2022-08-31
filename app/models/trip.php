<?php
//use Account;

class Trip extends MvcModel {

    var $display_field = 'invoice_no';
    var $belongs_to = array('Truck', 'Driver', 'Route', 'Client');
    //Change the index view list to 20 per page and list in DESC order
    var $per_page = 20;
    var $order = 'Trip.created_on DESC';

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
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'driver_allowance', $object->driver_allowance, 0, $object->created_on);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'motorboy_allowance', $object->motorboy_allowance, 0, $object->created_on);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'trip_allowance', $object->trip_allowance, 1, $object->created_on);
  			$this->debit_account_save('DEBIT', 'Trip', $object->id, 'total_fuel_cost', $object->total_fuel_cost, 1, $object->created_on);
        $this->debit_account_save('DEBIT', 'Trip', $object->id, 'other_expenses', $object->other_expenses, 1, $object->created_on);
  			$this->debit_account_save('CREDIT', 'Trip', $object->id, 'amount_paid', $object->total_price, $object->paid_in_full, $object->created_on);
  		} else {
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'driver_allowance', $object->driver_allowance, 0, $object->created_on);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'motorboy_allowance', $object->motorboy_allowance, 0, $object->created_on);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'trip_allowance', $object->trip_allowance, 1, $object->created_on);
  			$this->debit_account_create('DEBIT', 'Trip', $object->id, 'total_fuel_cost', $object->total_fuel_cost, 1, $object->created_on);
        $this->debit_account_create('DEBIT', 'Trip', $object->id, 'other_expenses', $object->other_expenses, 1, $object->created_on);
  			$this->debit_account_create('CREDIT', 'Trip', $object->id, 'amount_paid', $object->total_price, $object->paid_in_full, $object->created_on);
  		}
      //Update manager balance after creating or updating Trip
      if (current_user_can('manager')) {
        $this->update_manager_wallet(wp_cache_get('trip_amount'));
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
  	public function debit_account_save($mode, $type, $object_id, $description, $amount, $paid, $created_on) {
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
        'created_on' => $created_on,
  			'updated_on' => date('Y-m-d')
  		));
  		$account->save($params);
  	}

  	public function debit_account_create($mode, $type, $object_id, $description, $amount, $paid, $created_on) {
  		$params = array('Account' => array(
  			'mode' => $mode,
  			'type' => $type,
  			'type_id' => $object_id,
  			'description' => $description,
  			'amount' => $amount,
  			'paid_or_received' => $paid,
  			'paid_by' => get_current_user_id(),
  			'created_on' => $created_on,
  			'updated_on' => date('Y-m-d')
  		));
  		$account = new Account();
  		$account->create($params);
  	}

  	public function before_delete($object) {
  		$account = new Account();
  		$account->delete_all(array('conditions' => array( 'type' => 'Trip', 'type_id' => $object->id)));
  	}

    //Check if manager can pay for the amount in a Trip (trip allowance, fuel cost and other expenses)
    public function custom_before_save($object_arr, $mode, $object = null) {
      if (current_user_can('manager')) {
        if ($mode == 'ADD') {
          $amount = $object_arr['trip_allowance'] + $object_arr['total_fuel_cost'] + $object_arr['other_expenses'];
          $user = get_current_user_id();
          if ($this->can_manager_pay($user, $amount)) {
            wp_cache_set('trip_amount', array('user' => $user, 'amount' =>$amount));
            return true;
          } else {
            //$this->validation_error_html = 'You do not have enough funds in your wallet to create this Payment Approval';
            return false;
          }
        } elseif ($mode == 'EDIT') {
          $former_amount = $object_arr['trip_allowance'] + $object_arr['total_fuel_cost'] + $object_arr['other_expenses'];
          $new_amount = $object->trip_allowance + $object->total_fuel_cost + $object->other_expenses;
          $amount = $former_amount - $new_amount;
          $user = get_current_user_id();
          if ($amount > 0) {
            if ($this->can_manager_pay($user, $amount)) {
              wp_cache_set('trip_amount', array('user' => $user, 'amount' =>$amount));
              return true;
            } else {
              return false;
            }
          } else {
            wp_cache_set('trip_amount', array('user' => $user, 'amount' =>$amount));
            return true;
          }
        } else {
          return true;
        }
      } else {
        return true;
      }
    }

    public function can_manager_pay($user, $amount) {
      $wallet = new Wallet();
      $manager_wallet = $wallet->find(array(
        'selects' => array('Wallet.balance'),
        'conditions' => array('Wallet.manager'=>$user )
      ));
      $balance = $manager_wallet[0]->balance;
      if ($balance > $amount)
        return true;
      else
        return false;
    }

    public function update_manager_wallet($data) {
      $wallet = new Wallet();
      $manager_wallet = $wallet->find(array(
        'conditions' => array('Wallet.manager'=>$data['user'] )
      ));
      $new_balance = $manager_wallet[0]->balance - $data['amount'];
      //Update wallet balance
      $wallet->update($manager_wallet[0]->id, array('balance' => $new_balance));
    }

}
