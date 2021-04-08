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

// Exit if accessed directly 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
};

function list_student_render( $atts ) {

	// Some safety checks before procceeding
	if ( ! isset( $atts ) ) return;
	if ( ! isset( $atts["whichToShow"] ) ) return;
	if ( ! isset( $atts["studentToShow"] ) ) return;

	// IF user wants to display active students
	if ( $atts["whichToShow"] === "active" ) {
		
		$meta_query = array(
			array(
				'key'   => 'student_status',
				'value' => "active",
			)
		);

	// IF user wants to display inactive students
	} elseif ( $atts["whichToShow"]  === "inactive" ) {

		$meta_query = array(
			array(
				'key'   => 'student_status',
				'compare' => "NOT EXISTS",
			)
		);

	} else return;

	// Arguments for WP_Query
	$args = array(
		'post_type'         => 'student',
		'post_status'       => 'publish',
		'posts_per_page'    => $atts["studentToShow"],
		'orderby'           => 'date',
		'order'             => 'DESC',
		'paged'             => 1,
		'meta_query'        => $meta_query
	);

	// THE QUERY
	$the_query = new WP_Query( $args );
	
	// Starts OUTPUT BUFFER
	ob_start();
	?>

	<!-- Checks if the query result has any posts (students) -->
	<?php if ( $the_query->have_posts() ) : ?>

		<!-- Wrapper for the students -->
		<div className="students">

		<!-- Loop through the query results (students) -->
		<?php while ( $the_query->have_posts() ) : ?>

			<?php $the_query->the_post(); ?>

			<a className="student" href="<?php echo the_permalink(); ?>">
				<!-- If student has no thumbnail uses a placeholder. Here just for testing purposes -->
				<?php if ( has_post_thumbnail() ) the_post_thumbnail();
						else echo '<img src="https://via.placeholder.com/150">'; ?>
				<!-- The name of the student -->
				<?php the_title(); ?>
			</a>

		<!-- The of while loop -->
		<?php endwhile; ?>

		<!-- Closing student wrapper -->
		</div>

	<!-- If Query has no posts (students) -->
	<?php else :?>
		<div>No students found!</div> 
	<?php endif ?>
	
	<?php
	// Stops OUTPUT BUFFER and saves it in $args
	$html = ob_get_clean();

	// Should return an HTML
	return $html;
}

/**
 * Registers the new Block
 */
function create_block_list_students_block_init() {
	register_block_type_from_metadata( __DIR__, [
		
		/**
		 * Callback to the function that will render the block
		 * It's required for dynamic blocks
		 * ( Blocks without save function ) 
		 */
		'render_callback' => 'list_student_render',

		'attributes' => [
			// Used for posts_per_page to determine how much students to show
			'studentToShow' => [
				'type' => 'number',
				'default' => 5
			],
			// Used for the meta_query to determine which student to show (active or inactive)
			'whichToShow' => [
				'type' => 'string',
				'default' => 'active'
			],
		]] );
}
add_action( 'init', 'create_block_list_students_block_init' );

/**
 * Makes "student_status" available to the REST API
 */
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
