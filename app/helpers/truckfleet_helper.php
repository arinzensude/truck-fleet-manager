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

}
