<?php
/*
File: PrayerOrder group services page
Author: David Sarkies 
#Initial: 1 September 2026
#Update: 8 September 2026
#Version: 2.4
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

	//So, we need to test if the user has been invited, and rejects if blocked or already a member
	function join_group($group_key,$user) {

		$success = false;

		if(!$db_prayer_ro->is_group_private($group_key)) {
			$success = $db_prayer_rw->add_member($group_key,$user_id);
		} else {
			error_log("Unable to join private group");
		}

		return $success;
	}

	function invite_user($group_key,$invitee_id,$invitor_id) {

		$invite_response = "";
		$invitee_details = $db_user_ro->get_prayer_user($invitee_id);

		if($invitee_details != null) {
			$invitation_detals = $db_prayer_ro->get_invite_details(
									$group_key,
									$invitor_id,
									$invitee_id
								);

			if ($invitee_details != null) {



				//$details = [
   				//	"groupKey"            => "abc123",
    			//	"groupName"           => "My Prayer Group",
    			//	"isPrivate"           => 0,
    			//	"onlyAdminCanInvite"  => 1,
    			//	"invitorType"         => "a",
    			//	"inviteeType"         => "b"];
    //| Situation                                           | `invitorType` | `inviteeType` |
	//| --------------------------------------------------- | ------------- | ------------- |
	//| Invitor is member, invitee has no relationship      | `m`           | `NULL`        |
	//| Invitor is admin                                    | `a`           | `NULL`        |
	//| Invitor is creator                                  | `c`           | `NULL`        |
	//| Invitor isn't in group, invitee has no relationship | `NULL`        | `NULL`        |
	//| Invitor is member, invitee is member                | `m`           | `m`           |
	//| Invitor is member, invitee is pending               | `m`           | `p`           |
	//| Invitor is member, invitee is blocked               | `m`           | `b`           |

			} else {
				$invite_response = "Group does not exist";
			}

			//checks invitor in group and status
			//Checks invitee in group and status

			//If invitor admin & user is blocked, changes to pending
			//If invitor not admin can non-admin admins invite

			//So, if only admin can invite rejects any attempts invites
			//If invitor not a member - rejects invite

		} else {
			$invite_response = "User does not exist";
		}
		
		return $invite_response;
	}

	//Accept Invite
}

/*
1 September 2026 - Created File
2 September 2026 - Finished the read only options
3 September 2026 - added the create group function
4 September 2026 - Added join group function
7 September 2026 - Added notes for sending invite
8 September 2026 - Added check invite status
*/