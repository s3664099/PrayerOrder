<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 18 November 2025
Version: 1.0
*/

include '../database/db_prayer_ro.php';

class relationship_services {
	
	private static $db_prayer_ro;

	// Initialize DB objects once
    function __construct() {
        self::$db_prayer_ro = new db_prayer_ro();
    }

    function get_relationship($current_user,$other_user) {

    	$relationship = get_relationship($_SESSION['user'],$x['id']);

		//This should be handled in relationship as well
		if ($relationship != 3) {
			$x['no'] = "user".$user_no;
			$x['relationship'] = transcodeRelationship($relationship);
			$user_no++;
			$users[] = $x;
		}
    }


}

/*
18 November 2025 - Created File
*/
?>