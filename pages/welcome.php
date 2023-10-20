<?php
// Start the session
session_start();
include('config.php');
include('function.php');

// Check if the user is not logged in
if (!isset($_SESSION["userName"])) {
	menuBar();
	echo '<h1 S>You need to login first.</h1>';

} else {
	menuBar();

	// Connect to the database
	$servername = DB_SERVER;
	$username = DB_USERNAME;
	$password = DB_PASSWORD;
	$dbname = DB_NAME;

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Get the user's data from the player table
	$registrationOrder = $_SESSION["registrationOrder"];
	$sql = "SELECT fName, lName FROM player WHERE registrationOrder = '$registrationOrder'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$fName = $row["fName"];
	$lName = $row["lName"];

	$_SESSION["level"] = 1;
	updateQustion(0);


	//initialise lives
	$_SESSION["lives"] = 6;
	$_SESSION["status"] = "incomplete";

	mysqli_close($conn);
}
?>
<?php
if(isset($_SESSION["userName"])){
echo <<<_END
	<!DOCTYPE html>
<html>

<head>
	<title>Welcome</title>
	<!-- <link rel="stylesheet" type="text/css" href="../css/finalStyle.css"> -->
	<style>
	h2, p {
		text-align: center;		
		}		
		body {
		  margin: auto;
		  font-family: 'Lexend Deca', sans-serif; 
		  color: #2E475D;    
		}
		</style>
</head>

<body>
	<h2 >Welcome,
	$fName $lName !
	</h2>
	<p>You are now logged in.</p>
	<p>to play game <a href="level1.php">Click here</a></p>
	<br />
</body>

</html>
_END;
}
		// <?php echo "$fName $lName";

?>