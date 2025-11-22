<?php
/*
File: PrayerOrder User Program
Author: David Sarkies 
Initial: 22 September 2024
Update: 31 July 2025
Version: 1.11
*/

require_once __DIR__ . '/user_services.php';
require_once __DIR__ . '/relationship_services.php';

header('Content-Type: application/json'); // Set content type to JSON
include '../database/db_functions.php';
include '../database/db_prayer_rw.php';

session_start();
$db = new db_functions();
$db_prayer_rw = new db_prayer_rw();

/* ====================================================================================
 * =                              Relation Functions
 * ====================================================================================
 */

//Retrieves users by name based on search query
if (isset($_GET['users'])) {
	$user_service = new user_services();
	echo json_encode($user_service->get_users($_GET['users'],$_SESSION['user']));	
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
		if (getRelationship($_GET['follow'],$_SESSION['user'],$db) != 0) {

			//If exists - deletes
			$db_prayer_rw->removeRelationship($_GET['follow'],$_SESSION['user']);
		}

		//Blocks user
		if (getRelationship($_SESSION['user'],$_GET['follow'],$db) != 0) {
			$db_prayer_rw->removeRelationship($_SESSION['user'],$_GET['follow']);
		} 
		$db_prayer_rw->updateRelationship($_SESSION['user'],$_GET['follow'],5);
		
	//Unfollow other user
	} else if ($_GET['relationship']==0) {
		$response = removeRelationship($_SESSION['user'],$_GET['follow']);

	//Unblocks user
	} else if ($_GET['relationship']==4) {
		$response = removeRelationship($_SESSION['user'],$_GET['follow']);
		$response = "unblocked";
	}

	$relationship = getRelationship($_SESSION['user'],$_GET['follow'],new db_functions());
	$relationship = transcodeRelationship($relationship);
	$response = array('response'=>$response,'relationship'=>$relationship);

	echo json_encode($response);
}





/* Connection Types
	0) No Connection (there will none of 0, but exists for getConnectionType)
	1) Following
	2) Friends
	3) Blocked
	$follower - User
	$followee - Other
*/
function addRelationship($follower,$followee) {

	//Checks if other user already following current user
	$db_prayer = new db_prayer_ro();
	$db_prayer_rw = new db_prayer_rw();
	$relationship = 0;
	$result = $db_prayer->get_relationship($followee,$follower);
	$response = "";

	//Checks if connection exists
	if($result->num_rows>0) {

		$relationship = $result->fetch_assoc()['followType'];

		//Are they following - makes friends
		if ($relationship==1) {
			$db_prayer_rw->update_relationship($followee,$follower,2);
			$response = "Friends";
		} else if ($relationship==3) {
			$response = "blocked";
		} else {
			$response = "nothing";
		}

	} else {

		//Checks if current user already following other user
		$result = $db_prayer->get_relationship($follower,$followee);
		
		//Adds a following relationship
		if ($result->num_rows==0) {
			$db_prayer_rw->update_relationship($follower,$followee,1);
			$response = "Following";
		} else {
			$response = "Already Following";
		}
	}

	return $response;
}

function removeRelationship($follower,$followee) {

	//Checks Current Relationship Status
	$db_prayer = new db_prayer_ro();
	$db_prayer_rw = new db_prayer_rw();
	$result = $db_prayer->get_relationship($followee,$follower);
	$response = "";

	if($result->num_rows>0) {

		$relationship = $result->fetch_assoc()['followType'];

		if($relationship == 2) {
			$db_prayer_rw->update_relationship($followee,$follower,0);
			$response = "Unfollowed";
		} else {
			$response = "Not Following";
		}
	} else {

		$result = $db_prayer->get_relationship($follower,$followee);

		if ($result->num_rows>0) {
			$db_prayer_rw->remove_relationship($follower,$followee);
			$response = "Unfollowed";
		} else {
			$response = "Not Following";
		}
	}
	
	return $response;
}

/* ====================================================================================
 * =                              Reaction Functions
 * ====================================================================================
 */

/*  Decode the JSON input
	0 - No reaction
	1 - pray
	2 - praise
*/

//Add, Change, Remove reaction
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['react'])) {

	$db_prayer = new db_prayer_ro();
    $reaction = $db_prayer->check_reactions($_SESSION['user'],$input['id']);
    $db_prayer = new db_prayer_rw();

    //There is no recorded reaction (reaction = 0)
    if ($reaction == 0) {
    	$db_prayer->add_reaction($_SESSION['user'],$input['id'],$input['react']);
    } else if ($reaction != $input['react'] && $input['react'] !=0) {
    	$db_prayer->update_reaction($_SESSION['user'],$input['id'],$input['react']);
    } else {
    	$db_prayer->delete_reaction($_SESSION['user'],$input['id']);
    }

} else {
    error_log("Missing POST parameter");
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
10 November 2024 - Added code to block user
12 November 2024 - Blocked user no longer display
16 November 2024 - Added unblock functionality
22 November 2024 - Removed code that excludes current user from user search (since SQL handles that)
23 November 2024 - Completed the search by reducing it to single SQL search.
				 - Added backend validation for prayer
5 December 2024 - Increased version
19 December 2024 - Began to build the code to record the user's reaction
24 December 2024 - Added code to save and update reaction
25 December 2024 - Reaction recording now works.
19 April 2025 - Moved database file
19 July 2025 - Updated reaction to new db
22 July 2025 - Updated user search to new dbs
25 July 2025 - Updated relationship
27 July 2025 - Updated db to change and remove relationships
31 July 2025 - Fixed so blocked users do not display
*/
