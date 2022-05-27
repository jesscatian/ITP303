<!-- Edit a DVD -->

<?php
	$isUpdated = false;

	// Check title set
	if ( !isset($_POST["title"]) || empty($_POST["title"]) ) {
		$error = "Please fill out all required fields.";
	} else {
		// Import our credentials
		require "config/config.php";

		// DB connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		// Optional release date set
		if( isset($_POST["release_date"]) && !empty($_POST["release_date"])) {
			$release_date = $_POST["release_date"];
		}
		else {
			$release_date = null;
		}

		// Optional label set
		if( isset($_POST["label"]) && !empty($_POST["label"])) {
			$label = $_POST["label"];
		}
		else {
			$label = null;
		}

		// Optional sound set
		if( isset($_POST["sound"]) && !empty($_POST["sound"])) {
			$sound = $_POST["sound"];
		}
		else {
			$sound = null;
		}

		// Optional genre set
		if( isset($_POST["genre"]) && !empty($_POST["genre"])) {
			$genre = $_POST["genre"];
		}
		else {
			$genre = null;
		}

		// Optional ratng set
		if( isset($_POST["rating"]) && !empty($_POST["rating"])) {
			$rating = $_POST["rating"];
		}
		else {
			$rating = null;
		}

		// Optional format set
		if( isset($_POST["format"]) && !empty($_POST["format"])) {
			$format = $_POST["format"];
		}
		else {
			$format = null;
		}

		// Optional award set
		if( isset($_POST["award"]) && !empty($_POST["award"])) {
			$award = $_POST["award"];
		}
		else {
			$award = null;
		}

		// SQL statement
		$statement = $mysqli->prepare("
		update dvd_titles set
		title = ?, release_date = ?, 
		award = ?, 
		label_id = ?, 
		sound_id = ?, 
		genre_id = ?, 
		rating_id = ?, 
		format_id = ? 
		where dvd_title_id = ?
		");

		// Query SQL statement
		$statement->bind_param("sssiiiiii", $_POST["title"], $release_date, $award, $label, $sound, $genre, $rating, $format, $_POST["dvd_title_id"]);
		$executed = $statement->execute();
		if(!$executed) {
			echo $mysqli->error;
		}
		if($statement->affected_rows == 1) {
			$isUpdated = true;
		}

		// Close DB Connecton
		$statement->close();
		$mysqli->close();
	}

	
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<div class="text-danger font-italic">Display Error Messages Here</div>

				<div class="text-success"><span class="font-italic">Title</span> was successfully edited.</div>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?dvd_title_id=<?php echo $_POST["dvd_title_id"] ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>