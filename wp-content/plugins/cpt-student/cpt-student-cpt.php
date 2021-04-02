<?php
/**
 * Registers Custom Post Type
 * 
 */
function st_register_post_type() {

	$singular = 'Student';
	$plural   = 'Students';

	$labels = array(
		'name'               => $plural,
		'singular'           => $singular,
		'add_name'           => 'Add New',
		'add_new_item'       => 'Add New ' . $singular,
		'edit'               => 'Edit',
		'edit_item'          => 'Edit ' . $singular,
		'new_item'           => 'New ' . $singular,
		'view'               => 'View ' . $singular,
		'view_item'          => 'View ' . $singular,
		'search_term'        => 'Search ' . $plural,
		'parent'             => 'Parent ' . $singular,
		'not_found'          => 'No ' . $singular,
		'not_found_in_trash' => 'No ' . $plural . ' in Trash',
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_rest'		=> true,
		'menu_position'     => 4,
		'menu_icon'         => 'dashicons-welcome-learn-more',
		'can_export'        => true,
		'delete_with_user'  => false,
		'hierarchical'      => false,
		'has_archive'       => true,
		'query_var'         => true,
		'capability_type'   => 'post',
		'map_meta_cap'      => true,
		'rewrite'           => array(
			'slug' => 'students',
		),
		'supports'          => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
		),
	);

	register_post_type( 'student', $args );
}

add_action( 'init', 'st_register_post_type' );

/**
 * Registers Taxonomy
 * 
 */
function st_register_taxonomy() {

	$singular = 'Subject';
	$plural   = 'Subjects';

	$labels = array(
		'name'                       => $plural,
		'singular_name'              => $singular,
		'search_items'               => 'Search ' . $plural,
		'popular_items'              => 'Popular ' . $plural,
		'all_items'                  => 'All ' . $plural,
		'parent_items'               => null,
		'parent_items_colon'         => null,
		'edit_item'                  => 'Edit ' . $singular,
		'update_item'                => 'Update ' . $singular,
		'add_new_item'               => 'Add New ' . $singular,
		'new_item_name'              => 'New ' . $singular . ' Name',
		'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
		'add_or_remove_items'        => 'Add or remove ' . $plural,
		'choose_from_most_used'      => 'Choose from the most used ' . $plural,
		'not_found'                  => 'No ' . $plural . ' found.',
		'menu_name'                  => $plural,
	);

	$args = array(
		'hierarchical'               => true,
		'labels'                     => $labels,
		'rewrite'                    => array( 'slug' => 'subject' ),
	);

	register_taxonomy( 'subject', 'student', $args );

}

add_action( 'init', 'st_register_taxonomy' );

/**
 * Loads custom templates
 * 
 */
function st_load_templates( $original_template ) {

	if ( get_query_var( 'post_type' ) === 'student' ) {
		
		if ( is_post_type_archive() || is_search() ) {

		   if ( file_exists( get_stylesheet_directory() . '/archive-student.php' ) ) {

			return get_stylesheet_directory() . '/archive-student.php';

		   } else {

			   return plugin_dir_path( __FILE__ ) . 'templates/archive-student.php';

		   }

	   } else {

			if ( file_exists( get_stylesheet_directory() . '/single-student.php' ) ) {

				return get_stylesheet_directory() . '/single-student.php';

			} else {

				return plugin_dir_path( __FILE__ ) . 'templates/single-student.php';

			}
		}
   	}
   return $original_template;

}

add_action( 'template_include', 'st_load_templates' );

/**
 *  Creates custom column
 * 
 */

function ajax_enqueue_st() {   
    
    wp_enqueue_script( 'ajax-script', plugins_url( '/js/cpt-ajax-save.js', __FILE__ ), array( 'jquery' ), false, true );
    
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
}
add_action( 'admin_enqueue_scripts', 'ajax_enqueue_st' );

// Add column
function st_columns_head( $defaults ) {
    $defaults['activated'] = 'Activated';
    return $defaults;
}
 
// Show checkbox
function st_columns_content( $column_name, $post_ID ) {
    if ( $column_name == 'activated' ) {
		
		echo '<input type="checkbox" id="student-admin-checkbox" value="' . $post_ID . '" ' . ( isset( get_post_meta( $post_ID )['student_status'][0] ) ? checked( get_post_meta( $post_ID )['student_status'][0], 'active', false ) : '' ) . ' />';

    }
}

add_filter('manage_posts_columns', 'st_columns_head');
add_action('manage_posts_custom_column', 'st_columns_content', 10, 2);


/**
 * AJAX save
 * 
 */
function st_save() {

	if ($_POST['checked'] == 'true') {

		update_post_meta( $_POST['post_id'], 'student_status', 'active' );

	} else {

		delete_post_meta( $_POST['post_id'], 'student_status' );

	}
}
add_action( 'wp_ajax_st_save', 'st_save' );