<?php

class AdminTripsController extends MvcAdminController {

    var $default_columns = array('id', 'invoice_no'=>'Customer Name', 'invoice_date', 'created_on', 
	'truck' => array('value_method' => 'get_truck_name'), 'driver' => array('value_method' => 'get_driver_name'),
	'client' => array('value_method' => 'get_client_name'), 'route' => array('value_method' => 'get_route_name'), 'quantity', 
	'paid_in_full' => array('value_method' => 'get_paid_in_full', 'label' => 'Paid'), 'complete' => array('value_method' => 'get_complete', 'label' => 'Trip Completed?'));
    var $default_searchable_fields = array('invoice_no', 'truck', 'driver', 'client', 'route');

    public function add() {
    	$this->set_clients();
    	$this->set_trucks();
    	$this->set_drivers();
    	$this->set_routes();
    	if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
            //$this->params['data']['Trip']['created_on'] = date('Y-m-d');
            $this->params['data']['Trip']['updated_on'] = date('Y-m-d');
        }
    	if ($this->model->custom_before_save($this->params['data']['Trip'], 'ADD')) {
            $this->create_or_save();
        } else {
            if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
                $this->flash('error', __('You do not have enough funds in your wallet to create this Trip', 'wpmvc'));
            }
        }
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Trip'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
            $this->params['data']['Trip']['updated_on'] = date('Y-m-d');
            unset($this->params['data']['Trip']['litres_of_fuel']);
        }
        $this->set_clients();
    	$this->set_trucks();
    	$this->set_drivers();
    	$this->set_routes();
        $this->verify_id_param();
        $this->set_object();
        if ($this->model->custom_before_save($this->params['data']['Trip'], 'EDIT', $this->object)) {
            $this->create_or_save();
        } else {
            if (!empty($this->params['data']) && !empty($this->params['data']['Trip'])) {
                $this->flash('error', __('You do not have enough funds in your wallet to create this Trip', 'wpmvc'));
            }
        }
  	}

  	public function delete() {
        $this->verify_id_param();
        $this->set_object();
        if (!empty($this->object)) {
            //Prevent deletion of trip if it has been completed or paid for (partly or fully)
            if ($this->object->complete || $this->object->amount_paid > 0) {
                $this->flash('error', __('Trip cannot be deleted because it has been completed or paid for (in part or in full)!', 'wpmvc'));
            } else {
                $this->model->delete($this->params['id']);
                $this->flash('notice', __('Successfully deleted!', 'wpmvc'));
            }
        } else {
            $this->flash('warning', 'A '.MvcInflector::humanize($this->model->name).' with ID "'.$this->params['id'].'" couldn\'t be found.');
        }
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
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
        return HtmlHelper::object_link($object->client);
    }

    public function get_truck_name($object) {
        return HtmlHelper::object_link($object->truck);
    }

    public function get_driver_name($object) {
        return HtmlHelper::object_link($object->driver);
    }

    public function get_route_name($object) {
        return HtmlHelper::object_link($object->route);
    }

    public function get_paid_in_full($object) {
    	return ($object->paid_in_full == 0) ? 'No' : 'Yes';
    }

    public function get_complete($object) {
    	return ($object->complete == 0) ? 'No' : 'Yes';
    }

}
