<?php
	$host = "303.itpwebdev.com";
	$user = "jessiehe_db_user";
	$password = "itp303password";
	$db = "jessiehe_dvd_db";

	$mysqli = new mysqli($host, $user, $password, $db);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql = "select * from genres";
	$results1 = $mysqli->query($sql);
	if(!$results1) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from ratings";
	$results2 = $mysqli->query($sql);
	if(!$results2) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from labels";
	$results3 = $mysqli->query($sql);
	if(!$results3) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from formats";
	$results4 = $mysqli->query($sql);
	if(!$results4) {
		echo $mysqli->error;
		exit();
	}

	$sql = "select * from sounds";
	$results5 = $mysqli->query($sql);
	if(!$results5) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Form</title>
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
		<li class="breadcrumb-item active">Search</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">DVD Search Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<form action="search_results.php" method="GET">
			<div class="form-group row">
				<label for="title-id" class="col-sm-3 col-form-label text-sm-right">DVD Title:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="title-id" name="title">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">
					<select name="genre" id="genre-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Genre dropdown options here -->
						<?php
							while($row = $results1->fetch_assoc()) {
								echo "<option value='" . $row["genre_id"] . "'>" . $row["genre"] . "</option>";
							}
							$results1->data_seek(0);
						?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
				<div class="col-sm-9">
					<select name="rating" id="rating-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Rating dropdown options here -->
						<?php
							while($row = $results2->fetch_assoc()) {
								echo "<option value='" . $row["rating_id"] . "'>" . $row["rating"] . "</option>";
							}
							$results2->data_seek(0);
						?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
				<div class="col-sm-9">
					<select name="label" id="label-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Label dropdown options here -->
						<?php
							while($row = $results3->fetch_assoc()) {
								echo "<option value='" . $row["label_id"] . "'>" . $row["label"] . "</option>";
							}
							$results3->data_seek(0);
						?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
				<div class="col-sm-9">
					<select name="format" id="format-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Format dropdown options here -->
						<?php
							while($row = $results4->fetch_assoc()) {
								echo "<option value='" . $row["format_id"] . "'>" . $row["format"] . "</option>";
							}
							$results4->data_seek(0);
						?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
				<div class="col-sm-9">
					<select name="sound" id="sound-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Sound dropdown options here -->
						<?php
							while($row = $results5->fetch_assoc()) {
								echo "<option value='" . $row["sound_id"] . "'>" . $row["sound"] . "</option>";
							}
							$results5->data_seek(0);
						?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
				<div class="col-sm-9">
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox3" value="any" checked>Any
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox1" value="yes">Yes
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox2" value="no">No
						</label>
					</div>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
				<div class="col-sm-9">
					<div class="row">
						<div class="col">
							<label class="form-check-label">
								From: 
								<input type="date" class="form-control mt-2" name="release_date_from">
							</label>
						</div> <!-- .col -->
						<div class="col">
							<label class="form-check-label">
								to: 
								<input type="date" class="form-control mt-2" name="release_date_to">
							</label>
						</div> <!-- .col -->
					</div> <!-- .row -->
				</div> <!-- .col -->
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>