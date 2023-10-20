<?php
session_start();
include('function.php');
menuBar();
$leter = $_SESSION["letter"];
echo "<h1 style='padding:20px 0px 0px;color:blue'><strong>" . strtoupper(implode(" ", $leter)) . "</strong></h1>";
sort($leter);

if (isset($_POST['submit'])) {

	// Get the user's answer
	$user_answer = $_POST["letters"];

	// Validate the user's answer

	$answer = strtoupper(implode(" ", (array) $leter));
	if (strtoupper($user_answer) == $answer) {
		// The user's answer is correct
		echo "Congratulations, you have won this level!";
		// Display a button to go to the next level
		echo '<a href="level2.php"> Go to Level 2</a>';
		$_SESSION["status"] = "incomplete";
		$_SESSION["level"] = 2;
	//	updateQustion(1);
		$_SESSION["level"] = 0;
		updateQustion(1);

	} else {
		// The user's answer is incorrect
		echo "Sorry, your answer is incorrect. <br />";

		// Decrease the user's lives by 1
		$_SESSION["lives"] -= 1;
		// Check if the user has any lives left
		if ($_SESSION["lives"] == 0) {
			// The user has no lives left, display a game over message
			echo "<br>Game over. You have lost all your lives.";
			// Display a button to restart the game
			echo '<a href="welcome.php">Play again</a>';
			$_SESSION["status"] = "failure";
			storeGameStatus();
		} else {
			// The user has lives left, display a button to try again
			echo '<br>You have ' . $_SESSION['lives'] . ' lives left.';
			echo '<br><a href="level1.php">Try again</a>';
			$_SESSION["status"] = "incomplete";
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
		<form action="level1.php" method="post">
		<label for="letters">Order these letters in ascending order: </label>
		<label for="letters">ie. A B C D E F </label>
		<input type="text" id="letters" name="letters">
		<input type="submit" name="submit" value="Submit">
		<br/>
		<input type="submit" name="stop" value="Stop">
		</form>
	</body>
	</html>
_END;
}
?>