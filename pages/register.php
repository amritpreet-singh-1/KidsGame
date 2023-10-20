<?php
// Connect to the database
include('config.php');
$servername = DB_SERVER;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname = DB_NAME;
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Get the registration form data
	$fName = $_POST["fName"];
	$lName = $_POST["lName"];
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$confirmPassword = $_POST["ConfirmPassword"];
	$isValid = false;

	// Insert the data into the player table
	if ($password == $confirmPassword) {
		$registrationTime = date('Y-m-d H:i:s');
		$sql = "INSERT INTO player (fName, lName, userName, registrationTime)
	VALUES ('$fName', '$lName', '$userName', '$registrationTime')";
		$isValid = true;

		if (mysqli_query($conn, $sql)) {
			$registrationOrder = mysqli_insert_id($conn);

			// Insert the password into the authenticator table
			$passCode = password_hash($password, PASSWORD_DEFAULT);

			$sql = "INSERT INTO authenticator (passCode, registrationOrder)
		VALUES ('$passCode', '$registrationOrder')";
			mysqli_query($conn, $sql);
			header("Location: login.php");
			echo "Registration successful.";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	} else {
		$isValid = false;
		echo "<span>Registration failed.</span>";
	}

	mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="../css/finalStyle.css">

</head>

<body>
	<form method="post" action="register.php">
		<h2>Registration Form</h2>
		<label>First Name:</label>
		<input type="text" name="fName" required>
		<label>Last Name:</label>
		<input type="text" name="lName" required>
		<label>Username:</label>
		<input type="text" name="userName" required>
		<label>Password:</label>
		<input type="password" name="password" required>
		<label>Confirm Password:</label>
		<input type="password" name="ConfirmPassword" required>
		<input type="submit" value="Register">
		<p>Already have an account? <a href="login.php">Login</a></p>
	</form>
</body>

</html>