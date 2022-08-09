<?php

//The configuration below sets the access for the listed controllers to a custom capability called 'truck_fleet_manager)
//which only the administrator and manager userr roles are granted.'
MvcConfiguration::set(array(
    'admin_controller_capabilities' => array(
        'trips' => 'truck_fleet_manager',
        'wallets' => 'truck_fleet_manager',
        'payment_approvals' => 'truck_fleet_manager'
    )
));

//Add monthly financial report menu to Accounts
MvcConfiguration::append(array(
    'AdminPages' => array(
        'accounts' => array(
            'monthly_financial_report',
            'salary',
            'driver_motorboy_allowance'
        )
    )
));

add_action('mvc_admin_init', 'truckfleet_manager_on_mvc_admin_init');
add_action( 'wp_ajax_admin_trips_get_routes', 'get_routes' );
add_action( 'wp_ajax_admin_trips_get_route_info', 'get_route_info' );
add_action( 'wp_ajax_admin_trips_get_client_rate', 'get_client_rate' );
add_action( 'wp_ajax_admin_trips_get_litres_of_fuel', 'get_litres_of_fuel' );
add_action( 'wp_ajax_admin_trips_get_unpaid_driver_allowances', 'get_unpaid_driver_allowances' );
add_action( 'wp_ajax_admin_trips_get_unpaid_motorboy_allowances', 'get_unpaid_motorboy_allowances' );

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
    $results = $wpdb->get_results( "SELECT rate, trip_message FROM {$wpdb->prefix}clients WHERE id = {$_POST["client"]}", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_litres_of_fuel() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT litres_of_fuel FROM {$wpdb->prefix}fuels WHERE route_id = {$_POST["route"]} AND truck_type_id = (SELECT truck_type_id FROM {$wpdb->prefix}trucks WHERE id = {$_POST["truck"]})", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_unpaid_driver_allowances() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT c.name, c.phone_no, c.bank_name, c.account_no, SUM(a.amount), GROUP_CONCAT(b.id) AS trip_ids FROM wp_accounts AS a 
        INNER JOIN wp_trips AS b ON a.type_id = b.id 
        INNER JOIN wp_drivers AS c ON b.driver_id = c.id
        WHERE a.type = 'Trip' AND a.description = 'driver_allowance' AND a.paid_or_received = 0
        GROUP BY c.name", OBJECT );
    echo json_encode($results);
    wp_die();
}

function get_unpaid_motorboy_allowances() {
    global $wpdb;
    $results = $wpdb->get_results( "SELECT d.name, d.phone_no, d.bank_name, d.account_no, SUM(a.amount), GROUP_CONCAT(b.id) AS trip_ids FROM wp_accounts AS a 
        INNER JOIN wp_trips AS b ON a.type_id = b.id 
        INNER JOIN wp_drivers AS c ON b.driver_id = c.id
        INNER JOIN wp_motorboys AS d ON c.motorboy_id = d.id
        WHERE a.type = 'Trip' AND a.description = 'motorboy_allowance' AND a.paid_or_received = 0
        GROUP BY c.name", OBJECT );
    echo json_encode($results);
    wp_die();
}

?>