<?php

function storeGameStatus()
{
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

        // Insert the data into the score table
        $time = date('Y-m-d H:i:s');
        $status = $_SESSION['status'];
        $lives = 6 - $_SESSION["lives"];
        $registrationOrder = $_SESSION["registrationOrder"];

        $sql = "INSERT INTO score(scoreTime, result, livesUsed, registrationOrder)
            VALUES(now(), '$status',$lives , $registrationOrder);";
        if (mysqli_query($conn, $sql)) {
            header("Location: history.php");
            //    echo "score of the game saved in db";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }

}

function menuBar()
{
    echo '
        <html>
        <head>
            <title>Kids Game</title>
            <link rel="icon" href="appicon.jpeg">
            <link rel="stylesheet" type="text/css" href="menu.css">
        </head>
        <body>
            <!-- Menu bar -->
            <div class="topnav-right">
            <a href="welcome.php"><img src="appicon.jpeg" alt="App Icon" height="45" width="80"></a>
                
                <ul class="nav">
                <li>
                <a style="margin-left: auto;" href="history.php">History</a>

                </li>';


    if (!isset($_SESSION["userName"])) {
        echo '
        <li>
        <a style="margin-left: auto;" href="login.php">Login</a>
        </li>';
    } else {
        echo '<a href="logout.php">Logout</a>';
    } ?>
    <?php
    echo '</ul>      
            </div>
            </body>
            </html>';
}

function updateQustion(int $currentLevel)
{

    if ($currentLevel != $_SESSION["level"]) {
        // initialise array of letters
        $letters = array();
        for ($i = 0; $i < 6; $i++) {
            $letters[] = chr(rand(97, 122)); // Generate a random letter
        }
        //echo implode(" ", $letters);
        $_SESSION["letter"] = $letters;

        // initialise array of numbers
        $numbers = array();
        for ($i = 0; $i < 6; $i++) {
            $numbers[] = rand(0, 100); // Generate a random number 
        }
        //echo implode(" ", $letters);
        $_SESSION["number"] = $numbers;

    }

}
?>