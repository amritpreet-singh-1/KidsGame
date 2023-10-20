<?php
 session_start();
 include('function.php');

 menuBar();
 $numbers = $_SESSION["number"];
 echo "<h1 style='padding:20px 0px 0px;color:blue'><strong>". (implode(" ", $numbers)) . "</strong></h1>";
 rsort($numbers);

if (isset($_POST['submit'])) {

	// Get the user's answer
	$user_answer = $_POST['numbers'];

	// Validate the user's answer

	$answer = implode(" ",(array) $numbers);
	if ($user_answer == $answer) {
		// The user's answer is correct
		echo "Congratulations, you have won this level!";
		// Display a button to go to the next level
		echo '<a href="level5.php">Go to Level 5</a>';
    $_SESSION["status"] ="incomplete"; 
	$_SESSION["level"] = 5;
	updateQustion(4);

   
	} else {
		// The user's answer is incorrect
		echo "Sorry, your answer is incorrect. " .$user_answer;

		// Decrease the user's lives by 1
		$_SESSION["lives"] -=1;
		echo $_SESSION["lives"] ." lives";
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
      echo '<br><a href="level4.php">Try again</a>';
      $_SESSION["status"] ="incomplete"; 
  
		}
	}
}
else if (isset($_POST['stop'])) {
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
	<form action="level4.php" method="post">
	<label for="numbers">Order these numbers in decending order: </label>
	<label for="numbers">ie. 6 5 4 3 2 1 </label>
	<input type="text" id="numbers" name="numbers">
	<input type="submit" name="submit" value="Submit">
	<br/>
	<input type="submit" name="stop" value="Stop">
	</form>
	</body>
	</html>

_END;
}
?>