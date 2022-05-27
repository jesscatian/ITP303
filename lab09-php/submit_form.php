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
	$mysqli->set_charset("utf8");

	$sql = "
	select * from dvd_titles.title as title, dvd_titles.release_date as release_date, 
	genres.genre as genre, ratings.rating as rating
	from dvd_titles 
	join genres
	on dvd_titles.genre_id = genres.genre_id
	join ratings
	on dvd_titles.rating_id = ratings.rating_id
	where 1=1
	";

	$results= $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	echo $results

	$mysqli->close();

?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-5 mb-3">Order Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	
	<div class="container">

		<div class="row mt-3">
			<div>
				<!-- Change this to date/time that this was submitted. -->
				<?php
					date_default_timezone_set("America/Los_Angeles");
					echo "This form was submitted on " . date("l, F d, o") . " at " . date("h:i:s A")
 				?>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-4 text-right">Full Name:</div>
			<div class="col-8">
				<!-- PHP Output Here -->
				<?php
					if(isset($_POST["fname"]) 
					&& !empty($_POST["fname"])
					&& isset($_POST["lname"]) 
					&& !empty($_POST["lname"])) {
						echo $_POST["fname"] . " " . $_POST["lname"];
					} else {
						echo "<div class='text-danger'>Not provided.</div>";
					}
				?>
			</div>
		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-4 text-right">Phone Number Match:</div>
			<div class="col-8">
				<!-- PHP Output Here -->
				<?php
					if(isset($_POST["phone"]) && !empty($_POST["phone"])) {
							if($_POST["phone"] == $_POST["phone-confirm"]){
								echo "<div class='text-success'>Phone numbers match.</div>";
								echo $_POST["phone"];
							} else {
								echo "<div class='text-danger'>Phone numbers do not match.</div>";
							}
					} else {
						echo "<div class='text-danger'>Not provided.</div>";
					}
				?>
			</div>
		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-4 text-right">Order:</div>
			<div class="col-8">
				<!-- PHP Output Here -->
				<?php
					if(isset($_POST["order"]) && !empty($_POST["order"])) {
							echo $_POST["order"];
					} else {
						echo "<div class='text-danger'>Not provided.</div>";
					}
				?>
			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-4 text-right">Size:</div>
			<div class="col-8">
				<!-- PHP Output Here -->
				<?php
					if(isset($_POST["size"]) && !empty($_POST["size"])) {
							echo $_POST["size"];
					} else {
						echo "<div class='text-danger'>Not provided.</div>";
					}
				?>
			</div>
		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-4 text-right">Flavor shot(s): </div>
			<div class="col-8">
				<!-- PHP Output Here -->
				<?php
					if(isset($_POST["flavor"]) && !empty($_POST["flavor"])) {
						echo $_POST["flavor"];
				} else {
					echo "";
				}
				?>
				
			</div>
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<a href="form.php" role="button" class="btn btn-primary">Back to Form</a>
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>