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

}
