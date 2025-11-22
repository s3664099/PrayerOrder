<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 22 November 2025
Version: 1.1
*/

include '../database/db_prayer_ro.php';

class relationship_services {
	
	private static $db_prayer_ro;

	private const REL_NONE = 0;
	private const REL_FOLLOWED = 1;
	private const REL_FRIENDS = 2;
	private const REL_BLOCKED = 3;
	private const REL_FOLLOWING = 4;
	private const REL_BLOCKING = 5;

	// Initialize DB objects once
    function __construct() {
        self::$db_prayer_ro = new db_prayer_ro();
    }

    function get_relationship($current_user,$other_user,$user_no) {

    	$relationship = self::get_relationship_type($_SESSION['user'],$other_user['id'],$user_no);

		//This should be handled in relationship as well
		if ($relationship != 3) {
			$other_user['no'] = "user".$user_no;
			$other_user['relationship'] = self::transcode_relationship($relationship);
			$user_no++;
		}
		return $other_user;
    }

    function get_relationship_type($user,$otherUser) {

		$relationship = self::REL_NONE;
		$relResult = self::$db_prayer_ro->getRelationship($otherUser,$user);

		if($relResult->num_rows>0) {
			$relationship = $relResult->fetch_assoc()['followType'];
		}

		//Has user been blocked?
		if ($relationship ==self::REL_BLOCKING) {
			$relationship = self::REL_BLOCKED;
		}

		//No relationship found
		if ($relationship == self::REL_NONE) {
			$relResult = self::$db_prayer_ro->getRelationship($user,$otherUser);

			if($relResult->num_rows>0) {
				$relationship = $relResult->fetch_assoc()['followType'];

				if ($relationship==self::REL_FOLLOWED) {
					$relationship=self::REL_FOLLOWING;
				}
			}
		}
		return $relationship;
	}

	function transcode_relationship($relationship) {

		$relStatus = "None";
		if ($relationship==self::REL_FOLLOWED) {
			$relStatus = 'Followed';
		} else if ($relationship==self::REL_FRIENDS) {
			$relStatus = 'Friends';
		} else if ($relationship == self::REL_FOLLOWING) {
			$relStatus = 'Following';
		} else if ($relationship == self::REL_BLOCKED) {
			$relStatus = 'Blocked';
		}
		return $relStatus;
	}
}

/*
18 November 2025 - Created File
22 November 2025 - Added relationship processing
*/
?>