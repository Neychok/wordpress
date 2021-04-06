<?php

/**
 * Gets all students data 
 * or specific student if ID is specified
 * 
 * @param WP_REST_Request $request
 * 
 * @return array|null All students' data, specific student's data or null.
 */

function st_get_student( $request ) {

	// Arguments for Query
	$args = array(

		'post_type' => 'student',
		'posts_per_page'    => 4,
		'post_status' => array('publish', 'pending', 'draft'),
		// 'orderby'           => 'title',
    	// 'order'             => 'ASC',

	);

	// Checks if user passed ID
	if ( $request->has_param( 'ID' ) ) {

		$args += ['p' => $request->get_param( 'ID' )];
	
	}

	$the_query = new WP_Query( $args );

	$data = [];

	$i 	  = 0;

	if ( $the_query->have_posts() ) {

		$posts = $the_query->posts;
		
		foreach ( $posts as $post ) {

			$meta_data = get_post_meta( $post->ID );

			$data[ $i ]['ID']                        	= $post->ID;
			$data[ $i ]['post_status']                  = $post->post_status;
			$data[ $i ]['title'] 						= $post->post_title;
			$data[ $i ]['excerpt'] 						= $post->post_excerpt;
			$data[ $i ]['content'] 						= $post->post_content;
			$data[ $i ]['slug'] 						= $post->post_name;
			$data[ $i ]['featured_image']['thumbnail'] 	= get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
			$data[ $i ]['featured_image']['medium'] 	= get_the_post_thumbnail_url( $post->ID, 'medium' );
			$data[ $i ]['featured_image']['large'] 		= get_the_post_thumbnail_url( $post->ID, 'large' );
			$data[ $i ]['date'] 						= $post->post_date;
			// Custom meta
			$data[ $i ]['student_status'] 				= isset( $meta_data['student_status'] ) ? $meta_data['student_status'] : '';
			$data[ $i ]['country'] 						= isset( $meta_data['student_country'] ) ? $meta_data['student_country'] : '';
			$data[ $i ]['city'] 						= isset( $meta_data['student_city'] ) ? $meta_data['student_city'] : '';
			$data[ $i ]['address'] 						= isset( $meta_data['student_address'] ) ? $meta_data['student_address'] : '';
			$data[ $i ]['grade'] 						= isset( $meta_data['student_grade'] ) ? $meta_data['student_grade'] : '';

			$i++;
			
		}
		return $data;
		
	} else {
		return null;
	}

}

/** 
 *  Adds/Edits student
 * 
 * @param WP_REST_Request $request
 * 
 * @return int returns new/edited post's ID.
 */
function st_add_student( $request ) {

	// Sanitizes the request
	$sanitized_request = sanitize_post( $request, 'db' );

	// IF REQUEST METHOD IS POST
	if ( $sanitized_request->get_method() === 'POST' ) {

		// Checks if user specified ID | User shouldn't be able to set the ID
		if ( ! ( $sanitized_request->has_param( 'ID' ) ) ) {
			
			// Adds 'student' as post type into the paramenters for wp_insert_post
			$sanitized_request->set_param( 'post_type', 'student' );

			// Inserts new student into DB and return it's ID
			return wp_insert_post( $sanitized_request->get_params(), true );

		} else return 400; // Gives error if user HAS specified ID
	
	// IF REQUEST METHOD IS PUT
	} elseif ( $sanitized_request->get_method() === 'PUT' ) {
		
		// Checks if user specified ID
		if ( $sanitized_request->has_param( 'ID' ) ) {

			// Adds 'student' as post type into the paramenters for wp_insert_post
			$sanitized_request->set_param( 'post_type', 'student' );

			// Inserts new data to user and return it's ID
			return wp_insert_post( $sanitized_request->get_params(), true );

		} else return 400; // Gives error if user HASN'T specified ID

	}
}

/** 
 *  Deletes a student
 * 
 * @param WP_REST_Request $request that contains student's ID
 * 
 * @return array|bool student's data if successful, false otherwise.
 */

function st_delete_student( $request ) {

	// Sanitizes the request
	$sanitized_request = sanitize_post( $request, 'db' );

	// Checks if user specified ID
	if ( $sanitized_request->has_param( 'ID' ) ) {

		// Saves the ID of the student
		$id = $sanitized_request->get_param('ID');

		if ( get_post_status( $id ) ) return wp_delete_post( $id );

	} else {
		return false; // Return False if there is no ID specified
	}

}

  /**
   * Register Rest Routes
   */

   function st_register_rest_route() {

	$my_namespace = 'cpt-student/v';
	$my_version   = '1';

	$namespace = $my_namespace . $my_version;

	// Get student by ID if specified else get all students
	register_rest_route( $namespace, '/student/(?P<ID>\d+)', array(
		'methods' 				=> 'GET',
		'callback' 				=> 'st_get_student',
		'permission_callback' 	=> '__return_true',
		'args' 					=> array(
			'ID' => array(

				'validate_callback' => function($param, $request, $key) {

					return is_numeric( $param );

				}
			),
		),
		) 
	);

	// Add / edit student
	register_rest_route( $namespace, '/student/', array(

		// GET METHOD | Get all student or student by ID
		array(
			'methods' 				=> 'GET',
			'callback' 				=> 'st_get_student',
			'permission_callback' 	=> '__return_true',
		),

		// POST, PUT METHOD | Add new or edit student
		array(
			'methods' 				=> ['POST', 'PUT'],
			'callback' 				=> 'st_add_student',
			'permission_callback' 	=> function () {
				return current_user_can( 'administrator' );
			  },
			'args' 					=> array(
	
				'ID' => array(
					'type' => 'integer',
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					}
				),
				'post_title' => array(
					'required' => true,
					'type' => 'string',
					'sanitize_callback' => function( $param ) {
						return sanitize_text_field( $param );
					}
				),
				'post_content' => array(
					'required' => true,
					'type' => 'string',
					'sanitize_callback' => function( $param ) {
						return sanitize_textarea_field( $param );
					}
				),
			),
		),

		// DELETE METHOD | Deletes a student
		array(
			'methods' 				=> 'DELETE',
			'callback' 				=> 'st_delete_student',
			'permission_callback' 	=> function () {
				return current_user_can( 'administrator' );
			  },
			'args' 					=> array(
	
				'ID' => array(
	
					'required' => true,
					'type' => 'integer',
					'validate_callback' => function($param, $request, $key) {
	
						return is_numeric( $param );
	
					}
	
				),
	
			),
		)

	) );
}

add_action( 'rest_api_init', 'st_register_rest_route' );
