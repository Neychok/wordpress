<?php

function st_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'student-id' => '',
	), $atts );

	$args = array(
		'post_type' => 'student',
		'p' 		=> $atts['student-id'],
	);

	$student_by_id = new WP_Query( $args );
	if ( $student_by_id->have_posts() ) :
		while ( $student_by_id->have_posts() ) : ?>
				<?php $student_by_id->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="student-wrapper">
					<div class="student-thumb">
						<?php 
						if ( has_post_thumbnail() ) {

							the_post_thumbnail();

						} else {

							echo '<img src="https://via.placeholder.com/150">';

						}?>
					</div>
					<div class="student-archive-detail">
						<?php the_title(); ?>
						<?php the_excerpt(); ?>
					</div>
				</a>
			<?php 
			endwhile;

	else : ?>
		<div>No students by this ID found!</div>
	<?php endif;

}
add_shortcode( 'student_by_id', 'st_shortcode' );