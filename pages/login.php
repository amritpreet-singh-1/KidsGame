<?php
// Start the session
session_start();
include('config.php');

// Check if the user is already logged in
if (isset($_SESSION["userName"])) {
	header("Location: welcome.php");
	exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Connect to the database
	$servername = DB_SERVER;
	$username = DB_USERNAME;
	$password = DB_PASSWORD;
	$dbname = DB_NAME;

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Get the login form data
	$userName = $_POST["userName"];
	$password = $_POST["password"];

	// Retrieve the password hash from the authenticator table
  $sql = "SELECT authenticator.passCode, authenticator.registrationOrder FROM authenticator
	INNER JOIN player ON authenticator.registrationOrder = player.registrationOrder
	WHERE player.userName = '$userName'";

	// $sql = "SELECT passCode, registrationOrder FROM authenticator
	// 	INNER JOIN player ON authenticator.registrationOrder = player.registrationOrder
	// 	WHERE player.userName = '$userName'";
  
	$result = mysqli_query($conn, $sql);
  if (!$result) {
    die("Query failed: " . mysqli_error($conn));
  }
//	echo "$result";
  if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$passCode = $row["passCode"];
		$registrationOrder = $row["registrationOrder"];

		// Verify the password
		if (password_verify($password, $passCode)) {
			// Set session variables
			$_SESSION["userName"] = $userName;
			$_SESSION["registrationOrder"] = $registrationOrder;
			header("Location: level3.php");
		

			// Redirect to the welcome page
			header("Location: welcome.php");
			exit();
		} else {
			// Invalid password
			$error = "Invalid username or password.";
		}
	} else {
		// User not found
		$error = "Invalid username or password.";
	}

	mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../css/finalStyle.css">
</head>
<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<h2>Login Form</h2>
		<?php if (isset($error)) { ?>
			<p><?php echo $error; ?></p>
		<?php } ?>
		<label>Username:</label>
		<input type="text" name="userName" required>
		<label>Password:</label>
		<input type="password" name="password" required>
		<input type="submit" value="Login">
		<p><a href="modifiedPassword.php">Forgot Password? </a></p>
		<p>don't have an account <a href="register.php">Register here </a></p>
	</form>
</body>
</html>

