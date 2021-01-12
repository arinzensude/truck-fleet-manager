<?php

class TruckType extends MvcModel {

    var $display_field = 'name';

    var $validate = array(
    	'name' => 'not_empty'
    );

}
