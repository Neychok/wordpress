<?php
// Creating the widget 
class display_students_widget extends WP_Widget {
  
	function __construct() {
		parent::__construct(
		
		// Base ID of your widget.
		'display_students_widget', 
		
		// Widget name will appear in UI.
		'Display Students', 
		
		// Widget description
		array( 'description' => 'Sample description', ) );
	}

	/**
	 * Creating widget front-end.
	 */
	public function widget( $args, $instance ) {

		$posts_per_page = apply_filters( 'widget_posts_per_page', $instance['posts_per_page'] );
		$status = apply_filters( 'widget_status', $instance['status'] );

		// before and after widget arguments are defined by themes.
		echo $args['before_widget'];

		// This is where you run the code and display the output.
		$current = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = array(
			'post_type'         => 'student',
			'post_status'       => 'publish',
			'posts_per_page'    => $posts_per_page,
			'orderby'           => 'title',
			'order'             => 'ASC',
			'paged'             => $current,
			'meta_query'        => array(
				array(
					'key'   => 'student_status',
					'value' => $status,
					)
				),
		);

		// The Query
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) : ?>
			<section class="student-archive-wrapper">
			<?php while ( $the_query->have_posts() ) : ?>
				<?php $the_query->the_post(); ?>
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
					)
				);
			?>
			</div>

		<?php 
		endif;
	}

	/** 
	 * Widget Backend.
	 */
	public function form( $instance ) {

		if ( isset( $instance['posts_per_page'] ) ) {

			$posts_per_page = $instance['posts_per_page'];

		} else {

			$posts_per_page = '4';

		}

		if ( isset( $instance['status'] ) ) {

			$status = $instance['status'];
	
		} else {
	
			$status = 'active';
	
		}
	// Widget admin form.
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Students per page:</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />

	<label for="<?php echo $this->get_field_id( 'status' ); ?>">Which students to show:</label>
	<select id="<?php echo $this->get_field_id( 'status' ); ?>" name="<?php echo $this->get_field_name( 'status' ); ?>" value="<?php echo esc_attr( $status ); ?>" class="widefat">
		<option value="active" <?php selected($status, 'active', true) ?>>
			Active
		</option>
		<option value="" <?php selected($status, '', true) ?>>
			Inactive
		</option>
	</select>
	
	</p>

	<?php 
	}
		
	/**
	 *  Updating widget replacing old instances with new.
	 */
	 public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
		$instance['status'] = ( ! empty( $new_instance['status'] ) ) ? strip_tags( $new_instance['status'] ) : '';

		return $instance;

	}
	
// Class display_students_widget ends here.
} 
	
	
// Register and load the widget.
function st_load_widget() {

	register_widget( 'display_students_widget' );

}

add_action( 'widgets_init', 'st_load_widget' );
