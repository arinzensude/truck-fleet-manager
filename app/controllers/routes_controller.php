<?php

class RoutesController extends MvcPublicController {

	public function show() {
	    $this->set_object();
	    $this->load_helper('Truckfleet');
	    $this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Route'));
	    $this->set('edit_link', $this->truckfleet->edit_link($this->name, $this->params['id']));
	    $this->set('delete_link', $this->truckfleet->delete_link($this->name, $this->params['id']));
  	}

}
