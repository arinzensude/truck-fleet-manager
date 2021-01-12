<?php

MvcRouter::public_connect('{:controller}', array('action' => 'index'));
MvcRouter::public_connect('{:controller}/{:id:[\d]+}', array('action' => 'show'));
MvcRouter::public_connect('{:controller}/{:action}/{:id:[\d]+}');

//MvcRouter::admin_ajax_connect(array('controller' => 'admin_trips_controller', 'action' => 'get_routes'));
?>