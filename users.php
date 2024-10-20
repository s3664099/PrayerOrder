<?php
/*
File: PrayerOrder User Program
Author: David Sarkies 
Initial: 22 September 2024
Update: 20 October 2024
Version: 0.6
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

			//Check nature of relationship
			$isBlocked = false;
			$relationship = getRelationship($_SESSION['user'],$x['email'],$db);

			//Checks if you've been blocked
			if ($relationship == 3) {
				$isBlocked == true;
			}

			//Not blocked
			if(!$isBlocked) {
				
				$x['no'] = "user".$user_no;
				$x['relationship'] = transcodeRelationship($relationship);
				$user_no++;
		 		$users[] = $x;
		 		error_log($x['relationship']);
		 	}
		 }
	}

	echo json_encode($users);
}

if (isset($_GET['follow'])) {

	$response="";
	
	//Follow other user
	if ($_GET['relationship']==1) {

		//Checks the db for relationshop
		$response = addRelationship($_SESSION['user'],$_GET['follow']);
		
	//Block other user
	} else if ($_GET['relationship']==3) {

		//Checks if exists
			//$follow,$self - deletes
			//Sets $self,$follow - Block

	//Unfollow other user
	} else if ($_GET['relationship']==0) {
		$response = removeRelationship($_SESSION['user'],$_GET['follow']);
	}

	$relationship = getRelationship($_SESSION['user'],$_GET['follow'],new db_functions());
	$relationship = transcodeRelationship($relationship);
	$response = array('response'=>$response,'relationship'=>$relationship);
	error_log("Two");
	echo json_encode($response);
}

function getRelationship($user,$otherUser,$db) {

	$relationship = 0;
	$relResult = $db->getRelationship($otherUser,$user);

	if($relResult->num_rows>0) {
		$relationship = $relResult->fetch_assoc()['followType'];
	}

	//No relationship found
	if ($relationship == 0) {
		$relResult = $db->getRelationship($user,$otherUser);

		if($relResult->num_rows>0) {
			$relationship = $relResult->fetch_assoc()['followType'];
		}

		//Differentiate from followed & following
		//and in relation to who has been blocked
		//		1 - You're being followed
		//		2 - Friends
		//      3 - You've been blocked
		//		4 - Your following
		//		5 - Your blocking
		if ($relationship==1) {
			$relationship=4;
		} else if ($relationship == 3) {
			$relationship=5;
		}
	}

	return $relationship;
}

//Records relationship status
function transcodeRelationship($relationship) {

	$relStatus = "None";
	if ($relationship==1) {
		$relStatus = 'Followed';
	} else if ($relationship==2) {
		$relStatus = 'Friends';
	} else if ($relationship == 4) {
		$relStatus = 'Following';
	} else if ($relationship == 5) {
		$relStatus = 'Blocked';
	}
	return $relStatus;
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
			$db->updateRelationship($followee,$follower,2);
			$response = "Friends";
		} else if ($relationship==3) {
			$response = "blocked";
		} else {
			$response = "nothing";
		}

	} else {

		//Checks if current user already following other user
		$result = $db->getRelationship($follower,$followee);
		
		//Adds a following relationship
		if ($result->num_rows==0) {
			$db->updateRelationship($follower,$followee,1);
			$response = "Following";
		} else {
			$response = "Already Following";
		}
	}

	return $response;
}

function removeRelationship($follower,$followee) {

	//Checks Current Relationship Status
	$db = new db_functions();
	$result = $db->getRelationship($followee,$follower);
	$response = "";

	if($result->num_rows>0) {

		$relationship = $result->fetch_assoc()['followType'];

		if($relationship == 2) {
			$db->updateRelationship($followee,$follower,0);
			$response = "Unfollowed";
		} else {
			$response = "Not Following";
		}
	} else {

		$result = $db->getRelationship($follower,$followee);

		if ($result->num_rows>0) {
			$db->removeRelationship($follower,$followee);
			$response = "Unfollowed";
		} else {
			$response = "Not Following";
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
19 October 2024 - Moved function to update relationship, and added code to determine relationship
				- Added option to stop following user
20 October 2024 - Added code to update relationship to freinds and to unfollow a friend.
*/