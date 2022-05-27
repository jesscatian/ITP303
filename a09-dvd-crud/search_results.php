<!-- For this assignment, you will create search form and search results page for DVD database. All data and results should be dynamic and come directly from the database. -->

<?php
	// Import our credentials
	require "config/config.php";

	// DB connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');

	// Base SQL statement
	$sql = "
	select dvd_title_id, 
	dvd_titles.title as title, 
	genres.genre as genre, 
	ratings.rating as rating, 
	labels.label as label,
	formats.format as format,
	sounds.sound as sound, 
	dvd_titles.award as award,
	dvd_titles.release_date as release_date
	from dvd_titles 
	join genres
		on dvd_titles.genre_id = genres.genre_id
	join ratings
		on dvd_titles.rating_id = ratings.rating_id
	join labels
		on dvd_titles.label_id = labels.label_id
	join sounds
		on dvd_titles.sound_id = sounds.sound_id
	join formats
		on dvd_titles.format_id = formats.format_id
	where 1=1
	";

	// Check what names attached to $_GET
	if(isset($_GET["title"]) && !empty($_GET["title"])) {
		$sql = $sql . " and dvd_titles.title like '%" .$_GET["title"] . "%'";
	}

	if(isset($_GET["genre"]) && !empty($_GET["genre"])) {
		$sql = $sql . " and dvd_titles.genre_id = " . $_GET["genre"];
	}

	if(isset($_GET["rating"]) && !empty($_GET["rating"])) {
		$sql = $sql . " and ratings.rating_id = " . $_GET["rating"];
	}

	if(isset($_GET["label"]) && !empty($_GET["label"])) {
		$sql = $sql . " and labels.label_id = " . $_GET["label"];
	}

	if(isset($_GET["format"]) && !empty($_GET["format"])) {
		$sql = $sql . " and formats.format_id = " . $_GET["format"];
	}

	if(isset($_GET["sound"]) && !empty($_GET["sound"])) {
		$sql = $sql . " and sounds.sound_id = " . $_GET["sound"];
	}

	if($_GET["award"] == "yes") {
		$sql = $sql . " and dvd_titles.award is not null";
	}

	if($_GET["award"] == "no") {
		$sql = $sql . " and dvd_titles.award is null";
	}

	if($_GET["release_date_from"] != "") {
		$sql = $sql . " and dvd_titles.release_date >" . $_GET["release_date_from"] ;
	}

	if($_GET["release_date_to"] != "") {
		$sql = $sql . " and dvd_titles.release_date <" . $_GET["release_date_to"] ;
	}

	// Query SQL statement
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	// Close DB connection
	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">
				<!-- Show # of results -->
				Showing <?php echo $results->num_rows; ?>  result(s).
			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>
						<!-- Display results -->
						<?php while($row = $results->fetch_assoc()):?>
							<tr>
								<td>
									<a onclick="return confirm('Are you sure you want to delete this dvd?');" href="delete.php?dvd_title_id=<?php echo $row["dvd_title_id"]; ?>&title=<?php echo $row["title"]?>" class="btn btn-outline-danger delete-btn">
										Delete
									</a>
								</td>
								<td>
									<a href="details.php?dvd_title_id=<?php echo $row["dvd_title_id"];?>">
										<?php echo $row["title"]; ?> 
									</a>
								</td>
								<td><?php echo $row["release_date"]; ?></td>
								<td><?php echo $row["genre"]; ?></td>
								<td><?php echo $row["rating"]; ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>