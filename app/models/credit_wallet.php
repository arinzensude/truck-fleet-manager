<?php

class CreditWallet extends MvcModel {

    var $display_field = 'manager';
    var $belongs_to = array(
	    'Users' => array(
	      'foreign_key' => 'manager'
	    )
  	);

  	var $validate = array(
        // Use a custom regex for the validation
        'manager' => 'not_empty',
        'amount' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Amount: Please enter only numbers!'
        )
    );

    public function after_save($object) {
    	$wallet = new Wallet();
    	$find_wallet = $wallet->find_by_manager($object->manager);
    	if($find_wallet) {
    		$params = array('Wallet' => array(
	  			'id' => $find_wallet[0]->id,
	  			'manager' => $object->manager,
	  			'balance' => $find_wallet[0]->balance + $object->amount,
	  			'updated_on' => date('Y-m-d')
	  		));
	  		$wallet->save($params);
    	} else {
    		$params = array('Wallet' => array(
	  			'manager' => $object->manager,
	  			'balance' => $object->amount,
	  			'updated_on' => date('Y-m-d'),
	  			'created_on' => date('Y-m-d'),
	  		));
	  		$wallet->create($params);
    	}
    }

}
