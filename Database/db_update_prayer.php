<?php
/*
File: PrayerOrder DB update prayer db
Author: David Sarkies 
Initial: 20 June 2025
Update: 20 June 2025
Version: 1.1
*/

include 'db_handler.php';

$failed = False;
$db = new db_handler('db_root.json');
$conn = $db->get_connection();

$users = swap_prayer_data($conn,'prayerorder');

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

function swap_prayer_data($conn) {
	
}

/*
po_user
prayerorder
*/


/* Created File
*/
?>