<?php
session_start();
include('function.php');

menuBar();
$numbers = $_SESSION["number"];
echo "<h1 style='padding:20px 0px 0px;color:blue'><strong>" . (implode(" ", $numbers)) . "</strong></h1>";
sort($numbers);
$min = $numbers[0];
$max = end($numbers);

if (isset($_POST['submit'])) {

	// Get the user's answer
	$num1 = $_POST['num1'];
	$num2 = $_POST['num2'];
	// Validate the user's answer

	if ($num1 == $min && $num2 == $max) {
		// The user's answer is correct
		echo "Congratulations, you have won this level!";
		// Display a button to go to the next level
		echo '<a href="history.php">see the scoreboard</a>';
		$_SESSION["status"] = 'success';
		$_SESSION["level"] = 6;
		updateQustion(5);

		storeGameStatus();


	} else {
		// The user's answer is incorrect
		echo "Sorry, your answer is incorrect. " . $num1 . "  " . $num2;

		// Decrease the user's lives by 1
		$_SESSION['lives'] -= 1;
		echo $_SESSION["lives"] . " lives";
		// Check if the user has any lives left
		if ($_SESSION["lives"] == 0) {
			// The user has no lives left, display a game over message
			echo "<br>Game over. You have lost all your lives.";
			// Display a button to restart the game
			echo '<a href="welcome.php">Play again</a>';
			$_SESSION["status"] = 'failure';
			storeGameStatus();
		} else {
			// The user has lives left, display a button to try again
			echo '<br>You have ' . $_SESSION['lives'] . ' lives left.';
			echo '<br><a href="level6.php">Try again</a>';
			$_SESSION["status"] = 'incomplete';
		}
	}
} else if (isset($_POST['stop'])) {
	$_SESSION["status"] = "incomplete";
	storeGameStatus();
}


//<!-- Level 1: Order letters in ascending order -->
if (!isset($_POST['submit'])) {
	echo <<<_END
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/game.css">
	</head>
	<body>
	<form action="level6.php" method="post">
  <br />
	<label>Minimum Number:</label>
  <input type="text" name="num1"><br>
  <br /><label>Maximum Number:</label>
  <input type="text" name="num2"><br>
  <br /><input type="submit" name="submit" value="Submit"></form>
  <br/>
  <input type="submit" name="stop" value="Stop">
  </body>
  </html>

_END;
}
?>