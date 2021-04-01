<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$current = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'post_type'         => 'student',
    'post_status'       => 'publish',
    'posts_per_page'    => 4,
    'orderby'           => 'title',
    'order'             => 'ASC',
	'paged'             => $current,
    'meta_query'        => array(
		array(
			'key'   => 'student_status',
			'value' => 'active',
		    )
        ),
);

// The Query
$the_query = new WP_Query( $args );

$description = get_the_archive_description();
?>

<?php if ( $the_query->have_posts() ) : ?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

    <section class="student-archive-wrapper">
	<?php while ( $the_query->have_posts() ) : ?>
		<?php $the_query->the_post(); ?>
        <?php the_ID(); ?>
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
		
	<?php endwhile; ?>
    </section>
	<div style="text-align: center;" class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $the_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => 'paged=%#%',
            'show_all'     => false,
            // 'type'         => 'plain',
            // 'end_size'     => 2,
            // 'mid_size'     => 1,
            // 'prev_next'    => true,
            // 'prev_text'    => sprintf( '<i></i> %1$s', __( 'First Students', 'text-domain' ) ),
            // 'next_text'    => sprintf( '%1$s <i></i>', __( 'Last Students', 'text-domain' ) ),
            // 'add_args'     => false,
            // 'add_fragment' => '',
       		)
		);
    ?>
	</div>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
