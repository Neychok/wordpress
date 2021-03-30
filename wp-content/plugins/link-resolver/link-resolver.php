<?php
/**
 * Plugin Name: Link Resolver
 * Author: Neycho Kalaydzhiev
 * Version: 1.0
 * License: GPLv2
 * Description: Link Resolver Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
};

function ajax_enqueue_lr() {
    wp_enqueue_script( 'ajax-script', plugins_url( '/js/resolve-link.js', __FILE__ ), array( 'jquery' ), false, true );
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'admin_enqueue_scripts', 'ajax_enqueue_lr' );

function lr_add_menu() {
    add_menu_page( 'Link Resolver', 'Link Resolver', 'administrator', 'link-resolver', 'lr_page' );
}

function lr_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <label>
            <span>Paste link here:</span>
            <input type="text" id="link-field">
        </label>
        <button class="button button-primary" id="lr-search">Search</button>
    </div>
    <?php
}

add_action( 'admin_menu', 'lr_add_menu' );

function lr_search() {
    var_dump($_POST);
}
add_action( 'wp_ajax_lr_search', 'lr_search' );