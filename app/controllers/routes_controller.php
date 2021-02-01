<?php

class RoutesController extends MvcPublicController {

	public function show() {
	    $this->set_object();
	    $this->load_helper('Truckfleet');
	    $this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Route'));
	    $this->set('edit_link', $this->truckfleet->edit_link($this->name, $this->params['id']));
	    $this->set('delete_link', $this->truckfleet->delete_link($this->name, $this->params['id']));
	    $this->set_types_values();
  	}

  	public function set_types_values() {
        $this->load_model('TruckType');
        $this->load_model('Fuel');
        $types = $this->TruckType->find(array('selects' => array('id', 'name')));
        foreach ($types as $type) {
            $find_fuel = $this->Fuel->find(array(
                'selects' => array('Fuel.litres_of_fuel'),
                'conditions' => array('Fuel.route_id' => $this->params['id'], 'Fuel.truck_type_id' => $type->id )
            ));
            $type->value = $find_fuel[0]->litres_of_fuel;
        }
        $this->set('types', $types);
    }

}
