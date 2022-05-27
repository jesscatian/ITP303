<!-- Add a new DVD -->

<?php
$isInserted = false;

// Check title is set
if (!isset($_POST["title"]) || empty($_POST["title"])) {
		$error = "Please fill out all required fields";
} 
else {
	// Import our credentials
	require "config/config.php";

	// DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	// Check optional date is set
	if(isset($_POST["release_date"]) && !empty($_POST["release_date"])) {
		$release_date = $_POST["release_date"];
	}
	else {
		$release_date = null;
	}

	// Check optional date is set
	if(isset($_POST["label"]) && !empty($_POST["label"])) {
		$composer = "'" . $_POST["label"] . "'";
	}
	else {
		$label = null;
	}

	// Check optional sound is set
	if(isset($_POST["sound"]) && !empty($_POST["sound"])) {
		$sound = $_POST["sound"];
	}
	else {
		$sound = null;
	}

	// Check optional genre is set
	if(isset($_POST["genre"]) && !empty($_POST["genre"])) {
		$genre = $_POST["genre"];
	}
	else {
		$genre = null;
	}

	// Check optional rating is set
	if( isset($_POST["rating"]) && !empty($_POST["rating"])) {
		$rating = $_POST["rating"];
	}
	else {
		$rating = null;
	}

	// Check optional format is set
	if( isset($_POST["format"]) && !empty($_POST["format"])) {
		$format = $_POST["format"];
	}
	else {
		$format = null;
	}

	// Check optional award is set
	if( isset($_POST["award"]) && !empty($_POST["award"])) {
		$award = $_POST["award"];
	}
	else {
		$award = null;
	}

	// SQL statement
	$statement = $mysqli->prepare("
	insert into dvd_titles(title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
	values(?, ?, ?, ?, ?, ?, ?, ?)");
	$statement->bind_param("sssiiiii", $_POST["title"], $release_date, $award, $label, $sound, $genre, $rating, $format);

	// Query SQL statement
	$executed = $statement->execute();
	if(!$executed) {
		echo $mysqli->error;
	}
	if($statement->affected_rows == 1) {
		$isInserted = true;
	}

	// Close DB connection
	$statement->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				

				<?php if(isset($error) && !empty($error)) :?>
					<div class="text-danger font-italic"><?php echo $error?></div>
				<?php endif; ?>
				<?php if($isInserted) :?>
					<div class="text-success"><?php echo $_POST["title"]?><span class="font-italic"></span> was successfully added.</div>
				<?php endif;?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>