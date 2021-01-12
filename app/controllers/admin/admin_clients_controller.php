<?php

class AdminClientsController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'address', 'phone_no'=> 'Phone Number', 'rate'=>'Rate (per bag/per trip)');
    var $default_searchable_fields = array('name', 'phone_no');
    var $rate = array('per bag'=>'per bag', 'per trip'=>'per trip');

    public function add() {
    	$this->set('rate', $this->rate);
    	if (!empty($this->params['data']) && !empty($this->params['data']['Client'])) {
            $this->params['data']['Client']['created_on'] = date('Y-m-d');
            $this->params['data']['Client']['updated_on'] = date('Y-m-d');
        }
    	$this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('rate', $this->rate);
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Client'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['Client'])) {
            $this->params['data']['Client']['updated_on'] = date('Y-m-d');
        }
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
  	}

  	function show() {
    
        $object = $this->Client->find_by_id($this->params['id'], array(
            'includes' => array('Route')
        ));
        
        if (!empty($object)) {
            $this->set('object', $object);
            $this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Client'));
	        $this->set('edit_link', $this->truckfleet->edit_link($this->name, $this->params['id']));
	        $this->set('delete_link', $this->truckfleet->delete_link($this->name, $this->params['id']));
        }
    }

}
