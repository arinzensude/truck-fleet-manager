<?php

class Wallet extends MvcModel {

    var $display_field = 'id';
    var $belongs_to = array(
	    'Users' => array(
	      'foreign_key' => 'manager'
	    )
  	);
  	//Change the index view list to 20 per page and list in DESC order
    var $per_page = 20;
    var $order = 'Wallet.created_on DESC';

}
