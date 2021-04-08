<?php
/**
 * Adds a admin menu
 */
function db_add_menu() {
    add_menu_page( 'Student Database', 'Student Database', 'administrator', 'db-admin', 'db_page' );
}

/**
 * Renders Admin Page
 */
function db_page() {

	global $wpdb;
	
	$table_name = $wpdb->prefix . 'students';

	// DB Connection Info
	$dbhost = DB_HOST;
	$dbuser = DB_USER;
	$dbpass = DB_PASSWORD;
	$dbname = DB_NAME;
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	$database_error = '';

	// If There's 
	if ( $conn->connect_error ) {

		$databaseError = $conn->connect_error;

	} else {

		$request_error = false;

		if ( ! empty( $_POST ) ) {

			if ( ! empty ( $_POST['name'] ) ) {
				$name =  sanitize_text_field( $_POST['name'] );
			} else $request_error = true;

			if ( isset( $_POST['country'] ) ) {
				$country = sanitize_text_field( $_POST['country'] );
			} else $country = "";

			if ( isset( $_POST['city'] ) ) {
				$city =  sanitize_text_field( $_POST['city'] );
			} else $city = "";

			if ( isset( $_POST['address'] ) ) {
				$address = sanitize_text_field( $_POST['address'] );
			} else $address = "";

			if ( ! empty( $_POST['grade'] ) ) {
				if ( is_numeric( $_POST['grade'] ) ) {
					$grade = sanitize_text_field( $_POST['grade'] );
				} else $request_error = true;
			} else $grade = 0;

			if ( ! $request_error ) {
				$result = $conn -> query( "INSERT INTO $table_name (name, country, city, address, grade) VALUES ('$name','$country','$city','$address','$grade')");
			}

		} 
		$result = $conn -> query( 'SELECT * FROM ' . $table_name );
		mysqli_close( $conn );
	}

	?>

    <div class="wrap">
		<div style="display:flex; justify-content: space-between;">
			<h1 style="margin-bottom: 50px;"><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<span>DB Connection Status: 
			<?php
				if( $database_error ) {
					echo '<span style="color: red;">Offline!</span>';
				} else {
					echo '<span style="color: green;">Online!</span>';
				}
			?>
			</span>
		</div>

		<form method="post" style="display: flex; width: 100%;">
			<div style="display: flex; flex-direction:column;">
				<label for="name">Student Name</label>
				<input name="name" id="name" type="text">
			</div>
			<div style="display: flex; flex-direction:column;">
				<label for="country">Country</label>
				<input name="country" id="country" type="text">
			</div>
			<div style="display: flex; flex-direction:column;">
				<label for="city">City</label>
				<input name="city" id="city" type="text">
			</div>
			<div style="display: flex; flex-direction:column;">
				<label for="address">Address</label>
				<input name="address" id="address" type="text">
			</div>
			<div style="display: flex; flex-direction:column;">
				<label for="grade">Grade</label>
				<input name="grade" id="grade" type="number">
			</div>

			<button id="submit">Add to DB</button>
		</form>

		<table style="width:100%; margin-top: 50px;">
			<tr style="background: white; font-size: 16px; line-height: 2rem;">
				<th>ID</th>
				<th>Name</th>
				<th>Country</th>
				<th>City</th>
				<th>Address</th>
				<th>Grade</th>
			</tr>
			<?php if ($result->num_rows > 0) : ?>
				<?php while($row = $result->fetch_assoc()) : ?>
					<tr style="background: white; font-size: 16px; line-height: 2rem;">
						<th><?php echo sanitize_text_field( ( $row['id'] ) ); 		   ?></th>
						<th><?php echo sanitize_text_field( $row['name'] ) 		?? ''; ?></th>
						<th><?php echo sanitize_text_field( $row['country'] ) 	?? ''; ?></th>
						<th><?php echo sanitize_text_field( $row['city'] ) 		?? ''; ?></th>
						<th><?php echo sanitize_text_field( $row['address'] ) 	?? ''; ?></th>
						<th><?php echo sanitize_text_field( $row['grade'] )   	?? ''; ?></th>
					</tr>
				<?php endwhile ?>
			<?php endif ?>
		</table>
    </div>
	<?php
}
add_action( 'admin_menu', 'db_add_menu' );