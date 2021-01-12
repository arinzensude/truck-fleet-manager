<?php

class AdminWalletsController extends MvcAdminController {

    var $default_columns = array('id', 'manager' => array('value_method' => 'get_user_name'), 'balance' => array('value_method' => 'number_format_balance'), 'updated_on');
    var $default_searchable_fields = array('manager');

    public function get_user_name($object) {
    	$user = get_userdata($object->manager);
    	return HtmlHelper::link($user->user_nicename ,get_edit_user_link($object->manager));
    }

    public function add() {
  		$this->flash('notice', __('Wallet cannot be added!'));
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
  	}

    public function edit() {
  		$this->flash('notice', __('Wallet cannot be edited!'));
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
  	}

  	public function delete() {
  		$this->flash('notice', __('Wallet cannot be deleted!'));
        $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
        $this->redirect($url);
  	}

    public function number_format_balance($object) {
        return number_format($object->balance, 2);
    }

}
