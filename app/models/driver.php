<?php

class Driver extends MvcModel {

    var $display_field = 'name';
    var $belongs_to = array('Motorboy');
    var $has_many = array('Trip');

    var $validate = array(
        // Use a custom regex for the validation
        'name' => 'not_empty',
        'address' => 'not_empty',
        'next_of_kin_name' => 'not_empty',
        'next_of_kin_phone' => 'not_empty',
        'license' => array(
            'rule' => 'url',
            'required' => true,
            'message' => 'Please enter a valid URL in the URL field!'
        ),
        'passport' => array(
            'rule' => 'url',
            'required' => true,
            'message' => 'Please enter a valid URL in the URL field!'
        ),
        'reference_name' => 'not_empty',
        'reference_phone' => 'not_empty',
        'phone_no' => 'not_empty',
        'bank_name' => 'not_empty',
        'acount_no' => array(
            'pattern' => '/^[0-9]/',
            'message' => 'Please enter only numbers!'
        )
    );

}
