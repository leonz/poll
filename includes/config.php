<?php

/*****************************************************
 Database Configuration Information
 1.0 - LZ - 12/6/2013               
 ****************************************************/


$hostname = "";
$dbname = "";
$username = "";
$password = "";

$database = new mysqli($host, $username, $password, $dbname);

if (mysqli_connect_error() ) {
	die("Can't connect to database: " . $database->error);
}

?>
