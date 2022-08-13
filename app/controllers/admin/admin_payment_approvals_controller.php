<?php

class AdminPaymentApprovalsController extends MvcAdminController {

    var $default_columns = array('id', 'truck' => array('value_method' => 'get_truck_name'), 'amount' => array('value_method' => 'number_format_amount'), 'description', 'approved' => array('value_method' => 'is_approved'), 'requested_by' => array('value_method' => 'get_requested_by'), 'approved_by' => array('value_method' => 'get_approved_by'), 'created_on' => 'Created On (YYYY-MM-DD)');
    var $default_searchable_fields = array('truck', 'amount', 'description', 'approved', 'requested_by', 'approved_by');

    public function get_truck_name($object) {
        //For the added GENERAL PAYMENT option
        if ($object->truck == 0)
            return "GENERAL PAYMENT";
        else
            return HtmlHelper::object_link($object->truck);
    }

    public function is_approved($object) {
    	return ($object->approved == 0) ? 'No' : 'Yes';
    }

    public function get_requested_by($object) {
    	$user = get_userdata($object->requested_by);
    	return HtmlHelper::link($user->user_nicename ,get_edit_user_link($object->requested_by));
    }

    public function get_approved_by($object) {
    	$user = get_userdata($object->approved_by);
    	return HtmlHelper::link($user->user_nicename ,get_edit_user_link($object->approved_by));
    }

    public function add() {
    	$this->set_trucks();
    	if (!empty($this->params['data']) && !empty($this->params['data']['PaymentApproval'])) {
            //Commented the line below because the created_on field is now set by the user
            //$this->params['data']['PaymentApproval']['created_on'] = date('Y-m-d');
            $this->params['data']['PaymentApproval']['updated_on'] = date('Y-m-d');
            $this->params['data']['PaymentApproval']['requested_by'] = get_current_user_id();
        }
        if ($this->model->custom_before_save($this->params['data']['PaymentApproval'], 'ADD')) {
            $this->create_or_save();
        } else {
            if (!empty($this->params['data']) && !empty($this->params['data']['PaymentApproval'])) {
                $this->flash('error', __('You do not have enough funds in your wallet to create this Payment Approval', 'wpmvc'));
            }
        }
    }

    public function edit() {
    	$this->load_helper('Truckfleet');
    	$this->set('back_link', $this->truckfleet->back_to_list_link($this->name, 'PaymentApproval'));
    	if (!empty($this->params['data']) && !empty($this->params['data']['PaymentApproval'])) {
            $this->params['data']['PaymentApproval']['updated_on'] = date('Y-m-d');
            if ($this->params['data']['PaymentApproval']['approved'] == 1) {
                $this->params['data']['PaymentApproval']['approved_by'] = get_current_user_id();
            }
        }
        $this->set_trucks();
        $this->verify_id_param();
        $this->set_object();
        if ($this->model->custom_before_save($this->params['data']['PaymentApproval'], 'EDIT', $this->object)) {
            $this->create_or_save();
        } else {
            if (!empty($this->params['data']) && !empty($this->params['data']['PaymentApproval'])) {
                $this->flash('error', __('You do not have enough funds in your wallet to create this Payment Approval', 'wpmvc'));
            }
        }
  	}

  	public function set_trucks() {
    	$this->load_model('Truck');
        $trucks = $this->Truck->find(array('selects' => array('id', 'name')));
        $this->set('trucks', $trucks);
    }

    public function number_format_amount($object) {
        return number_format($object->amount, 2);
    }

}
