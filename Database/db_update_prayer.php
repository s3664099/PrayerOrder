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
	execute_query($conn,"USE prayerorder");

	$result = retrieve_data($conn,"SELECT * FROM prayer");

	foreach ($result as $x) {
		execute_query($conn,"USE po_user");
		$result = retrieve_data($conn,"SELECT id FROM user WHERE email='".$x['email']."'");
		$y = $result->fetch_array(MYSQLI_NUM);
		$prayer_id = uniqid();
		print_r($x['prayerkey']."           ".$prayer_id)."\n";
		execute_query($conn,"USE po_prayer");
		execute_query($conn,"INSERT INTO prayer (userkey,postdate,prayerkey) VALUES ('".$y[0]."','".$x['postdate']."','".$prayer_id."')");
	}
}

/*
	echo "Prayer table \n";
	execute_query($conn,"CREATE TABLE prayer(userkey VARCHAR(20) NOT NULL, postdate DATETIME, prayerkey VARCHAR(20)
						 NOT NULL UNIQUE, PRIMARY KEY(userkey,prayerkey))");
po_user
prayerorder
*/


/* Created File
*/
?>