<?php

class Truck extends MvcModel {

    var $display_field = 'name';
    var $has_many = array('Trip', 'PaymentApproval');
    var $belongs_to = array('TruckType');

    var $validate = array(
        // Use a custom regex for the validation
        'name' => 'not_empty',
        'model' => 'not_empty',
        'year' => 'not_empty',
        'image' => array(
            'rule' => 'url',
            'required' => true,
            'message' => 'Please enter a valid URL in the URL field!'
        ),
        'plate_no' => 'not_empty',
        'particulars' => array(
            'rule' => 'url',
            'required' => true,
            'message' => 'Please enter a valid URL in the URL field!'
        ),
        'particulars_expiry' => 'not_empty',
        'capital_expenditure' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Please enter only numbers!'
        )
    );
}
