<?php

class AdminAccountsController extends MvcAdminController {

    var $default_columns = array('id', 'mode', 'type', 'type_id', 'description', 'amount' => array('value_method' => 'number_format_amount'), 
    	'paid_or_received' => array('value_method' => 'get_paid_or_received'), 
    	'paid_by' => array('value_method' => 'get_user_name'));
    var $default_searchable_fields = array('mode', 'type', 'type_id', 'paid_or_received', 'paid_by');

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
        $month_start = $d=mktime(0, 0, 0, date('m'), 1, date('Y'));
        $month_end = $d=mktime(0, 0, 0, date('m'), 31, date('Y'));

        $revenue = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'CREDIT',
                'Account.updated_on >=' => date("Y-m-d", $month_start),
                'Account.updated_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 1
            )
        ));
        $expenditure = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'DEBIT',
                'Account.updated_on >=' => date("Y-m-d", $month_start),
                'Account.updated_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 1
            )
        ));
        $receivables = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'CREDIT',
                'Account.updated_on >=' => date("Y-m-d", $month_start),
                'Account.updated_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 0
            )
        ));
        $payables = $this->Account->sum('amount', array(
            'conditions' => array(
                'Account.mode' => 'DEBIT',
                'Account.updated_on >=' => date("Y-m-d", $month_start),
                'Account.updated_on <=' => date("Y-m-d", $month_end),
                'Account.paid_or_received' => 0
            )
        ));
        $this->params = array(
            'conditions' => array(
                'Account.updated_on >=' => date("Y-m-d", $month_start),
                'Account.updated_on <=' => date("Y-m-d", $month_end),
            ),
            'page' => 1,
            'per_page' => 20
        );
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

}
