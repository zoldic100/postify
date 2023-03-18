<?php

$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "postify";
$port = 4306;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,$port);

/*
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

*/

?>