<?php

class AdminTruckTypesController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'description');
    var $default_searchable_fields = array('name');

    public function add() {
    	if (!empty($this->params['data']) && !empty($this->params['data']['TruckType'])) {
            $this->params['data']['TruckType']['created_on'] = date('Y-m-d');
            $this->params['data']['TruckType']['updated_on'] = date('Y-m-d');
        }
    	$this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'TruckType'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['TruckType'])) {
            $this->params['data']['TruckType']['updated_on'] = date('Y-m-d');
        }
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
  	}

}
