<?php
/**
 * Plugin Name: My Onboarding Plugin
 * Author: Neycho Kalaydzhiev
 * Version: 1.0
 * License: GPLv2
 * Description: My Onboarding Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
};

require_once plugin_dir_path( __FILE__ ) . 'mop-add-menu-item.php';
require_once plugin_dir_path( __FILE__ ) . 'mop-manipulate-html.php';
require_once plugin_dir_path( __FILE__ ) . 'mop-options.php';
