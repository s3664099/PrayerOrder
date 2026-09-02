<?php
/*
File: PrayerOrder group services page
Author: David Sarkies 
#Initial: 1 September 2026
#Update: 2 September 2026
#Version: 2.1
*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_ro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_rw.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_user_ro.php';

class group_services {

	private $db_user_ro;
	private $db_prayer_ro;
	private $db_prayer_rw;
	private $prayer_array;

	function __construct() {
		$this->db_user_ro = new db_user_ro();
		$this->db_prayer_ro = new db_prayer_ro();
		$this->db_prayer_rw = new db_prayer_rw();
	}

	//Checks to see if group exists when creating a new group
	function check_group($group_key) {
		$group_exists = true;
		if($db_prayer_ro->get_group($group_key) == null) {
			$group_exists = false;
		}
		return $group_exists;
	}

	function get_group($group_key) {
		return $db_prayer_ro->get_group($group_key);
	}

	function get_groups($email) {
		return $db_prayer_ro->get_groups($email);
	}

	function get_invites($emal) {
		return $db_prayer_ro->get_invites($email);
	}

	function get_user_type($key,$user_id) {
		return $db_prayer_ro->get_user_type($key,$user_id);
	}


	//We need to check how this works - this is obviously incorrect
	//It should get all of the user ids, and then retrieve all of the member details.
	//Should only hit the db once, and there is probably a way.
	function get_members($group_key) {
		$result = $db_prayer_ro->get_members($group_key);
		$group_members = []

		foreach ($result in $results) {
			$group_members.append($db_user_ro->get_prayer_user($result));
		}
	}
}

/*
1 September 2026 - Created File
2 September 2026 - Finished the read only options
*/