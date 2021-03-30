<?php
/**
 * Template Name: Custom Template
 * description: my custom page template
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
?>
	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<section class="entry-content">
		<?php the_content(); ?>
		<p>Published: <?php the_date( '', '<span>', '</span>' ); ?></p>
	</section>

<?php 
endwhile; // End of the loop.

get_footer();
