<?php
/*
File: PrayerOrder User Program
Author: David Sarkies 
Initial: 22 September 2024
Update: 13 October 2024
Version: 0.3
*/
header('Content-Type: application/json'); // Set content type to JSON
include 'db_functions.php';

session_start();

if (isset($_GET['users'])) {
	
	$db = new db_functions();
	$users = [];

	$allUsers = $db->getUsers($_GET['users']);
	$user_no = 0;
	
	while ($x = $allUsers->fetch_assoc()) {

		if ($x['email'] != $_SESSION['user']) {

			//Check if being followed/following/friends/None
			//Relationship values
			//	-None - No Relationship
			//	-Following - Users followed
			//	-Followed - Users being followed by
			//	-Frieds - Users followed and being followed by

			$x['relationship'] = "None";
			$x['no'] = "user".$user_no;
			$user_no++;

		 	$users[] = $x;
		 }
	}

	echo json_encode($users);
}

/*
22 September 2024 - Created File
26 September 2024 - Retrieved the names matching the string entered
1 October 2024 - Added filter so as not to include user's result
13 October 2024 - Added unique id for user
*/