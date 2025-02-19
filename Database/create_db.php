<?php

/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 8 February 2025
Version: 1.3
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

/*
//Create database
$sql = "CREATE DATABASE prayerorder";

//User Table create
$sql = "DROP TABLE user";
execute_query($conn,$sql);

$sql = "CREATE TABLE user(name VARCHAR(50),email VARCHAR(200),phone VARCHAR(10),
													regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,password VARCHAR(256), PRIMARY KEY(email))";
execute_query($conn,$sql);

$sql = "DELETE FROM user WHERE name = 'poo'";

//Connection table create
$sql = "DROP TABLE connection";
execute_query($conn, $sql);

$sql = "CREATE TABLE connection(follower VARCHAR(50),followee VARCHAR(50),followType INT(1),
													regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(follower,followee),FOREIGN KEY(
													follower) REFERENCES user(email),FOREIGN KEY(followee) REFERENCES user(email))";

$sql = "ALTER TABLE user MODIFY COLUMN password VARCHAR(65)";

$sql = "CREATE TABLE prayer(email VARCHAR(50), postdate DATETIME, prayerkey VARCHAR(65),
				PRIMARY KEY(email,postdate), FOREIGN KEY(email) REFERENCES user(email))";

//Create table to hold reactions
$sql = "ALTER TABLE prayer ADD UNIQUE (prayerkey)";
execute_query($conn,$sql);

$sql = "CREATE TABLE reaction(prayerkey VARCHAR(65), reactor VARCHAR(50), reaction INT(1), PRIMARY KEY(prayerkey,reactor),
															FOREIGN KEY(prayerkey) REFERENCES prayer(prayerkey),FOREIGN KEY(reactor) REFERENCES user(email))";
execute_query($conn,$sql);

*/
//Create group table;
/*
$sql = "DROP TABLE groupMembers";
execute_query($conn,$sql);
$sql = "DROP TABLE prayergroups";
execute_query($conn,$sql);

$sql = "CREATE TABLE prayergroups(groupKey VARCHAR(65),groupName VARCHAR(150), isPrivate BOOLEAN, 
																	 creator VARCHAR(50),createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,	
																	 FOREIGN KEY (creator) REFERENCES user(email), PRIMARY KEY(groupKey))";
execute_query($conn,$sql);

//Create table for group members
$sql = "CREATE TABLE groupMembers(groupKey VARCHAR(65),email VARCHAR(50), isAdmin BOOLEAN, PRIMARY KEY (groupKey,email),
																	FOREIGN KEY (groupKey) REFERENCES prayergroups(groupKey), FOREIGN KEY (email) REFERENCES
																	user(email))";
execute_query($conn,$sql);
*/
$sql = "SELECT * FROM groupMembers";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $x) {
	print_r($x);
}

#$sql = "SELECT * FROM user";
#$stmt = $conn->prepare($sql);
#$stmt->execute();
#$result = $stmt->get_result();
/*
foreach ($result as $x) {
	print_r(strlen(hash("sha256",$x['password'].$x['email']))."\n");
	$hashedpassword = hash("sha256",$x['password'].$x['email']);
	$stmt = $conn->prepare("UPDATE user SET password = ? WHERE email =?");
	$stmt->bind_param("ss",$hashedpassword,$x['email']);
	$stmt->execute();
}

$sql = "ALTER TABLE user ADD image varchar(60)";
execute_query($conn,$sql);

$sql = "UPDATE user SET image='dan.png' WHERE email='dantheman@dodgyemail.com.zz'";
execute_query($conn,$sql);

$sql = "UPDATE user SET image='dude.png' WHERE email='thedude@dude.com.mhj'";
execute_query($conn,$sql);
*/

//DB Testing
/*
$sql = "SELECT * FROM user";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $x) {
	print_r($x);
}


$sql = "SELECT * FROM connection";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $x) {
	print_r($x);
}


$sql = "SELECT * FROM prayer";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $x) {
	print_r($x);
}

#Insert some random reactions into reactions.
$prayer='31968a900ff57b326dedf8b69ac982cf6da5cd819f24e3abcdc48d0b80011006';

$sql = "SET FOREIGN_KEY_CHECKS = 0";
execute_query($conn,$sql);

for ($x=0;$x<4;$x++) {

	echo $x."\n";

	$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES ('".$prayer."','".$x."a','1')";
	execute_query($conn,$sql);
}

$sql = "SELECT * FROM reaction";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $x) {
	print_r($x);
}
*/

$conn->close();

/*
27 July 2024 - Created File
28 September 2024 - Added Script to remove some users
29 September 2024 - Create table to hold user relationships
17 October 2024 - Changed connection table to handle more than just following. Added keys.
20 November 2024 - Altered size to password table to change password to hash, and added 
									 message table
24 November 2024 - Added image column to user table
5 December 2024 - Increased version
26 December 2024 - Insert some test data into reaction table.
28 January 2025 - Added the group tables
8 February 2025 - Updated group tables
*/
?>