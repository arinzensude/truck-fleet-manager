<?php

class TruckfleetHelper extends MvcHelper {

    public function back_to_list_link($model_admin_name, $model_name) {
  		$url = MvcRouter::admin_url(array('controller' => $model_admin_name));
  		$text = 'Back to '.$model_name.'s List';
  		return HtmlHelper::link($text, $url);
  	}

  	public function edit_link($model_admin_name, $id) {
  		$url = MvcRouter::admin_url(array('controller' => $model_admin_name, 'action' => 'edit', 'id' => $id));
  		$text = 'Edit';
  		return HtmlHelper::link($text, $url);
  	}

  	public function delete_link($model_admin_name, $id) {
  		$url = MvcRouter::admin_url(array('controller' => $model_admin_name, 'action' => 'delete', 'id' => $id));
  		$text = 'Delete';
  		return HtmlHelper::link($text, $url);
  	}

    public function back_to_model_public_link($object) {
      return HtmlHelper::object_link($object);
    }

    public function get_truck_financials($truck_id) {
      $truck = array();
      global $wpdb;
      $rows = $wpdb->get_results( "SELECT SUM(account.amount) AS amount FROM {$wpdb->prefix}accounts AS account JOIN {$wpdb->prefix}trips ON account.type = 'Trip' AND account.type_id = {$wpdb->prefix}trips.id JOIN {$wpdb->prefix}trucks ON {$wpdb->prefix}trips.truck_id = {$wpdb->prefix}trucks.id WHERE {$wpdb->prefix}trucks.id = {$truck_id} AND account.paid_or_received = 1 AND account.mode = 'DEBIT'", OBJECT );
      $rows1 = $wpdb->get_results( "SELECT SUM(account.amount) AS amount FROM {$wpdb->prefix}accounts AS account JOIN {$wpdb->prefix}trips ON account.type = 'Trip' AND account.type_id = {$wpdb->prefix}trips.id JOIN {$wpdb->prefix}trucks ON {$wpdb->prefix}trips.truck_id = {$wpdb->prefix}trucks.id WHERE {$wpdb->prefix}trucks.id = {$truck_id} AND account.paid_or_received = 1 AND account.mode = 'CREDIT'", OBJECT );
      $rows2 = $wpdb->get_results( "SELECT SUM(account.amount) AS amount FROM {$wpdb->prefix}accounts AS account JOIN {$wpdb->prefix}payment_approvals ON account.type = 'PaymentApproval' AND account.type_id = {$wpdb->prefix}payment_approvals.id JOIN {$wpdb->prefix}trucks ON {$wpdb->prefix}payment_approvals.truck_id = {$wpdb->prefix}trucks.id WHERE {$wpdb->prefix}trucks.id = {$truck_id} AND account.paid_or_received = 1 AND account.mode = 'DEBIT'", OBJECT );
      foreach ($rows as $key => $value) {
        $truck['account_debit'] = $rows[$key]->amount;
        $truck['account_credit'] = $rows1[$key]->amount;
        $truck['payment_debit'] = $rows2[$key]->amount;
        break;
      }
      $truck['debit'] = $truck['payment_debit'] + $truck['account_debit'];
      return $truck;
    }

}
