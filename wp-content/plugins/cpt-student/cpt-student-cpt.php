<?php
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

function st_load_templates( $original_template ) {

	if ( get_query_var( 'post_type' ) == 'student' ) {

	   if (  is_post_type_archive() || is_search() ) {

		   if ( file_exists( get_stylesheet_directory() . '/archive-student.php' ) ) {

			   return get_stylesheet_directory() . '/archive-student.php';

		   } else {

			   return plugin_dir_path( __FILE__ ) . 'templates/archive-student.php';

		   }

	   }
   }
   return $original_template;

}

add_action( 'template_include', 'st_load_templates' );
