<?php
// Must call this function at the top of the file to use sessions in this file
//session_start();
require '../config/config.php';
	// User will use GET request to simply visit the page. If user is trying to login but submtiting username and password, it will make a POST request

// Giant if statement here. If user is NOT logged in, do the usual things. Else, redirect them out of this page.

if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"] )  {

	// Check if username & password were submitted via the POST method. If so, the user is attempting to login.
	if ( isset($_POST['username']) && isset($_POST['password']) ) {

		// Check if user has entered in both username AND password
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			// Connect to the DB and check if user typed in the correct credentials
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			// How to check if user typed in correct credentials?
			// 1. Get this user's record from the DB
			// 2. Compare the passwords to check password is correct

			$passwordInput = hash("sha256", $_POST["password"]);

			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			echo "<hr>" . $sql . "<hr>";
			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}
			// If we ONE result back, it means the username/pw combo is correct!
			if($results->num_rows == 1) {
				// Log the user in. Save their info
				$_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"];

				// Redirect the user to the home page
				// header() makes a GET request
				// pass in the path that we want to redirect the user to.
				// header("Location: https://www.google.com");
				header("Location: ../song-db/index.php");
			
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
else {
	// Redirect the user out of this page
	header("Location: ../song-db/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<?php include '../song-db/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Login</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<!-- When login form is submitted, we are submitting it to itself via the POST method -->
		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Create an account</a>
			</div>
		</div> <!-- .row -->

	</div> <!-- .container -->
</body>
</html>