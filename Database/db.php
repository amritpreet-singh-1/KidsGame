<?php
function messages(){
    //Create messages 
    $dbMessages['ErrDBMS']="<p>Connection to MySQL failed!</p>"; 
    $dbMessages['ErrDB']="<p>Connection to the DB failed!</p>";
    $dbMessages['CreateDB']="<p>Creation of the DB failed!</p>"; 
    $dbMessages['CreateTab']="<p>Creation of the Table failed!</p>";
    $dbMessages['InsertToTab']="<p>Data insertion to the Table failed!</p>";
    $dbMessages['SelectFromTab']="<p>Data selection from the Table failed!</p>";
    //Group messages by category 
    $groupMessages['error']=$dbMessages;    
    return $groupMessages;
}
function shareFormData($collected)
{
    //Stactic variable to saved the last value for next call
    static $data = NULL;
    //Display the last value of $message
    if ($collected==NULL){
        if ($data==NULL)
            return FALSE; 
        else
            return $data;
    }
    //Save the last value of $message
    else{
        $data = $collected;
    }
}

function mySQLiError($msg)
{
    //Stactic variable to saved the last value for next call
    static $message = "<p>No error message found!</p>";
    //Display the last value of $message
    if ($msg==NULL){
        echo "<p>$message</p>";
    }
    //Save the last value of $message
    else{
        $message = $msg;
    }
}

function connectToDBMS($hostname, $username, $password){
    $messages=messages();
    //Attempt to connect to MySQL using MySQLi
    $connection = new mysqli($hostname, $username, $password);
    //If connection to the MySQL failed save the system error message 
    if ($connection->connect_error){
        mySQLiError(mysqli_connect_error());
        return FALSE;
    }
    else 
        return $connection;
}

function connectToDB($connectionDBMS, $database){
    //Attempt to connect to the Database
    $connectionDB = mysqli_select_db($connectionDBMS, $database);
    //If connection to the Database failed save the system error message 
    if ($connectionDB === FALSE) {
        mySQLiError($connectionDBMS->error);
        return FALSE;
    }
}

function sqlCommands(){
    //Create queries
    $sqlCode['createDB']="CREATE DATABASE users;";
    $sqlCode['createTab']="CREATE TABLE employees(
        id INT(5) PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(35) NOT NULL,
        lastname VARCHAR(35) NOT NULL,
        email VARCHAR(35) NOT NULL
        ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $sqlCode['descEmpl']="DESC employees;";
    $sqlCode['selectInEmpl']="SELECT * FROM employees;";
    //Return an array of queries
    return $sqlCode;
}

function sqlInsertCommand(){
    //Declare and assign values
    $values=shareFormData('');
    $fn=$values['fname'];
    $ln=$values['lname'];
    $eml=$values['email'];
    //Create queries
    $sqlCode['InsertInEmpl']="INSERT INTO employees (firstname, lastname, email) VALUES ('$fn', '$ln', '$eml');";
    //Return an array of queries
    return $sqlCode;
}

function executeSqlQuery($connection, $query){
    //Execute the query
    $invokeQuery = $connection->query($query);
    //If data insertion to the table failed save the system error message  
    if ($invokeQuery === FALSE){
        mySQLiError($connection->error);
        return FALSE;
    }
    else 
        return $invokeQuery;
}

function displaySelectData($query){
    //Calculate the number of rows available
    $number_of_rows = $query->num_rows;
    //Use a loop to display the rows one by one
    echo "<table>";
    echo "<tr><td>ID</td><td>First Name</td><td>Last Name</td><td>Email</td></tr>";
    for ($j = 0; $j < $number_of_rows; ++$j) {
        echo "<tr>";
        //Assign the records of each row to an associative array
        $each_row = $query->fetch_array(MYSQLI_ASSOC);
        //Display each the record corresponding to each column
        foreach ($each_row as $item)
            echo "<td>" . $item . "</td>";
        /*
        echo "<td>" . $each_row['id'] . "</td>";
        echo "<td>" . $each_row['firstname'] . "</td>";
        echo "<td>" . $each_row['lastname'] . "</td>";
        echo "<td>" . $each_row['email'] . "</td>";
        */
        echo "</tr>";
    }
    
    echo "</table>";
}

function disconnectToDBMS($connection){
    $disconnectDBMS=$connection->close();
    if($disconnectDBMS === FALSE){
        mySQLiError($connection->error);
        return FALSE;
    }
}




