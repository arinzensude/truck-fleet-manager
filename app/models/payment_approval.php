<?php

class PaymentApproval extends MvcModel {

    var $display_field = 'id';
    var $belongs_to = array(
    	'Truck',
	    'Users' => array(
	      'foreign_key' => 'requested_by',
	      'foreign_key' => 'approved_by'
	    )
  	);

  	var $validate = array(
        // Use a custom regex for the validation
        'truck' => 'not_empty',
        'description' => 'not_empty',
        'amount' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Amount: Please enter only numbers!'
        )
    );

    public function after_save($object) {
    	//Payment Approval can only be recorded in the Accounts table once
    	if($object->approved && !$this->is_pa_account($object->id)) {
    		$this->debit_account_create('DEBIT', 'PaymentApproval', $object->id, $object->description, $object->amount, 1, $object->requested_by);
    		$this->approved_email($object);
    	}
    }
    
    public function after_create($object) {
        $this->pa_email($object);
    }
    
    public function approved_email($object) {
        $link = HtmlHelper::admin_object_url($object, array('action' => 'edit'));
        $receiver = get_userdata($object->requested_by);
        $headers = array( 'Content-Type: text/plain; charset=UTF-8', 'From: Digbys Group <digbys.logistics@digbysgroup.com>' );
        $message = 'Dear Manager,
        
This Payment Approval request - '.$link.', has been approved. 
        
Regards,
Digbys Group';
        wp_mail(array($receiver->user_email, get_option('admin_email')), 'Payment Approved', $message, $headers);
    }
    
    public function pa_email($object) {
        $link = HtmlHelper::admin_object_url($object, array('action' => 'edit'));
        $headers = array( 'Content-Type: text/plain; charset=UTF-8', 'From: Digbys Group <digbys.logistics@digbysgroup.com>' );
        $message = 'Dear Admin,
        
Click '.$link.' to view the Payment request for your approval. 
        
Regards,
Digbys Group';
        wp_mail(get_option('admin_email'), 'Payment Approval for your Approval', $message, $headers);
    }

    public function is_pa_account($id) {
  		$account = new Account();
  		$find_account = $account->find_by_type_id($id);
  		if($find_account)
  			return TRUE;
  		else
  			return FALSE;
  	}

  	//Used to update an Account record that already exists
  	public function debit_account_save($mode, $type, $object_id, $description, $amount, $paid, $paid_by) {
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
  			'paid_by' => $paid_by,
  			'updated_on' => date('Y-m-d')
  		));
  		$account->save($params);
  	}

  	public function debit_account_create($mode, $type, $object_id, $description, $amount, $paid, $paid_by) {
  		$params = array('Account' => array(
  			'mode' => $mode,
  			'type' => $type,
  			'type_id' => $object_id,
  			'description' => $description,
  			'amount' => $amount,
  			'paid_or_received' => $paid,
  			'paid_by' => $paid_by,
  			'created_on' => date('Y-m-d'),
  			'updated_on' => date('Y-m-d')
  		));
  		$account = new Account();
  		$account->create($params);
  	}

    //Check if manager can pay for the amount in a Payment Approval
    public function custom_before_save($object_arr, $mode, $object = null) {
      if (current_user_can('manager')) {
        if ($mode == 'ADD') {
          if ($this->can_manager_pay($object_arr['requested_by'], $object_arr['amount'])) {
            return true;
          } else {
            //$this->validation_error_html = 'You do not have enough funds in your wallet to create this Payment Approval';
            return false;
          }
        } elseif ($mode == 'EDIT') {
          $amount = $object_arr['amount'] - $object->amount;
          if ($amount > 0) {
            if ($this->can_manager_pay($object->requested_by, $amount)) {
              return true;
            } else {
              return false;
            }
          } else {
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

}
