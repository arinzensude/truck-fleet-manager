<?php

class AdminAccountsController extends MvcAdminController {

    var $default_columns = array('id', 'mode', 'type', 'type_id', 'description', 'amount' => array('value_method' => 'number_format_amount'), 
    	'paid_or_received' => array('value_method' => 'get_paid_or_received'), 'created_on');
    var $default_searchable_fields = array('mode', 'type', 'type_id', 'description', 'amount', 'paid_or_received', 'paid_by');

    //How to Use: 'paid_by' => array('value_method' => 'get_user_name') in default columns
    public function get_user_name($object) {
    	$user = get_userdata($object->paid_by);
    	return HtmlHelper::link($user->user_nicename ,get_edit_user_link($object->paid_by));
    }

    public function get_paid_or_received($object) {
    	return ($object->paid_or_received == 0) ? 'No' : 'Yes';
    }

    public function number_format_amount($object) {
        return number_format($object->amount, 2);
    }

    function monthly_financial_report() {
        $month_start; $month_end;

        if (!empty($this->params['month']) && !empty($this->params['year'])) {
            $year = $this->params['year'];
            $month = $this->params['month'];
            $this->set('year', $year);
            $this->set('month', $month);
            $month_start = $d=mktime(0, 0, 0, $month, 1, $year);
            $month_end = $d=mktime(0, 0, 0, $month, 31, $year);
        } else {
            $month_start = $d=mktime(0, 0, 0, date('m'), 1, date('Y'));
            $month_end = $d=mktime(0, 0, 0, date('m'), 31, date('Y'));
        }

        //$month_start = $d=mktime(0, 0, 0, date('m'), 1, date('Y'));
        //$month_end = $d=mktime(0, 0, 0, date('m'), 31, date('Y'));

        $revenue = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'CREDIT',
                'Account.created_on >=' => date("Y-m-d", $month_start),
                'Account.created_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 1
            )
        ));
        $expenditure = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'DEBIT',
                'Account.created_on >=' => date("Y-m-d", $month_start),
                'Account.created_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 1
            )
        ));
        $receivables = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'CREDIT',
                'Account.created_on >=' => date("Y-m-d", $month_start),
                'Account.created_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 0
            )
        ));
        $payables = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'DEBIT',
                'Account.created_on >=' => date("Y-m-d", $month_start),
                'Account.created_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 0
            )
        ));

        //This is so the params are not reset when paginating through the list
        if (empty($this->params['per_page'])) {
            $this->params = array(
                'conditions' => array(
                    'Account.created_on >=' => date("Y-m-d", $month_start),
                    'Account.created_on <=' => date("Y-m-d", $month_end),
                ),
                'page' => 1,
                'per_page' => 10000,
                'order' => 'Account.created_on DESC'
            );
        }
        
        $this->set('revenue', $revenue);
        $this->set('expenditure', $expenditure);
        $this->set('receivables', $receivables);
        $this->set('payables', $payables);
        //$this->set('accounts', $accounts);
        $this->init_default_columns();
        $this->process_params_for_search();
        $collection = $this->model->paginate($this->params);
        $this->set('objects', $collection['objects']);
        $this->set_pagination($collection);
    }

    function salary() {
        $user = get_current_user_id();
        if (!empty($this->params['data']) && !empty($this->params['data']['Account'])) {
            if (is_numeric($this->params['data']['Account']['amount'])) {
                //$this->params['data']['Account']['created_on'] = date('Y-m-d');
                $this->params['data']['Account']['updated_on'] = date('Y-m-d');
                if($this->model->create($this->params['data'])) {
                    $this->model->update_manager_wallet(array('user' => $user, 'amount' =>$this->params['data']['Account']['amount']));
                    $this->flash('notice', __('Salary successfully recorded in Accounts!', 'wpmvc'));
                } else {
                    $this->flash('error', $this->model->validation_error_html);
                    $this->set_object();
                }
            } else {
                $this->flash('error', __('Amount must be a number', 'wpmvc'));
            }
        }
        $this->set_users();
        $this->set('paid_by', $user);

        //List Salary
        //The If condition is so the params are not reset when paginating through the list
        if (empty($this->params['per_page'])) {
            $this->params = array(
                'conditions' => array(
                    'Account.type' => 'Salary',
                ),
                'page' => 1,
                'per_page' => 20,
                'order' => 'Account.created_on DESC'
            );
        }
        
        $this->init_default_columns();
        $this->process_params_for_search();
        $collection = $this->model->paginate($this->params);
        $this->set('objects', $collection['objects']);
        $this->set_pagination($collection);
    }

    function driver_motorboy_allowance() {
        if (!empty($this->params['pay-trip-driver'])) {
            $this->pay_driver_motorboy_allowance($this->params['pay-trip-driver'], 'driver_allowance');
        } elseif (!empty($this->params['pay-trip-motorboy'])) {
            $this->pay_driver_motorboy_allowance($this->params['pay-trip-motorboy'], 'motorboy_allowance');
        } elseif (!empty($this->params['pay-all-trip-driver'])) {
            $this->pay_all_driver_motorboy_allowance('driver_allowance');
        } elseif (!empty($this->params['pay-all-trip-motorboy'])) {
            $this->pay_all_driver_motorboy_allowance('motorboy_allowance');
        }
        $month_start = $d=mktime(0, 0, 0, date('m'), 1, date('Y'));
        $month_end = $d=mktime(0, 0, 0, date('m'), 31, date('Y'));

        //The If condition is so the params are not reset when paginating through the list
        if (empty($this->params['per_page'])) {
            $this->params = array(
                'conditions' => array(
                    'Account.type' => 'Trip',
                    'Account.description' => array('driver_allowance', 'motorboy_allowance'),
                    'Account.paid_or_received' => 1,
                    //'Account.created_on >=' => date("Y-m-d", $month_start),
                    //'Account.created_on <=' => date("Y-m-d", $month_end),
                ),
                'page' => 1,
                'per_page' => 20,
                'order' => 'Account.created_on DESC'
            );
        }

        $this->init_default_columns();
        $this->process_params_for_search();
        $collection = $this->model->paginate($this->params);
        $this->set('objects', $collection['objects']);
        $this->set_pagination($collection);
    }

    //Pay Motorboy and Driver allowance by updating the paid_or_received column in Account table to 1
    public function pay_driver_motorboy_allowance($trip_ids, $description) {
        $this->Account->update_all(
            array('Account.paid_or_received' => 1),
            array(
                'conditions' => array(
                'Account.type' => 'Trip',
                'Account.type_id' => explode(',', $trip_ids),
                'Account.description' => $description,
                )
            )
        );
    }

    //Pay All unpaid Motorboy and Driver allowance by updating the paid_or_received column in Account table to 1
    public function pay_all_driver_motorboy_allowance($description) {
        $this->Account->update_all(
            array('Account.paid_or_received' => 1),
            array(
                'conditions' => array(
                'Account.type' => 'Trip',
                'Account.paid_or_received' => 0,
                'Account.description' => $description,
                )
            )
        );
    }

    public function set_users() {
        $users = get_users(array('fields' => array('ID', 'user_nicename')));
        $managers = array();
        foreach ($users as $user) {
            $managers[$user->ID] = $user->user_nicename;
        }
        $this->set('users', $managers);
    }

}
