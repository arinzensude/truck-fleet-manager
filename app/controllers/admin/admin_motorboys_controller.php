<?php

class AdminMotorboysController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'address', 'phone_no'=>'Phone Number', 'passport'=>array('value_method' => 'passport_link'), 'bank_name'=>'Bank Name', 'account_no'=>'Bank Account Number');
    var $default_searchable_fields = array('name', 'phone_no');

    public function add() {
    	if (!empty($this->params['data']) && !empty($this->params['data']['Motorboy'])) {
    		$this->params['data']['Motorboy']['created_on'] = date('Y-m-d');
	      	$this->params['data']['Motorboy']['updated_on'] = date('Y-m-d');
    	}
    	$this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Motorboy'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['Motorboy'])) {
	      	$this->params['data']['Motorboy']['updated_on'] = date('Y-m-d');
    	}
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
    }

    public function passport_link($object) {
        $img = '<img src="'.$object->passport.'" width="100%" height="auto">';
        return $img;
    }

}
