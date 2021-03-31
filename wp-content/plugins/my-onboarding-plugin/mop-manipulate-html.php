<?php
/**  
 * Day 5: Filters
 * 
 * Task: Manipulate HTML output
*/

function mop_prepend( $content ) {
    if ( get_post_type() == 'student' ) {
        $content = '<p>Onboarding Filter: </p>' . $content;
    }
    return $content;
}
function mop_append_name( $content ) {
    if ( get_post_type() == 'student' ) {
        $content .= '<p>By Neycho</p>';
    }
    return $content;
}

function mop_append_hidden_div( $content ) {
    if ( get_post_type() == 'student' ) {
        $content .= '<div style="display: none;"></div>';
    }
    return $content;
}

function mop_opening_p ( $content ) {
    if ( get_post_type() == 'student' ) {
        $content .= '<p class="paragraph">';
    }
    return $content;
}

function mop_closing_p ( $content ) {
    if ( get_post_type() == 'student' ) {
        $content .= '</p>';
    }
    return $content;
}

function mop_append_terms ( $content ) {
    if ( get_post_type() == 'student' ) {
        $content .= the_terms( get_the_id(), 'subject', '<div>', ',', '</div>' );
    }
    return $content;
}

if ( get_option( 'mop_checkbox' ) == 'true' ) {

    add_filter( 'the_content', 'mop_prepend', 10);
    add_filter( 'the_content', 'mop_append_name', 10 );
    add_filter( 'the_content', 'mop_append_hidden_div', 30 );
    add_filter( 'the_content', 'mop_opening_p', 20 );
    add_filter( 'the_content', 'mop_closing_p', 40 );
    add_filter( 'the_content', 'mop_append_terms', 30 );

}

