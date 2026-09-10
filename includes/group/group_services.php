<?php
/*
File: PrayerOrder group services page
Author: David Sarkies 
#Initial: 1 September 2026
#Update: 10 September 2026
#Version: 2.6
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

		if($invitee_details !== false) {
			$invitation_details = $db_prayer_ro->get_invite_details(
									$group_key,
									$invitor_id,
									$invitee_id
								);

			if ($invitation_details !== false) {

				if ($invitation_details["invitorType"] === null) {
					$invite_response = "Not member of group";
				} else if ($invitation_details["adminOnlyInvite"] == True && (
					$invitation_details["invitorType"] !== "a" &&
					$invitation_details["invitorType"] !== "c")) {

					$invite_response = "Only Admins can invite users to this group";
				} else if ($invitation_details["inviteeType"] === "p") {
					$invite_response = "Invitation already sent";
				} else if ($invitation_details["inviteeType"] === "m" ||
							$invitation_details["inviteeType"] === "a" ||
							$invitation_details["inviteeType"] === "c") {
					$invite_response = "Invitee already a member";
				} else if ($invitation_details["inviteeType"] === "b" &&
							$invitation_details["invitorType"] !== "a" &&
							$invitation_details["invitorType"] !== "c") {
					$invite_response = "Only admins can invite blocked users";
				} else if ($invitation_details["inviteeType"] == "b" &&
							$invitation_details["invitorType"] === "a" &&
							$invitation_details["invitorType"] === "c") {

					$invite_response = send_invite($group_key,$invitee_id);

				} else {
					$invite_response = send_invite($group_key,$invitee_id);
				}

			} else {
				$invite_response = "Group does not exist";
			}

		} else {
			$invite_response = "User does not exist";
		}
		
		return $invite_response;
	}

	function send_invite($group_key,$invitee_id) {

		$invite_response = "";

		$result = $db_user_rw->invite_user($group_key,$invitee_id);

		if ($result) {
			$invite_response = "Invite succeeded";
		} else {
			$invite_response = "Invite failed"''
		}
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
9 September 2026 - Added checks for invites
10 September 2026 - Finished checks for sending invitation
*/