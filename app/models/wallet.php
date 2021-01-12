<?php

class Wallet extends MvcModel {

    var $display_field = 'id';
    var $belongs_to = array(
	    'Users' => array(
	      'foreign_key' => 'manager'
	    )
  	);

}
