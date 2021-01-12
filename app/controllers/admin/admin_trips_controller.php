<?php

class AdminTripsController extends MvcAdminController {

    var $default_columns = array('id', 'invoice_no', 'invoice_date', 
	'truck' => array('value_method' => 'get_truck_name'), 'driver' => array('value_method' => 'get_driver_name'),
	'client' => array('value_method' => 'get_client_name'), 'route' => array('value_method' => 'get_route_name'),
	'paid_in_full' => array('value_method' => 'get_paid_in_full'), 'complete' => array('value_method' => 'get_complete'));
    var $default_searchable_fields = array('invoice_no', 'truck', 'driver', 'client', 'route');

    public function add() {
    	$this->set_clients();
    	$this->set_trucks();
    	$this->set_drivers();
    	$this->set_routes();
    	if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
            $this->params['data']['Trip']['created_on'] = date('Y-m-d');
            $this->params['data']['Trip']['updated_on'] = date('Y-m-d');
        }
    	$this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Trip'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
            $this->params['data']['Trip']['updated_on'] = date('Y-m-d');
        }
        $this->set_clients();
    	$this->set_trucks();
    	$this->set_drivers();
    	$this->set_routes();
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
  	}

  	public function get_routes($client) {
  		/*$this->load_model('Route');
        $routes = $this->Route->find(array('selects' => array('id', 'name'), 'conditions' => array('Route.client' => $client)));
        return $routes;*/
        echo "AJAX Working";
  	}

  	public function set_clients() {
    	$this->load_model('Client');
        $clients = $this->Client->find(array('selects' => array('id', 'name')));
        $this->set('clients', $clients);
    }

    public function set_trucks() {
    	$this->load_model('Truck');
        $trucks = $this->Truck->find(array('selects' => array('id', 'name')));
        $this->set('trucks', $trucks);
    }

    public function set_drivers() {
    	$this->load_model('Driver');
        $drivers = $this->Driver->find(array('selects' => array('id', 'name')));
        $this->set('drivers', $drivers);
    }

    public function set_routes() {
    	$this->load_model('Route');
        $routes = $this->Route->find(array('selects' => array('id', 'name')));
        $this->set('routes', $routes);
    }

  	public function get_client_name($object) {
        return HtmlHelper::admin_object_link($object->client, array('action' => 'edit'));
    }

    public function get_truck_name($object) {
        return HtmlHelper::admin_object_link($object->truck, array('action' => 'edit'));
    }

    public function get_driver_name($object) {
        return HtmlHelper::admin_object_link($object->driver, array('action' => 'edit'));
    }

    public function get_route_name($object) {
        return HtmlHelper::admin_object_link($object->route, array('action' => 'edit'));
    }

    public function get_paid_in_full($object) {
    	return ($object->paid_in_full == 0) ? 'No' : 'Yes';
    }

    public function get_complete($object) {
    	return ($object->complete == 0) ? 'No' : 'Yes';
    }

}
