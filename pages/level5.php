<?php
 session_start();
 include('function.php');

 menuBar();
 $leter = $_SESSION["letter"];
 echo "<h1 style='padding:20px 0px 0px;color:blue'><strong>". strtoupper(implode(" ", $leter)) . "</strong></h1>";
 $first = $leter[0];
$last = end($leter);

if (isset($_POST['submit'])) {

	// Get the user's answer
	$txt1 = $_POST['txt1'];
    $txt2 = $_POST['txt2'];

	// Validate the user's answer

	if ($txt1 == $first && $txt2 == $last) {
		// The user's answer is correct
		echo "Congratulations, you have won this level!";
		// Display a button to go to the next level
		echo '<a href="level6.php">Go to Level 6</a>';
        $_SESSION["status"] ="incomplete"; 
		$_SESSION["level"] = 6;
		updateQustion(5);

 
	} else {
		// The user's answer is incorrect
		echo "Sorry, your answer is incorrect. " .$txt1 . "  " .$txt2;

		// Decrease the user's lives by 1
		$_SESSION["lives"] -=1;
		// Check if the user has any lives left
		if ($_SESSION["lives"] == 0) {
			// The user has no lives left, display a game over message
			echo "<br>Game over. You have lost all your lives.";
			// Display a button to restart the game
			echo '<a href="welcome.php">Play again</a>';
            $_SESSION["status"] ="failure"; 
            storeGameStatus();
  
		} else {
			// The user has lives left, display a button to try again
			echo '<br>You have ' . $_SESSION['lives'] . ' lives left.';
			echo '<br><a href="level5.php">Try again</a>';
            $_SESSION["status"] ="incomplete"; 
  
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
	<form action="level5.php" method="post">
    <br /><br />
	<label for="txt1">write first letter of the string : </label>
	<input type="text" id="txt1" name="txt1">
    <br /><br />
	<label for="txt2">write last letter of the string : </label>
	<input type="text" id="txt2" name="txt2">
	<br /><br />
    <input type="submit" name="submit" value="Submit">
	<br/>
	<input type="submit" name="stop" value="Stop">
	</form>
	</body>
	</html>

_END;
}
?>