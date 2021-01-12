<?php

class Motorboy extends MvcModel {

    var $display_field = 'name';

    var $validate = array(
        // Use a custom regex for the validation
        'name' => 'not_empty',
        'address' => 'not_empty',
        'phone_no' => 'not_empty',
        'bank_name' => 'not_empty',
        'acount_no' => array(
            'pattern' => '/^[0-9]/',
            'message' => 'Please enter only numbers!'
        ),
        'passport' => array(
            'rule' => 'url',
            'required' => true,
            'message' => 'Please enter a valid URL in the URL field!'
        )
    );

}
