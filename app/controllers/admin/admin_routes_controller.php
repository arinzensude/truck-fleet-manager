<?php

class AdminRoutesController extends MvcAdminController {

    var $default_columns = array('id', 'name', 'client' => array('value_method' => 'get_client_name'), 'driver_allowance' => array('value_method' => 'number_format_da'), 'motorboy_allowance' => array('value_method' => 'number_format_ma'), 'trip_allowance' => array('value_method' => 'number_format_ta'), 'price' => array('value_method' => 'number_format_price'));
    var $default_searchable_fields = array('id', 'name', 'driver_allowance', 'motorboy_allowance', 'trip_allowance', 'price');

    public function add() {
        $this->set_types();
        $this->set_clients();
        if (!empty($this->params['data']) && !empty($this->params['data']['Route'])) {
            $this->params['data']['Route']['created_on'] = date('Y-m-d');
            $this->params['data']['Route']['updated_on'] = date('Y-m-d');
        }
        $this->create_or_save();
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'Route'));
        if (!empty($this->params['data']) && !empty($this->params['data']['Route'])) {
            $this->params['data']['Route']['updated_on'] = date('Y-m-d');
        }
        $this->set_types_values();
        $this->set_clients();
        $this->verify_id_param();
        $this->set_object();
        $this->create_or_save();
    
    }

    public function create_type_fuel($route_id, $type_id, $litres_of_fuel) {
        $params = array('Fuel' => array(
            'route_id' => $route_id,
            'truck_type_id' => $type_id,
            'litres_of_fuel' => $litres_of_fuel,
            'created_on' => date('Y-m-d'),
            'updated_on' => date('Y-m-d')
        ));
        $this->load_model('Fuel');
        $this->Fuel->create($params);
    }

    public function save_type_fuel($route_id, $type_id, $litres_of_fuel) {
        $this->load_model('Fuel');
        $find_fuel = $this->Fuel->find(array(
            'selects' => array('Fuel.id'),
            'conditions' => array('Fuel.route_id' => $route_id, 'Fuel.truck_type_id' => $type_id )
        ));
        $params = array('Fuel' => array(
            'id' => $find_fuel[0]->id,
            'route_id' => $route_id,
            'truck_type_id' => $type_id,
            'litres_of_fuel' => $litres_of_fuel,
            'updated_on' => date('Y-m-d')
        ));
        
        $this->Fuel->save($params);
    }

    public function create_or_save() {
        if (!empty($this->params['data'][$this->model->name])) {
            $object = $this->params['data'][$this->model->name];
            if (empty($object['id'])) {
                if($this->model->create($this->params['data'])) {
                    $id = $this->model->insert_id;
                    //Added to save route's litres of fuel according to truck type
                    $types = $this->get_types();
                    foreach ($types as $type) {
                        $litres_of_fuel = $this->params['data']['Route']['fuel'][$type->id];
                        $this->create_type_fuel($id, $type->id, $litres_of_fuel);
                    }
                    $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'edit', 'id' => $id));
                    $this->flash('notice', __('Successfully created!', 'wpmvc'));
                    $this->redirect($url);
                } else {
                    $this->flash('error', $this->model->validation_error_html);
                    $this->set_object();
                }
            } else {
                if ($this->model->save($this->params['data'])) {
                    //Added to save route's litres of fuel according to truck type
                    $types = $this->get_types();
                    foreach ($types as $type) {
                        $litres_of_fuel = $this->params['data']['Route']['fuel'][$type->id];
                        $this->save_type_fuel($this->params['id'], $type->id, $litres_of_fuel);
                    }
                    $this->flash('notice', __('Successfully saved!', 'wpvmc'));
                    $this->refresh();
                } else {
                    $this->flash('error', $this->model->validation_error_html);
                }
            }
        }
    }

    public function set_clients() {
    	$this->load_model('Client');
        $clients = $this->Client->find(array('selects' => array('id', 'name')));
        $this->set('clients', $clients);
    }

    public function get_client_name($object) {
        return HtmlHelper::admin_object_link($object->client, array('action' => 'edit'));
    }

    public function number_format_da($object) {
        return number_format($object->driver_allowance, 2);
    }

    public function number_format_ma($object) {
        return number_format($object->motorboy_allowance, 2);
    }

    public function number_format_ta($object) {
        return number_format($object->trip_allowance, 2);
    }

    public function number_format_price($object) {
        return number_format($object->price, 2);
    }

    public function set_types() {
        $this->load_model('TruckType');
        $types = $this->TruckType->find(array('selects' => array('id', 'name')));
        $this->set('types', $types);
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

    public function get_types() {
        $this->load_model('TruckType');
        $types = $this->TruckType->find(array('selects' => array('id', 'name')));
        return $types;
    }

}
