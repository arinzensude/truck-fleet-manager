<?php

class AdminTrucksController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'plate_no','model', 'year', 
    	'image'=>array('value_method' => 'img_link'), 
    	'particulars'=> array('value_method' => 'particulars_link', 'label' => 'Particulars URL'), 
    	'particulars_expiry', 'truck_type' => array('value_method' => 'get_truck_type'));
    var $default_searchable_fields = array('name', 'model', 'plate_no', 'year');

    public function add() {
        $this->set_types();
    	if (!empty($this->params['data']) && !empty($this->params['data']['Truck'])) {
            $this->params['data']['Truck']['created_on'] = date('Y-m-d');
            $this->params['data']['Truck']['updated_on'] = date('Y-m-d');
        }
    	$this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Truck'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['Truck'])) {
            $this->params['data']['Truck']['updated_on'] = date('Y-m-d');
        }
        $this->set_types();
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
  	}

  	public function img_link($object) {
        $img = '<img src="'.$object->image.'" width="100%" height="auto">';
        return $img;
    }

    public function particulars_link($object) {
        return empty($object->particulars) ? null : HtmlHelper::link($object->particulars, $object->particulars, array('target' => '_blank'));
    }

    public function set_types() {
        $this->load_model('TruckType');
        $types = $this->TruckType->find(array('selects' => array('id', 'name')));
        $this->set('types', $types);
    }

    public function get_truck_type($object) {
        return HtmlHelper::admin_object_link($object->truck_type, array('action' => 'edit'));
    }

    public function number_format_ce($object) {
        return number_format($object->capital_expenditure, 2);
    }

}
