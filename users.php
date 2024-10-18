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

//Retrieves users by name based on search query
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

if (isset($_GET['follow'])) {
	
	if ($_GET['relationship']==1) {

		//Checks the backend for relationshop
			//$follow,$self - Friends
			//Else following
		error_log(addRelationship($_SESSION['user'],$_GET['follow']));
		
	} else if ($_GET['relationship']==3) {
		//Checks if exists
			//$follow,$self - deletes
			//Sets $self,$follow - Block
	}
	
	//Add here for unfollow
		//Checks for $follow,$self - sets to follow
		//else deletes

	echo json_encode("Hello");
}

/* Connection Types
	0) No Connection (there will none of 0, but exists for getConnectionType)
	1) Following
	2) Friends
	3) Blocked
	$follower - User
	$followee = Other
*/
function addRelationship($follower,$followee) {

	//Checks if other user already following current user
	$db = new db_functions();
	$result = $db->getRelationship($followee,$follower);
	$response = "";

	//Checks if connection exists
	if($result->num_rows>0) {

		$relationship = $result->fetch_assoc()['followType'];

		//Are they following - makes friends
		if ($relationship==1) {
			$response = "friends";
		} else if ($relationship==3) {
			$response = "blocked";
		} else {
			$response = "nothing";
		}
	} else {

		//Checks if current user already following other user
		$result = $db->getRelationship($follower,$followee);
		
		if ($result->num_rows==0) {
			$db->updateRelationship($follower,$followee,1);
			$response = "Following";
		} else {
			$response = "Already Following";
		}
	}

	return $response;
}

/*
22 September 2024 - Created File
26 September 2024 - Retrieved the names matching the string entered
1 October 2024 - Added filter so as not to include user's result
13 October 2024 - Added unique id for user
14 October 2024 - Added further notes for following
*/