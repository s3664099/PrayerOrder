<?php

/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 27 July 2024
Version: 0.0
*/

//execute query
function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
	  echo "Database created successfully";
	} else {
  	echo "Error creating database: " . $conn->error;
	}

}

//Loads authentication for json file
$json = file_get_contents('db_login.json');
$json_data = json_decode($json,true);

$servername = $json_data['name'];
$username = $json_data['user'];
$password = $json_data['pw'];
$dbname = $json_data['dbname'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$sql = "DROP TABLE user";
execute_query($sql);

$sql = "CREATE TABLE user(name VARCHAR(50),email VARCHAR(200),phone VARCHAR(10),
													regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,password VARCHAR(256))";
execute_query($conn,$sql);
// Create database
//$sql = "CREATE DATABASE prayerorder";

$conn->close();

/*
27 July 2024 - Created File
*/
?>