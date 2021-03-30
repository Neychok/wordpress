<?php
// Task: Add logged-in user only menu item
function mop_add_profile_menu( $items, $args ) {
    if ( is_user_logged_in() && 'primary' === $args->theme_location ) {
        $items .= '<li><a title="Admin" href="' . esc_url( get_edit_profile_url() ) . '">' . __( 'My Profile' ) . '</a></li>';
    }
    return $items;
}
if ( get_option( 'mop_checkbox' ) == 'true' ) {
    add_filter( 'wp_nav_menu_items', 'mop_add_profile_menu', 10, 2 );
}