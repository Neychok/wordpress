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

/**
 * Enqueues javascript file with AJAX
 * And a stylesheet
 * 
 */
function ajax_enqueue_lr() {
    global $pagenow;

    if ( $pagenow == 'admin.php' && $_GET['page'] == 'link-resolver' ) {

        wp_enqueue_script( 'ajax-script', plugins_url( '/js/resolve-link.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        wp_enqueue_style( 'lr_admin_css', plugins_url( '/css/style.css', __FILE__ ) );

    }
}

add_action( 'admin_enqueue_scripts', 'ajax_enqueue_lr' );


/**
 * Adds a admin menu
 * 
 */
function lr_add_menu() {
    add_menu_page( 'Link Resolver', 'Link Resolver', 'administrator', 'link-resolver', 'lr_page' );
}

/**
 * Admin Page
 * 
 */
function lr_page() {
    ?>
    <div class="wrap">
        <div>
            <h1 class="lr-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <label>
                <span>Paste link here:</span>
                <input type="text" id="link-field">
            </label>
            <label>
                <span>When to expire:</span>
                <select id="expiry-field">
                    <option value="3600">1 hour</option>
                    <option value="21600">6 hours</option>
                    <option value="43200">12 hours</option>
                </select>
            </label>
            <button class="button button-primary" id="lr-search">Search</button>
        </div>
        <div id="url-content"><?php echo get_transient( 'cached_result' ) ?></div >
    </div>
    <?php
}

add_action( 'admin_menu', 'lr_add_menu' );


/**
 * Called from resolve-link.js
 * 
 */
function lr_search() {

    if ( isset( $_POST['url'] ) ) {
        // Makes a GET request and gets the body of the response
        $post_result = wp_remote_retrieve_body( wp_remote_get( sanitize_text_field( $_POST['url'] ) ) );
        // Shows result
        echo $post_result;
    }

    if ( isset( $_POST['expiry'] ) ) {
        // Saves result in a transient 
        set_transient( 'cached_result', $post_result, sanitize_text_field( $_POST['expiry'] ) );
    }

}
add_action( 'wp_ajax_lr_search', 'lr_search' );