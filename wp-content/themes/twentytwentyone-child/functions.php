<?php

// function my_post_queries( $query ) {
  
//     if ( ! is_admin() && $query->is_main_query() && get_post_type($query) == 'post' ){

//         if ( is_home() || is_archive() ){
          
//           $query->set( 'posts_per_page', 8 );

//         }

//     }

// }
// add_action( 'pre_get_posts', 'my_post_queries' );

add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/style.css' );
});