<?php

class AdminDriversController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'address', 'phone_no', 'passport'=>array('value_method' => 'passport_link'), 'bank_name', 'account_no', 'motorboy' => array('value_method' => 'get_motorboy_name'));
    var $default_searchable_fields = array('name', 'motorboy', 'address', 'phone_no', 'bank_name', 'account_no');

    public function add() {
    	$this->set_motorboys();
        if (!empty($this->params['data']) && !empty($this->params['data']['Driver'])) {
            $this->params['data']['Driver']['created_on'] = date('Y-m-d');
            $this->params['data']['Driver']['updated_on'] = date('Y-m-d');
        }
        $this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Driver'));
        if (!empty($this->params['data']) && !empty($this->params['data']['Driver'])) {
            $this->params['data']['Driver']['updated_on'] = date('Y-m-d');
        }
        $this->set_motorboys();
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
    
    }

    public function set_motorboys() {
    	$this->load_model('Motorboy');
        $motorboys = $this->Motorboy->find(array('selects' => array('id', 'name')));
        $this->set('motorboys', $motorboys);
    }

    public function get_motorboy_name($object) {
    	return HtmlHelper::admin_object_link($object->motorboy, array('action' => 'edit'));
    }

    public function passport_link($object) {
        $img = '<img src="'.$object->passport.'" width="100%" height="auto">';
        return $img;
    }

}
