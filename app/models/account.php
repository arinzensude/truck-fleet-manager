<?php

class Account extends MvcModel {

    var $display_field = 'id';
    var $belongs_to = array(
	    'Users' => array(
	      'foreign_key' => 'paid_by'
	    )
  	);

}
