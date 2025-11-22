<?php
/*
File: PrayerOrder User Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 22 November 2025
Version: 1.1
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
			$relationship = $relationship_service->get_relationship($user_id,$other_user,$user_no);
			
			if ($relationship['visible']) {
				$other_user['relationship'] = $relationship['status'];
				$other_user['no'] = "user".$user_no;
				$users[] = $other_user;
				$user_no ++;
			}
		}

		return $users;
    }
}

/*
18 November 2025 - Created File
22 November 2025 - Cleaned up file
*/
?>