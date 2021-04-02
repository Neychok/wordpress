<?php

function st_sidebar() {

	register_sidebar(
		array(

			'id' 			=> 'custom',
			'name'          => __( 'Custom Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',

		)
	);

}
add_action( 'widgets_init', 'st_sidebar' );

function st_display_sidebar( $content ) {

	if ( is_active_sidebar( 'custom' ) && ! is_admin() ) {

		return $content .= dynamic_sidebar( 'custom' );

	}

	return $content;

}

add_filter( 'the_content', 'st_display_sidebar', 20 );
