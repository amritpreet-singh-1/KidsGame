<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the input values from the form
	$userName = $_POST["userName"];
	$newPassword = $_POST["newPassword"];
	$confirmPassword = $_POST["confirmPassword"];

	// Connect to the database
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	if ($newPassword == $confirmPassword) {
		// Update the user's password hash in the authenticator table
		$passCode = password_hash($newPassword, PASSWORD_DEFAULT);
		$sql = "UPDATE authenticator SET passCode = '$passCode' WHERE registrationOrder = 
		(SELECT registrationOrder FROM player WHERE userName = '$userName')";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			die("Query failed: " . mysqli_error($conn));
		}
	// Redirect the user to the login page
	header("Location: login.php");
		exit();
	}

}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Password Modification</title>
	<link rel="stylesheet" type="text/css" href="../css/finalStyle.css">
</head>

<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<h2>Password Modification</h2>
		<label>Username:</label>
		<input type="text" name="userName" required>
		<label>New Password:</label>
		<input type="password" name="newPassword" required>
		<label>Confirm Password:</label>
		<input type="password" name="confirmPassword" required>
		<input type="submit" value="Update Password">
	</form>
</body>

</html>