<?php
/*
File: PrayerOrder DB update user db
Author: David Sarkies 
Initial: 4 July 2025
Update: 4 July 2025
Version: 1.0
*/

include 'db_handler.php';

$failed = False;
$db = new db_handler('db_root.json');
$conn = $db->get_connection();

$users = swap_users($conn,'prayerorder');

function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
		echo "Query Executed successfully\n";
	} else {
  		echo "Executing query: " . $conn->error."\n";
	}
}

function retrieve_data($conn,$sql) {

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->get_result();
}


function swap_users($conn,$db_name) {
	execute_query($conn,"USE ".$db_name);
	$result = retrieve_data($conn,"SELECT * FROM user");

	execute_query($conn,"USE po_user");

	foreach ($result as $x) {
		execute_query($conn,"INSERT INTO user (id,name,email,phone,password,regdate,images) VALUES ('".uniqid()."','".$x['name']."',
					 '".$x['email']."','".$x['phone']."','".$x['password']."','".$x['regdate']."','".$x['image']."') ");
	}	
}

/* 4 July 2025 - Created File
*/
?>