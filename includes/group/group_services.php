<?php
/*
File: PrayerOrder group services page
Author: David Sarkies 
#Initial: 1 September 2026
#Update: 3 September 2026
#Version: 2.2
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

	function get_members($group_key) {
		$result = $db_prayer_ro->get_members($group_key);
		$group_members = []

		foreach ($result in $results) {
			$group_members.append($db_user_ro->get_prayer_user($result));
		}
	}

	function create_group($group_key,$name,$private,$owner) {
		return $db_prayer_rw->add_group($group_key,$name,$private,$owner);
	}

	function join_group($group_key,$user) {

		$success = false;

		//Should have a response to determine if group even exists 
		//(though ideally you shouldn't be able to get to it from the front end)
		if(!$db_prayer_ro->is_group_private($group_key)) {
			$success = $db_prayer_rw->add_member($group_key,$user_id);
		} else {
			error_log("Unable to join private group");
		}

		return $success;
	}

	//Invitations
}

/*
1 September 2026 - Created File
2 September 2026 - Finished the read only options
3 September 2026 - added the create group function
4 September 2026 - Added join group function
*/