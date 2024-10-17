<?php
/*
File: PrayerOrder User Program
Author: David Sarkies 
Initial: 22 September 2024
Update: 14 October 2024
Version: 0.4
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
				//Call check connection
				//Does both ways
					//x$,$user then $user,$x
					//No values means - None
					//True,False - Followed
					//False,True - Following
					//True,True - Friends
					//Blocked on either - doesn't add

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
14 October 2024 - Added further notes for following
*/