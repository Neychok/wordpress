<?php
/**
 * Plugin Name: My Database Plugin
 * Author: Neycho Kalaydzhiev
 * Version: 1.0
 * License: GPLv2
 * Description: Creates new database for students CPT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
};
require_once plugin_dir_path( __FILE__ ) . 'admin-page.php';

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install () {

	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'students';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		country tinytext,
		city tinytext,
		address tinytext,
		grade tinyint,
		status tinytext DEFAULT 'inactive' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}

register_activation_hook( __FILE__, 'jal_install' );
