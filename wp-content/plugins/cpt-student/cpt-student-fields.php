<?php

function st_add_custom_metabox() {
	
	add_meta_box(
        'st_meta',
        'Student Details',
        'st_meta_callback',
        'student',
        'normal',
        'core',
    );
	
};

add_action( 'add_meta_boxes', 'st_add_custom_metabox' );

function st_meta_callback( $post ) {
	
	wp_nonce_field( basename( __FILE__ ), 'st_student_nonce' );
    $st_stored_meta = get_post_meta( $post->ID );
	
    ?>

<div>
	<!-- Student Status field -->
	<div class="meta-row">
		<div class="meta-th">
			<label for="student-status" class="st-row-title">Activated</label>
		</div>
		<div class="meta-td">
			<input 
			type="checkbox" 
			name="student_status"
			id="student-status"
			value="yes"
			<?php isset( $st_stored_meta['student_status'][0] ) ? checked($st_stored_meta['student_status'][0], 'yes') : '' ?>
			>
		</div>
	</div>
	<!-- student country field -->
	<div class="meta-row">
            <div class="meta-th">
                <label for="student-country" class="st-row-title">Country</label>
            </div>
            <div class="meta-td">
                <input 
                type="text" 
                name="student_country"
                id="student-country" 
                value="<?php if ( ! empty ( $st_stored_meta['student_country'] ) ) echo esc_attr( $st_stored_meta['student_country'][0] ); ?>"
                >
            </div>
        </div>

        <!-- Student City field -->
        <div class="meta-row">
            <div class="meta-th">
                <label for="student-city" class="st-row-title">City</label>
            </div>
            <div class="meta-td">
                <input 
                type="text" 
                name="student_city" 
                id="student-city" 
                value="<?php if ( ! empty ( $st_stored_meta['student_city'] ) ) echo esc_attr( $st_stored_meta['student_city'][0] ); ?>"
                >
            </div>
        </div>

		<!-- Student Address field -->
		<div class="meta-row">
            <div class="meta-th">
                <label for="student-address" class="st-row-title">Address</label>
            </div>
            <div class="meta-td">
                <input 
                type="text" 
                name="student_address" 
                id="student-address" 
                value="<?php if ( ! empty ( $st_stored_meta['student_address'] ) ) echo esc_attr( $st_stored_meta['student_address'][0] ); ?>"
                >
            </div>
        </div>

		<!-- Student Grade field -->
		<div class="meta-row">
            <div class="meta-th">
                <label for="student-grade" class="st-row-title">Grade</label>
            </div>
            <div class="meta-td">
                <input 
                type="text" 
                name="student_grade" 
                id="student-grade" 
                value="<?php if ( ! empty ( $st_stored_meta['student_grade'] ) ) echo esc_attr( $st_stored_meta['student_grade'][0] ); ?>"
                >
            </div>
        </div>

    </div>

    <?php
}

function st_meta_save( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'st_student_nonce' ] ) && wp_verify_nonce( $_POST[ 'st_student_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if ( isset( $_POST[ 'student_country' ] ) ) {
        update_post_meta( $post_id, 'student_status', sanitize_text_field( $_POST['student_status'] ) );
    }
    if ( isset( $_POST[ 'student_country' ] ) ) {
        update_post_meta( $post_id, 'student_country', sanitize_text_field( $_POST['student_country'] ) );
    }

    if ( isset( $_POST[ 'student_city' ] ) ) {
        update_post_meta( $post_id, 'student_city', sanitize_text_field( $_POST['student_city'] ) );
    }

    if ( isset( $_POST[ 'student_address' ] ) ) {
        update_post_meta( $post_id, 'student_address', sanitize_text_field( $_POST['student_address'] ) );
    }
	if ( isset( $_POST[ 'student_grade' ] ) ) {
        update_post_meta( $post_id, 'student_grade', sanitize_text_field( $_POST['student_grade'] ) );
    }
}

add_action( 'save_post', 'st_meta_save' );