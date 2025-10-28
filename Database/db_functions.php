<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 30 June 2025
Version: 1.6

Change password type to password_hash($password, PASSWORD_DEFAULT);
Increase size of user id field to 40 characters
*/

include 'db_handler.php';

//execute query
function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
	  echo "Database created successfully";
	} else {
  	echo "Error creating database: " . $conn->error;
	}
}

function retrieve_result($conn,$sql) {
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->get_result();
}

function retrieve_groups_groupmembers($conn) {
	$result = retrieve_result($conn,"SELECT * FROM prayergroups");
	
	foreach ($result as $x) {
		print_r($x);
		$new_result = retrieve_result($conn,"SELECT * FROM groupMembers WHERE groupKey='".$x['groupKey']."'");
		foreach($new_result as $y) {
			print_r($y);
		}
	}
}

function retrieve_groupmembers($conn) {

	$sql = "SELECT * FROM groupMembers";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r($x);
	}
}

function hash_passwords($conn) {

	$sql = "SELECT * FROM user";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r(strlen(hash("sha256",$x['password'].$x['email']))."\n");
		print_r($x);
		$hashedpassword = hash("sha256","password".$x['email']);
		$stmt = $conn->prepare("UPDATE user SET password = ? WHERE email =?");
		$stmt->bind_param("ss",$hashedpassword,$x['email']);
		$stmt->execute();
	}	
}

function get_users($conn) {

	$sql = "SELECT * FROM user";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r($x);
	}
}

function get_connections($conn) {

	$sql = "SELECT * FROM connection";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r($x);
	}
}

function get_prayers($conn) {

	$sql = "SELECT * FROM prayer";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r($x);
	}
}

function insert_reactions($conn,$prayer) {

 execute_query("SET FOREIGN_KEY_CHECKS = 0");

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
}

function get_groupname($conn,$key) {

	$sql = "SELECT groupName FROM prayergroups WHERE groupKey='".$key."'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach ($result as $x) {
		print_r($x['groupName']);
	}
}

function display_member_type($conn,$memtype) {

	$sql = "SELECT * FROM groupMembers WHERE memberType='".$memtype."'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
}

function display_columns($conn,$table) {

	$sql = "SHOW COLUMNS FROM ".$table;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach($result as $x) {
		print_r($x);
	}
}

function display_databases($conn) {

	$sql = "SHOW DATABASES";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();

	foreach($result as $x) {
		print_r($x);
	}
}

$db = new db_handler('db_root.json');
$conn = $db->get_connection();
#retrieve_groupmembers($conn);
display_databases($conn);
/*

//Create new dbs
//Create dictionaries to store keys
//Move user and add user id
	//user keys start with usr
//Move connection and switch emails with id
//Move groups and replace emails with ids and group keys with new ids
	//Group keys start with grp

//Do same with prayers and reactions
	//If no reference to user in reaction generate a key starting with rnd
	//prayer keys start with pry

//Generate users for db and store in json file (wr/ro for user & prayer)
	//Create db kills user after db created (admin only temp)

*/

$db->close_connection();

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
15 April 2025 - Retrieve group name
11 May 2025 - Added memberType to groupMembers and removed isAdmin
26 June 2025 - Continued sorting queries. Added notes
27 June 2025 - Finished moving queries into functions
29 June 2025 - Added script to display databases
*/
?>