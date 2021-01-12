<?php
/*
Plugin Name: Truck Fleet Manager
Plugin URI:
Description: Helps a trucking company to manage their business
Author: Arinze Nsude
Version: 1.0
Author URI: nadlon.co
*/

register_activation_hook(__FILE__, 'truck_fleet_manager_activate');
register_deactivation_hook(__FILE__, 'truck_fleet_manager_deactivate');

function truck_fleet_manager_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/truck_fleet_manager_loader.php';
    $loader = new TruckFleetManagerLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function truck_fleet_manager_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/truck_fleet_manager_loader.php';
    $loader = new TruckFleetManagerLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true );
}
