<?php

function mop_add_options() {
    add_menu_page( 'My Onboarding Plugin Settings', 'MOP Settings', 'administrator', 'mop-settings', 'mop_settings_page');
    //add_options_page( 'My Onboarding', 'My Onboarding', 'administrator', 'mop', 'mop_settings_page' );

}

function mop_settings_page() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <?php

        settings_fields( 'section' );

        do_settings_sections( 'mop' );

        ?>
    </div>
    <?php
}

add_action( 'admin_menu', 'mop_add_options' );


function ajax_enqueue_mop() {   
    
    wp_enqueue_script( 'ajax-script', plugins_url( '/js/mop-ajax-save.js', __FILE__ ), array( 'jquery' ), false, true );
    
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
}
add_action( 'admin_enqueue_scripts', 'ajax_enqueue_mop' );

function mop_save() {
    update_option( 'mop_checkbox', $_POST['checked'] );
}

add_action( 'wp_ajax_mop_save', 'mop_save' );

function mop_settings_init() {

    add_settings_section( 'section', 'Settings', null, 'mop');
    
    add_settings_field( 'mop_checkbox', 'Filters Enabled:', 'mop_field_filters_callback', 'mop', 'section' );

    register_setting( 'section', 'mop_checkbox' );

}
 
/**
 * Register our mop_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'mop_settings_init' );

function mop_field_filters_callback() {
    ?>
    <label>Enabled</label>
    <input type="checkbox" name="mop_checkbox"  id="checkbox" <?php checked(get_option( 'mop_checkbox' ), 'true') ?> />
    <?php
}

?>