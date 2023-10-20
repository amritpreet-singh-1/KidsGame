<?php
session_start();
include('config.php');
include('function.php');
menuBar();

// Connect to the database
$servername = DB_SERVER;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname = DB_NAME;

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT p.id, p.fName, p.lName, s.result, s.livesUsed, s.scoreTime
        FROM player p, score s 
        WHERE p.registrationOrder = s.registrationOrder";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/historyPage.css">
    <title>Scoreboard</title>
</head>

<body>
    <p style="text-align:center">Click here to go <a href="welcome.php">HOME</a></p>	
    <?php
 
    if ($result->num_rows > 0) {
        // Display data in a table
        echo "<div style='text-align:center;'>";
        echo "<table style='border:1px solid black;text-align:center; margin-left:auto;margin-right:auto;'>";
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Result</th><th>Number of Lives</th><th>Date/Time</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["fName"] . "</td><td>" . $row["lName"] . "</td><td>" . $row["result"] . "</td><td>" . $row["livesUsed"] . "</td><td>" . $row["scoreTime"] . "</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<p>No results found.</p>";
    }      
    ?>
</body>

</html>
