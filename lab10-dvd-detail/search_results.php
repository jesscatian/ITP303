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
	select dvd_title_id, dvd_titles.title as title, dvd_titles.release_date as release_date, 
	dvd_titles.award as award, 
	genres.genre as genre, ratings.rating as rating, labels.label as label,
	sounds.sound as sound, formats.format as format
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

	if( isset($_GET["title"]) && !empty($_GET["title"]) ) {
		$sql = $sql . " AND dvd_titles.title LIKE '%" .$_GET["title"] . "%'";
	}

	if( isset($_GET["genre"]) && !empty($_GET["genre"]) ) {
		$sql = $sql . " AND dvd_titles.genre_id = " . $_GET["genre"];
	}

	if( isset($_GET["rating"]) && !empty($_GET["rating"]) ) {
		$sql = $sql . " AND ratings.rating_id = " . $_GET["rating"];
	}

	if( isset($_GET["label"]) && !empty($_GET["label"]) ) {
		$sql = $sql . " AND labels.label_id = " . $_GET["label"];
	}

	if( isset($_GET["format"]) && !empty($_GET["format"]) ) {
		$sql = $sql . " AND formats.format_id = " . $_GET["format"];
	}

	if( isset($_GET["sound"]) && !empty($_GET["sound"]) ) {
		$sql = $sql . " AND sounds.sound_id = " . $_GET["sound"];
	}

	if( $_GET["award"] == "yes" ) {
		$sql = $sql . " AND dvd_titles.award is not null";
	}

	if( $_GET["award"] == "no" ) {
		$sql = $sql . " AND dvd_titles.award is null";
	}

	if( $_GET["release_date_from"] != "" ) {
		$sql = $sql . " AND dvd_titles.release_date >" . $_GET["release_date_from"] ;
	}

	if( $_GET["release_date_to"] != "" ) {
		$sql = $sql . " AND dvd_titles.release_date <" . $_GET["release_date_to"] ;
	}

	$results= $mysqli->query($sql);
	if(!$results) {
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
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
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

						<?php while($row = $results->fetch_assoc()):?>
							<tr>
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