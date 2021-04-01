<?php
/**
 * Plugin Name: CPT Student
 * Author: Neycho Kalaydzhiev
 * Version: 1.0
 * License: GPLv2
 * Description: Custom Post Type Student
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
};

function st_enqueue_scripts() {
    wp_enqueue_style( 'student_css', plugins_url( '/css/style.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'st_enqueue_scripts' );

require_once plugin_dir_path( __FILE__ ) . 'cpt-student-cpt.php';
require_once plugin_dir_path( __FILE__ ) . 'cpt-student-fields.php';
require_once plugin_dir_path( __FILE__ ) . 'cpt-student-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'cpt-student-widget.php';