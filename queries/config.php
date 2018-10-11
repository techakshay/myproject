<?php
require_once("db.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = DB_NAME;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('SHOW_SQL_ERRORS', 1);

//1062 duplicate key error
//1064 sql error