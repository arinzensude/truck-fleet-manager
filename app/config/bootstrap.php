<?php

add_action('mvc_admin_init', 'truckfleet_manager_on_mvc_admin_init');
add_action( 'wp_ajax_admin_trips_get_routes', 'get_routes' );
add_action( 'wp_ajax_admin_trips_get_route_info', 'get_route_info' );
add_action( 'wp_ajax_admin_trips_get_client_rate', 'get_client_rate' );
add_action( 'wp_ajax_admin_trips_get_litres_of_fuel', 'get_litres_of_fuel' );

function truckfleet_manager_on_mvc_admin_init($options) {
    wp_register_script('mvc_admin_js', mvc_js_url('truck-fleet-manager', 'admin'));
    wp_enqueue_script('mvc_admin_js');
}

function get_routes() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT id, name FROM {$wpdb->prefix}routes WHERE client_id = {$_POST["client"]}", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_route_info() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}routes WHERE id = {$_POST["route"]}", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_client_rate() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT rate FROM {$wpdb->prefix}clients WHERE id = {$_POST["client"]}", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_litres_of_fuel() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT litres_of_fuel FROM {$wpdb->prefix}fuels WHERE route_id = {$_POST["route"]} AND truck_type_id = (SELECT truck_type_id FROM {$wpdb->prefix}trucks WHERE id = {$_POST["truck"]})", OBJECT );
    echo json_encode($results);
    wp_die();
}

?>