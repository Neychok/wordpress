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

ob_start();
?>
<div className="students">
<?php if (isset( $atts["students"] ) ) : ?>
	<?php foreach($atts["students"] as $student) : ?>

		<?php if ($student["student_status"] == $atts["whichToShow"]) :?>
			<?php $image = isset($student["_embedded"]["wp:featuredmedia"][0]["source_url"]) ? $student["_embedded"]["wp:featuredmedia"][0]["source_url"] : "" ?>

			<a className="student" href="<?php echo is_admin() ? '#' : $student["link"]; ?>">
				<img className="student-image" src=<?php echo $image; ?> />
				<h3 className="student-name"><?php echo $student["title"]["rendered"]; ?></h3>
				<div></div>
			</a>
		<?php endif ?>
	<?php endforeach ?>
<?php endif ?>
</div>

<?php
$args = ob_get_clean();

return $args;
}

function create_block_list_students_block_init() {
	register_block_type_from_metadata( __DIR__, [
		'render_callback' => 'list_student_render',
		'attributes' => [
			'students' => [
				'type' => 'array'
			],
			'studentToShow' => [
				'type' => 'number',
				'default' => 5
			],
			'whichToShow' => [
				'type' => 'string',
				'default' => 'active'
			]
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

// add_filter( 'rest_team_query', function( $args, $request ){
//     if ( $meta_key = $request->get_param( 'metaKey' ) ) {
//         $args['meta_key'] = $meta_key;
//         $args['meta_value'] = $request->get_param( 'metaValue' );
//     }
//     return $args;
// }, 10, 2 );