<?php

/**
 * Gets all students data
 * 
 * @return string|null All students data or null if none.
 */

function st_get_all_students() {

	$args = array(

		'post_type' => 'student',

	);

	$posts = get_posts( $args );

	if ( isset( $posts ) ) {

		$data = [];

		$i 	  = 0;

		foreach ( $posts as $post ) {

			$data[ $i ]['id']                        	= $post->ID;
			$data[ $i ]['title'] 						= $post->post_title;
			$data[ $i ]['excerpt'] 						= $post->post_excerpt;
			$data[ $i ]['content'] 						= $post->post_content;
			$data[ $i ]['slug'] 						= $post->post_name;
			$data[ $i ]['featured_image']['thumbnail'] 	= get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
			$data[ $i ]['featured_image']['medium'] 	= get_the_post_thumbnail_url( $post->ID, 'medium' );
			$data[ $i ]['featured_image']['large'] 		= get_the_post_thumbnail_url( $post->ID, 'large' );
			$data[ $i ]['date'] 						= $post->post_date;
			// Custom meta
			$data[ $i ]['country'] 						= get_post_meta( $post->ID, 'student_country', true );
			$data[ $i ]['city'] 						= get_post_meta( $post->ID, 'student_city', true );
			$data[ $i ]['address'] 						= get_post_meta( $post->ID, 'student_address', true );
			$data[ $i ]['grade'] 						= get_post_meta( $post->ID, 'student_grade', true );

			$i++;

		}

		return $data;

	} else {

		return null;

	}

}

 /**
  * Get student by ID
  * 
  * @param int $id ID of the student.
  * @return string|null The data of that student or null if none.
  */

function st_get_student( $request ) {

	$args = array(

		'p' 		=> $request['id'],
		'post_type' => 'student',

	);

	$post = get_posts( $args );

	if ( isset( $post[0] ) ) {

		$data = [];

		$data['id'] 						 = $post[0]->ID;
		$data['title'] 						 = $post[0]->post_title;
		$data['excerpt'] 					 = $post[0]->post_excerpt;
		$data['content'] 					 = $post[0]->post_content;
		$data['slug'] 						 = $post[0]->post_name;
		$data['featured_image']['thumbnail'] = get_the_post_thumbnail_url( $post[0]->ID, 'thumbnail' );
		$data['featured_image']['medium'] 	 = get_the_post_thumbnail_url( $post[0]->ID, 'medium' );
		$data['featured_image']['large'] 	 = get_the_post_thumbnail_url( $post[0]->ID, 'large' );
		$data['date'] 						 = $post[0]->post_date;
		// Custom meta
		$data['country'] 					 = get_post_meta( $post[0]->ID, 'student_country', true );
		$data['city'] 						 = get_post_meta( $post[0]->ID, 'student_city', true );
		$data['address'] 					 = get_post_meta( $post[0]->ID, 'student_address', true );
		$data['grade'] 						 = get_post_meta( $post[0]->ID, 'student_grade', true );

		return $data;

	} else {

		return null;

	}
}

/** 
 *  Adds a new student
 * 
 * @param int $id ID of the student.
 * @return bool true if successful, false otherwise.
 */

function st_add_student( $request ) {

	$args = array(

		'p' 		=> $request['id'],
		'post_type' => 'student',
		
	);
	
	$post = get_posts( $args );
	
	if ( isset( $post[0] ) ) {
		
		
		
	} else {
		
		return null;
		
	}
	
}

/** 
 *  Edits a student
 * 
 * @param int $id ID of the student.
 * @return bool true if successful, false otherwise.
 */

function st_edit_student( $request ) {

	return 'helllo';

	$args = array(

		'p' 		=> $request['id'],
		'post_type' => 'student',

	);

	$post = get_posts( $args );

	if ( isset( $post[0] ) ) {

		

	} else {

		return null;

	}

}

/** 
 *  Deletes a student
 * 
 * @param int $id ID of the student.
 * @return bool true if successful, false otherwise.
 */

function st_delete_student( $request ) {

	$args = array(

		'p' 		=> $request['id'],
		'post_type' => 'student',

	);

	$post = get_posts( $args );

	if ( isset($post[0] ) ) {

		

	} else {

		return null;

	}

}


  /**
   * Register Rest Route
   */

   function st_register_rest_route() {

	//* Get all students
	register_rest_route( 'cpt-student/v1', '/all-students/', array(

		'methods' 				=> 'GET',
		'callback' 				=> 'st_get_all_students',
		'permission_callback' 	=> '__return_true',

	) );

	//* Get student by ID
	register_rest_route( 'cpt-student/v1', '/student/(?P<id>\d+)', array(
		'methods' 				=> 'GET',
		'callback' 				=> 'st_get_student',
		'permission_callback' 	=> '__return_true',
		'args' 					=> array(

			'id' => array(

				'validate_callback' => function($param, $request, $key) {

					return is_numeric( $param );

				}

			),

		),
	) );

	//* Add student
	register_rest_route( 'cpt-student/v1', '/add-student/', array(

		'methods' 				=> 'POST',
		'callback' 				=> 'st_add_student',
		'permission_callback' 	=> '__return_true',

	) );
	
	//* Edit student
	register_rest_route( 'cpt-student/v1', '/edit-student/', array(

		'methods' 				=> 'GET',
		'callback' 				=> 'st_edit_student',
		'permission_callback' 	=> function () {
			return current_user_can( 'edit_posts' );
		  },

	) );

	//* Delete student
	register_rest_route( 'cpt-student/v1', '/delete-student/', array(

		'methods' 				=> 'POST',
		'callback' 				=> 'st_delete_student',
		'permission_callback' 	=> '__return_true',

	) );

   }

   add_action( 'rest_api_init', 'st_register_rest_route' );