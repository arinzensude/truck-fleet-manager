<?php

class Route extends MvcModel {

    var $display_field = 'name';
    //var $includes = array('Client');
    var $belongs_to = array('Client');
    var $has_many = array('Trip');
    var $has_and_belongs_to_many = array(
        'TruckType' => array(
          'join_table' => '{prefix}fuels'
        )
    );

    var $validate = array(
        // Use a custom regex for the validation
        'name' => 'not_empty',
        'client' => 'not_empty',
        'driver_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Please enter only numbers!'
        ),
        'motorboy_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Please enter only numbers!'
        ),
        'trip_allowance' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Please enter only numbers!'
        ),
        'litres_of_fuel' => array(
            'pattern' => '/^[0-9]/',
            'message' => 'Please enter only numbers!'
        ),
        'price' => array(
            'pattern' => '/^[0-9]*\.[0-9]{2}$|^[0-9]/',
            'message' => 'Please enter only numbers!'
        )
    );

    public function before_delete($object) {
        $fuel = new Fuel();
        $fuel->delete_all(array('conditions' => array( 'route_id' => $object->id)));
    }

}
