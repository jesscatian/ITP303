<!-- For this lab, you will create the detail pages using your DVD database. -->

<?php
	// Check that dvd_title_id is given
	if(!isset($_GET["dvd_title_id"]) || empty($_GET["dvd_title_id"])) {
		$error = "Invalid DVD Title ID";
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
		$mysqli->set_charset("utf-8");

		// SQL statement
		$sql = "
		select title, 
		release_date, 
		genres.genre as genre, 
		labels.label as label, 
		ratings.rating as rating, 
		sounds.sound as sound, 
		formats.format as format,
		award
		FROM dvd_titles
		left join genres
			on dvd_titles.genre_id = genres.genre_id
		left join labels
			on dvd_titles.label_id = labels.label_id
		left join ratings
			on dvd_titles.rating_id = ratings.rating_id    
		left join sounds
			on dvd_titles.sound_id = sounds.sound_id    
		left join formats
			on dvd_titles.format_id = formats.format_id  
		where dvd_title_id =" . $_GET["dvd_title_id"] . "
		";

		// Query SQL statement
		$results = $mysqli->query($sql);
		if(!$results) {
			echo $mysqli->error;
			exit();
		}

		// Returns only one row
		$row = $results->fetch_assoc();

		// Close DB connection
		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<!-- Show detail results -->
				<?php if(isset($error) && !empty($error)) : ?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php else: ?>
					<table class="table table-responsive">
						<tr>
							<th class="text-right">Title:</th>
							<td><?php echo $row["title"];?></td>
						</tr>
						<tr>
							<th class="text-right">Release Date:</th>
							<td><?php echo $row["release_date"];?></td>
						</tr>
						<tr>
							<th class="text-right">Genre:</th>
							<td><?php echo $row["genre"];?></td>
						</tr>
						<tr>
							<th class="text-right">Label:</th>
							<td><?php echo $row["label"];?></td>
						</tr>
						<tr>
							<th class="text-right">Rating:</th>
							<td><?php echo $row["rating"];?></td>
						</tr>
						<tr>
							<th class="text-right">Sound:</th>
							<td><?php echo $row["sound"];?></td>
						</tr>
						<tr>
							<th class="text-right">Format:</th>
							<td><?php echo $row["format"];?></td>
						</tr>
						<tr>
							<th class="text-right">Award:</th>
							<td><?php echo $row["award"];?></td>
						</tr>
					</table>
				<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
				<a href="edit_form.php?dvd_title_id=<?php echo $_GET["dvd_title_id"]; ?>" role="button" class="btn btn-warning">Edit this DVD</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>