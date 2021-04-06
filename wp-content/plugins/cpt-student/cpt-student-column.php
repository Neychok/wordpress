<?php
/**
 *  Creates custom column
 * 
 */

function ajax_enqueue_st() {
    
		global $typenow;

    	if ( $typenow == 'student' ) {

			wp_enqueue_script( 'ajax-script', plugins_url( '/js/cpt-ajax-save.js', __FILE__ ), array( 'jquery' ), false, true );
		
			wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

		}
    
}
add_action( 'admin_enqueue_scripts', 'ajax_enqueue_st' );

// Add column
function st_columns_head( $defaults ) {
	if ( get_post_type() == 'student' ) {
		
		$defaults['activated'] = 'Activated';
	}
	return $defaults;
}
 
// Show checkbox
function st_columns_content( $column_name, $post_ID ) {
    if ( $column_name == 'activated' && get_post_type() == 'student' ) {
		
		echo '<input type="checkbox" id="student-admin-checkbox" name="' . $post_ID . '" ' . ( isset( get_post_meta( $post_ID )['student_status'][0] ) ? checked( get_post_meta( $post_ID )['student_status'][0], 'active', false ) : '' ) . ' />';

    }
}
	add_filter('manage_posts_columns', 'st_columns_head');
	add_action('manage_posts_custom_column', 'st_columns_content', 10, 2);

/**
 * AJAX save
 * 
 */
function st_save() {

	if ( current_user_can( 'edit_others_posts' ) ) {

		if ($_POST['checked'] == 'true') {

			update_post_meta( $_POST['post_id'], 'student_status', 'active' );
	
		} else {
	
			delete_post_meta( $_POST['post_id'], 'student_status' );

		}

	}


}
add_action( 'wp_ajax_st_save', 'st_save' );