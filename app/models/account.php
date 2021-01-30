<?php

class Account extends MvcModel {

    var $display_field = 'id';
    var $belongs_to = array(
	    'Users' => array(
	      'foreign_key' => 'paid_by'
	    )
  	);

  	public function before_delete($object) {
  		if ($object->paid_or_received && $object->mode == 'DEBIT') {
  			$amount = 0 - $object->amount;
  			$this->update_manager_wallet(array('user' => $object->paid_by, 'amount' => $amount));
  		}
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
