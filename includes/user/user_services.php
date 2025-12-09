<?php
/*
File: PrayerOrder User Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 9 December 2025
Version: 1.3
*/

include '../database/db_user_ro.php';

class user_services {

	private $db_user_ro;

	// Initialize DB objects once
    function __construct() {
        $this->db_user_ro = new db_user_ro();
    }

    function get_users($user_name,$user_id) {

    	$users = [];
    	$relationship_service = new relationship_services();

		$allUsers = $this->db_user_ro->get_users($user_name,$user_id);
		$user_no = 0;
	
		while ($other_user = $allUsers->fetch_assoc()) {
			$relationship = $relationship_service->get_relationship($user_id,$other_user[$USER_ID]);
			
			if ($relationship['visible']) {
				$other_user['relationship'] = $relationship['status'];
				$other_user['no'] = "user".$user_no;
				$users[] = $other_user;
				$user_no ++;
			}
		}
		return $users;
    }

    function change_relationship($relationship_type,$user_id,$other_user) {
    	$relationship_service = new relationship_services();

    	//Follow other user
		if ($relationship_type==1) {

			//Checks the db for relationshop
			$response = $relationship_service->addRelationship($user_id,$other_user);
		
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
    }
}

/*
18 November 2025 - Created File
22 November 2025 - Cleaned up file
4 December 2025 - Started building change relationship function
9 December 2025 - Added constant for user id column name
*/
?>