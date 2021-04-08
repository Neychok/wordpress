<?php
/**
 * Plugin Name:       List Students
 * Description:       Just displays a list of students.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       list-students
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */

function list_student_render( $atts, $content ) {
	if ( ! isset( $atts ) ) return;
	if ( ! isset( $atts["students"] ) ) return;

	$args = array(
		'post_type'         => 'student',
		'post_status'       => 'publish',
		'posts_per_page'    => $atts["studentToShow"],
		'orderby'           => 'date',
		'order'             => 'DESC',
		'paged'             => 1,
		'meta_query'        => array(
			array(
				'key'   => 'student_status',
				'value' => $atts["whichToShow"],
				)
			),
	);
	$the_query = new WP_Query( $args );
	
	ob_start();
	?>


	<?php if ( $the_query->have_posts() ) : ?>
		<div className="students">
		<?php while ( $the_query->have_posts() ) : ?>
			<?php $the_query->the_post(); ?>
			<?php var_dump(get_post_meta( 262 ) ) ?>
			<a className="student" href="<?php echo the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) the_post_thumbnail();
						else echo '<img src="https://via.placeholder.com/150">'; ?>
				<?php the_title(); ?>
			</a>
		<?php endwhile ?>
		</div>
	<?php endif ?>
	<?php
	$args = ob_get_clean();

	return $args;
}

function create_block_list_students_block_init() {
	register_block_type_from_metadata( __DIR__, [
		'render_callback' => 'list_student_render',
		'attributes' => [
			'students' => [
				'type' => 'array',
			],
			'studentToShow' => [
				'type' => 'number',
				'default' => 5
			],
			'whichToShow' => [
				'type' => 'string',
				'default' => 'active'
			],
		]] );
}
add_action( 'init', 'create_block_list_students_block_init' );

function add_custom_field() {
    register_rest_field( 'student',
        'student_status',
        array(
            'get_callback'  => 'rest_get_post_field',
            'update_callback'   => null,
            'schema'            => null,
        )
    );
}
add_action( 'rest_api_init', 'add_custom_field' );

function rest_get_post_field( $post, $field_name, $request ) {
    return get_post_meta( $post[ 'id' ], $field_name, true );
}
