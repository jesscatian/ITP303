<!-- Edit a DVD -->

<?php	
	// Check id set
	if( !isset($_GET["dvd_title_id"]) || empty($_GET["dvd_title_id"]) ) {
		echo "Invalid DVD id";
		exit();
	}

	// Import our credentials
	require "config/config.php";

	// DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	$sql = "select * from labels";
	$results1 = $mysqli->query($sql);
	if(!$results1) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from sounds";
	$results2 = $mysqli->query($sql);
	if(!$results2) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from genres";
	$results3 = $mysqli->query($sql);
	if(!$results3) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from ratings";
	$results4 = $mysqli->query($sql);
	if(!$results4) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from formats";
	$results5 = $mysqli->query($sql);
	if(!$results5) {
		echo $mysqli->error;
		exit();
	}

	// Get details of this track
	$sql_track = "
	SELECT * 
	FROM dvd_titles
	WHERE dvd_title_id =" . $_GET["dvd_title_id"] . "
	";

	// Query the db!
	$results_track = $mysqli->query($sql_track);
	if(!$results_track) {
		echo $mysqli->error;
		exit();
	}

	// Only getting results back
	$row_track = $results_track->fetch_assoc();

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_GET['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container"> 
			<!-- <div class="col-12 text-danger">
				Display Error Messages Here.
			</div> -->
			<form action="edit_confirmation.php" method="POST">
				<div class="form-group row">
					<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $row_track["title"] ?>">
					</div>
				</div> <!-- .form-group -->
				<div class="form-group row">
					<label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
					<div class="col-sm-9">
						<input type="date" class="form-control" id="release-date-id" name="release_date">
					</div>
				</div> <!-- .form-group -->
				<div class="form-group row">
					<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
					<div class="col-sm-9">
						<select name="label" id="label-id" class="form-control">
							<option value="" selected>-- Select One --</option>

							<?php
							while($row = $results1->fetch_assoc()) {
								if ($row["label_id"] == $row_track["label_id"]){
									echo "<option selected value='" . $row["label_id"] . "'>" . $row["label"] . "</option>";
								}else {

								
								echo "<option value='" . $row["label_id"] . "'>" . $row["label"] . "</option>";
								}
							}
							$results1->data_seek(0);
						?>
						</select>
					</div>
				</div> <!-- .form-group -->
				<div class="form-group row">
					<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
					<div class="col-sm-9">
						<select name="sound" id="sound-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php
							while($row = $results2->fetch_assoc()) {
								if ($row["sound_id"] == $row_track["sound_id"]){
									echo "<option selected value='" . $row["sound_id"] . "'>" . $row["sound"] . "</option>";
								}else {
								echo "<option value='" . $row["sound_id"] . "'>" . $row["sound"] . "</option>";
								}
							}
							$results2->data_seek(0);
						?>
						</select>
					</div>
				</div> <!-- .form-group -->
				<div class="form-group row">
					<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
					<div class="col-sm-9">
						<select name="genre" id="genre-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php
							while($row = $results3->fetch_assoc()) {
								if ($row["genre_id"] == $row_track["genre_id"]){
									echo "<option selected value='" . $row["genre_id"] . "'>" . $row["genre"] . "</option>";
								}else {

								
								echo "<option value='" . $row["genre_id"] . "'>" . $row["genre"] . "</option>";
								}
							}
							$results3->data_seek(0);
						?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
					<div class="col-sm-9">
						<select name="rating" id="rating-id" class="form-control">
							<option value="" selected>-- Select One --</option>

							<?php
							while($row = $results4->fetch_assoc()) {
								if ($row["rating_id"] == $row_track["rating_id"]){
									echo "<option selected value='" . $row["rating_id"] . "'>" . $row["rating"] . "</option>";
								}else {

								
								echo "<option value='" . $row["rating_id"] . "'>" . $row["rating"] . "</option>";
								}
							}
							$results4->data_seek(0);
						?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
					<div class="col-sm-9">
						<select name="format" id="format-id" class="form-control">
							<option value="" selected>-- Select One --</option>
							<?php
							while($row = $results5->fetch_assoc()) {
								if($row["format_id"] == $row_track["format_id"]){
									echo "<option selected value='" . $row["format_id"] . "'>" . $row["format"] . "</option>";
								}else{
									echo "<option value='" . $row["format_id"] . "'>" . $row["format"] . "</option>";
								}
								
							}
							$results5->data_seek(0);
						?>
						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
					<div class="col-sm-9">
						<textarea name="award" id="award-id" class="form-control"></textarea>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->


				<!-- Need to also send the primary key of this track -->
				<input type="hidden" name="dvd_title_id" value="<?php echo $_GET["dvd_title_id"]; ?>">
			</form>

	</div> <!-- .container -->
</body>
</html>