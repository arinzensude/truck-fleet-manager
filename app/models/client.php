<?php

class Client extends MvcModel {

    var $display_field = 'name';
    var $has_many = array(
    	'Trip',
	    'Route' => array(
	      'dependent' => true
    	)
  	);
  	var $validate = array(
        // Use a custom regex for the validation
        'name' => 'not_empty',
        'address' => 'not_empty',
        'phone_no' => 'not_empty',
        'rate' => 'not_empty'
    );

}
