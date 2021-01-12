<?php

class AdminCreditWalletsController extends MvcAdminController {

    var $default_columns = array('id', 'manager' => array('value_method' => 'get_user_name'), 'amount' => array('value_method' => 'number_format_amount'), 'created_on');
    var $default_searchable_fields = array('manager', 'amount');

    public function get_user_name($object) {
    	$user = get_userdata($object->manager);
    	return HtmlHelper::link($user->user_nicename ,get_edit_user_link($object->manager));
    }

    public function add() {
    	$this->set_managers();
    	if (!empty($this->params['data']) && !empty($this->params['data']['CreditWallet'])) {
            $this->params['data']['CreditWallet']['created_on'] = date('Y-m-d');
            $this->params['data']['CreditWallet']['updated_on'] = date('Y-m-d');
        }
    	$this->create_or_save();
    }

    public function edit() {
        $this->flash('notice', __('Credit Wallet cannot be edited!'));
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
  	}

  	public function delete() {
  		$this->flash('notice', __('Credit Wallet cannot be deleted!'));
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
  	}

  	public function set_managers() {
        $users = get_users(array('fields' => array('ID', 'user_nicename')));
		$managers = array();
		foreach ($users as $user) {
			$managers[$user->ID] = $user->user_nicename;
		}
        $this->set('managers', $managers);
    }

    public function number_format_amount($object) {
        return number_format($object->amount, 2);
    }

}
