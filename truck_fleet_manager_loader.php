<?php

class TruckFleetManagerLoader extends MvcPluginLoader {

    var $db_version = '1.0';
    var $tables = array();

    function activate() {

        // This call needs to be made to activate this app within WP MVC

        $this->activate_app(__FILE__);

        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        add_option('truck_fleet_manager_db_version', $this->db_version);

        $this->tables = array(
            'accounts' => $wpdb->prefix.'accounts',
            'clients' => $wpdb->prefix.'clients',
            'drivers' => $wpdb->prefix.'drivers',
            'motorboys' => $wpdb->prefix.'motorboys',
            'payment_approvals' => $wpdb->prefix.'payment_approvals',
            'routes' => $wpdb->prefix.'routes',
            'trips' => $wpdb->prefix.'trips',
            'trucks' => $wpdb->prefix.'trucks',
            'wallets' => $wpdb->prefix.'wallets',
            'credit_wallets' => $wpdb->prefix.'credit_wallets',
            'fuels' => $wpdb->prefix.'fuels',
            'truck_types' => $wpdb->prefix.'truck_types'
        );
        
        // Use dbDelta() to create the tables for the app here
        
        $sql = '
            CREATE TABLE '.$this->tables['clients'].' (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL,
            address varchar(255) NOT NULL,
            phone_no varchar(255) NOT NULL,
            rate varchar(10) NOT NULL,
            trip_message text default NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['routes'].' (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL,
            client_id int(11) NOT NULL,
            driver_allowance FLOAT(24,2) NOT NULL,
            motorboy_allowance FLOAT(24,2) NOT NULL,
            trip_allowance FLOAT(24,2) NOT NULL,
            price FLOAT(24,2) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['motorboys'].' (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL,
            address varchar(255) NOT NULL,
            phone_no varchar(255) NOT NULL,
            passport varchar(255) NOT NULL,
            bank_name varchar(255) NOT NULL,
            account_no varchar(10) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['drivers'].' (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL,
            address varchar(255) NOT NULL,
            phone_no varchar(255) NOT NULL,
            motorboy_id int(11) default NULL,
            next_of_kin_name varchar(255) NOT NULL,
            next_of_kin_phone varchar(255) NOT NULL,
            license varchar(255) NOT NULL,
            passport varchar(255) NOT NULL,
            reference_name varchar(255) NOT NULL,
            reference_phone varchar(255) NOT NULL,
            bank_name varchar(255) NOT NULL,
            account_no varchar(10) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['truck_types'].' (
            id int(11) NOT NULL auto_increment,
            name varchar(255) NOT NULL,
            description varchar(255) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['fuels'].' (
            id int(11) NOT NULL auto_increment,
            route_id int(11) NOT NULL,
            truck_type_id int(11) NOT NULL,
            litres_of_fuel int(11) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['trucks'].' (
            id int(11) NOT NULL auto_increment,
            truck_type_id int(11) NOT NULL,
            name varchar(255) NOT NULL,
            model varchar(255) NOT NULL,
            year varchar(4) NOT NULL,
            image varchar(255) NOT NULL,
            plate_no varchar(20) NOT NULL,
            particulars varchar(255) NOT NULL,
            particulars_expiry date NOT NULL,
            capital_expenditure FLOAT(24,2) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['trips'].' (
            id int(11) NOT NULL auto_increment,
            invoice_no varchar(255) NOT NULL,
            invoice_date date NOT NULL,
            truck_id int(11) NOT NULL,
            driver_id int(11) NOT NULL,
            client_id int(11) NOT NULL,
            route_id int(11) NOT NULL,
            quantity int(11) default 0,
            rate varchar(10) NOT NULL,
            driver_allowance FLOAT(24,2) NOT NULL,
            motorboy_allowance FLOAT(24,2) NOT NULL,
            trip_allowance FLOAT(24,2) NOT NULL,
            fuel_per_litre FLOAT(24,2) NOT NULL,
            total_fuel_cost FLOAT(24,2) NOT NULL,
            price FLOAT(24,2) NOT NULL,
            total_price FLOAT(24,2) NOT NULL,
            other_expenses FLOAT(24,2) default NULL,
            other_expenses_description varchar(255) default NULL,
            amount_paid FLOAT (24,2) default 0,
            paid_in_full BOOLEAN default 0,
            complete BOOLEAN default 0,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['accounts'].' (
            id int(11) NOT NULL auto_increment,
            mode varchar(10) NOT NULL,
            type varchar(30) NOT NULL,
            type_id int(11) NOT NULL,
            amount FLOAT(24,2) NOT NULL,
            description text default NULL,
            paid_or_received BOOLEAN default 0,
            paid_by bigint(20) default NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['payment_approvals'].' (
            id int(11) NOT NULL auto_increment,
            truck_id int(11) NOT NULL,
            amount FLOAT(24,2) NOT NULL,
            description text NOT NULL,
            approved BOOLEAN default 0,
            requested_by bigint(20) default NULL,
            approved_by bigint(20) default NULL,
            account_id int(11) default NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['wallets'].' (
            id int(11) NOT NULL auto_increment,
            balance FLOAT(24,2) NOT NULL,
            manager bigint(20) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE (manager)
        )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$this->tables['credit_wallets'].' (
            id int(11) NOT NULL auto_increment,
            amount FLOAT(24,2) NOT NULL,
            manager bigint(20) NOT NULL,
            created_on date NOT NULL,
            updated_on date NOT NULL,
            PRIMARY KEY  (id)
        )';
        dbDelta($sql);

    }

    function deactivate() {

        // This call needs to be made to deactivate this app within WP MVC

        $this->deactivate_app(__FILE__);

        // Perform any databases modifications related to plugin deactivation here, if necessary
        global $wpdb;
        $this->tables = array(
            'accounts' => $wpdb->prefix.'accounts',
            'clients' => $wpdb->prefix.'clients',
            'drivers' => $wpdb->prefix.'drivers',
            'motorboys' => $wpdb->prefix.'motorboys',
            'payment_approvals' => $wpdb->prefix.'payment_approvals',
            'routes' => $wpdb->prefix.'routes',
            'trips' => $wpdb->prefix.'trips',
            'trucks' => $wpdb->prefix.'trucks',
            'wallets' => $wpdb->prefix.'wallets',
            'credit_wallets' => $wpdb->prefix.'credit_wallets',
            'fuels' => $wpdb->prefix.'fuels',
            'truck_types' => $wpdb->prefix.'truck_types'
        );

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['credit_wallet'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['wallet'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['account'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['payment_approval'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['clients'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['routes'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['trucks'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['trips'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['drivers'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['motorboys'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['fuels'];
        $wpdb->query($sql);

        $sql = 'DROP TABLE IF EXISTS ' . $this->tables['truck_types'];
        $wpdb->query($sql);

    }

}
