<?php

$json = file_get_contents('db_login.json');
$json_data = json_decode($json,true);
 echo $json_data['pw'];

$servername = $json_data['name'];
$username = $json_data['user'];
$password = $json_data['pw'];

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
	echo "Success\n";
}

?>