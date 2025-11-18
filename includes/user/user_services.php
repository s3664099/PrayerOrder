<?php
/*
File: PrayerOrder User Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 18 November 2025
Version: 1.0
*/

include '../database/db_user_ro.php';

class user_services {

	private static $db_user_ro;

	// Initialize DB objects once
    function __construct() {
        self::$db_user_ro = new db_user_ro();
    }

    function get_users() {

    	$users = [];
    	$relationship_service = new relationship_services();

		$allUsers = self::$db_user->getUsers($_GET['users'],$_SESSION['user']);
		$user_no = 0;
	
		while ($x = $allUsers->fetch_assoc()) {
			$users[] = $relationship_service->get_relationship($_SESSION['user'],$x);
		}

		return $users;
    }

    //Move to relationship services
    function getRelationship($user,$otherUser) {

	$db_prayer = new db_prayer_ro();
	$relationship = 0;
	$relResult = $db_prayer->getRelationship($otherUser,$user);

	if($relResult->num_rows>0) {
		$relationship = $relResult->fetch_assoc()['followType'];
	}

	//Has user been blocked?
	if ($relationship ==5) {
		$relationship = 3;
	}

	//No relationship found
	if ($relationship == 0) {
		$relResult = $db_prayer->getRelationship($user,$otherUser);

		if($relResult->num_rows>0) {
			$relationship = $relResult->fetch_assoc()['followType'];

			if ($relationship==1) {
				$relationship=4;
			}
		}
	}
	return $relationship;
}

}

/*
18 November 2025 - Created File
*/
?>