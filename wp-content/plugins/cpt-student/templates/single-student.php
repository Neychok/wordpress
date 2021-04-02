<?php

get_header();

?>

<main id="site-content" role="main">

<?php

if ( have_posts() ) {

	$student_country = get_post_meta( get_the_ID(), 'student_country', true );
	$student_city = get_post_meta( get_the_ID(), 'student_city', true );
	$student_address = get_post_meta( get_the_ID(), 'student_address', true );
	$student_grade = get_post_meta( get_the_ID(), 'student_grade', true );
	?>

	<div class="student-image"><?php the_post_thumbnail() ?></div>
	<h1 class="student-name"><?php the_title(); ?></h1>
	<div class="student-details">
		<p>Country: <?php echo esc_html( $student_country ); ?></p>
		<p>City: <?php echo esc_html( $student_city ); ?></p>
		<p>Address: <?php echo esc_html( $student_address ); ?></p>
		<p>Grade: <?php echo esc_html( $student_grade ); ?></p>
	</div>

	<section class="student-content">
	<?php the_content() ?>
	</section>
	<?php

}

?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>