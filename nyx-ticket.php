<?php
/**
 * Plugin Name: Nyx tickets
 * Description: This plugin allows you to fetch data from your Nyx account and display upcoming ticketed events on your Wordpress website.
 * Version: 1.3
 * Author: Nyx Systems ApS
 * Author URI: https://nyxapp.net
 */

//No direct calls allowed
if ( !function_exists( 'add_action' ) ) {
    exit;
}

if ( !class_exists( 'WP_Http' ) ) {
    include_once(ABSPATH . WPINC . '/class-http.php');
}

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

define( 'NYX__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once(NYX__PLUGIN_DIR . 'class-nyx-view.php');
require_once(NYX__PLUGIN_DIR . 'class-nyx-init.php');
require_once(NYX__PLUGIN_DIR . 'class-nyx-api.php');

register_uninstall_hook( __FILE__, array( 'Nyx_Init', 'uninstall' ) );

Nyx_Init::init();

(new Nyx_Api())->init();
