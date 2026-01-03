<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 20 December 2025
Version: 1.11
*/

include '../database/db_prayer_ro.php';
include '../database/db_prayer_rw.php';

use RelationshipState;
use RelationshipAction;
use RelationshipMessages;
use Column;

class relationship_services {
	
	private $db_prayer_ro;
	private $db_prayer_rw;
	private $current_relationship;

	// Initialize DB objects once
    function __construct() {
        $this->db_prayer_ro = new db_prayer_ro();
        $this->db_prayer_rw = new db_prayer_rw();
    }

    function get_relationship_with_user($current_user,$other_user) {

    	$relationship = $this->get_current_relationship($current_user,$other_user);
		$relationship_status = $this->transcode_relationship($relationship);

		$visible = true;

        // THE ONLY CASE HIDDEN: THEY block YOU
        if ($relationship === RelationshipState::BLOCKED) {
            $visible = false;
        }

        return [
            'visible' => $visible,
            'status'  => $relationship_status
        ];
    }

    function get_current_relationship($current_user,$other_user) {

    	$current_relationship = RelationshipState::NONE;
    	$relationship_result = $this->db_prayer_ro->get_relationship($current_user,$other_user);
		if($relationship_result->num_rows>0) {
			$current_relationship = $relationship_result->fetch_assoc()[Column::FOLLOW_TYPE];
		}
		return $current_relationship;
    }

    function transcode_relationship($relationship) {
		$relStatus = RelationshipMessages::NONE;
		if ($relationship == RelationshipState::FOLLOWED) {
			$relStatus = RelationshipMessages::FOLLOWED;
		} else if ($relationship == RelationshipState::FRIENDS) {
			$relStatus = RelationshipMessages::FRIENDS;
		} else if ($relationship == RelationshipState::FOLLOWING) {
			$relStatus = RelationshipMessages::FOLLOWING;
		} else if ($relationship == RelationshipState::BLOCKING) {
			$relStatus = RelationshipMessages::BLOCKING;
		} else if ($relationship == RelationshipState::BLOCKED) {
			$relStatus = RelationshipMessages::BLOCKED;
		}
		return $relStatus;
	}

	function change_relationship($relationship_type,$current_user,$other_user) {

		$this->current_relationship = $this->get_current_relationship($current_user,$other_user);
		$response = RelationshipState::NONE;

		if ($relationship_type==RelationshipAction::FOLLOW) {
			$response = $this->add_relationship_follow($current_user,$other_user);
		} else if ($relationship_type == RelationshipAction::UNFOLLOW) {
			$response = $this->remove_relationship_unfollow($current_user,$other_user);
		} else if ($relationship_type == RelationshipAction::BLOCK) {
			$response = $this->add_relationship_block($current_user,$other_user);
		} else if ($relationship_type == RelationshipAction::UNBLOCK) {
			$response = $this->remove_relationship_unblock($current_user,$other_user);
		}
		error_log($response);
		return [
			'response'=>$response,
			'relationship'=>$this->transcode_relationship($this->current_relationship)
		];
	}

	function add_relationship_follow($current_user,$other_user) {

		$response = RelationshipMessages::NONE;
		if ($this->current_relationship == RelationshipState::FOLLOWED) {
			if ($this->update_relationship_friends($current_user,$other_user)){
				$this->current_relationship = RelationshipState::FRIENDS;
				$response = RelationshipMessages::FRIENDS;
			}
		} else if ($this->current_relationship == RelationshipState::NONE) {
			if ($this->add_relationship_following($current_user,$other_user)){
				$response = RelationshipMessages::FOLLOWING;
				$this->current_relationship = RelationshipState::FOLLOWING;
			}
		} else {
			$response = RelationshipMessages::ALREADY_FOLLOWING;
		}
		return $response;
	}

	function add_relationship_block($current_user,$other_user) {
		$response = RelationshipMessages::NONE;
		if ($this->current_relationship == RelationshipState::FOLLOWING ||
			$this->current_relationship == RelationshipState::FRIENDS ||
			$this->current_relationship == RelationshipState::FOLLOWED) {
			if ($this->update_relationship_blocking($current_user,$other_user)) {
				$response = RelationshipMessages::BLOCKING;
				$this->current_relationship = RelationshipState::BLOCKING;
			}
		} else if ($this->current_relationship == RelationshipState::NONE) {
			if ($this->add_relationship_blocking($current_user,$other_user)) {
				$this->current_relationship = RelationshipState::BLOCKING;
				$response = RelationshipMessages::BLOCKING;
			}
		} else {
			$response = RelationshipMessages::ALREADY_BLOCKED;
		}
		return $response;
	}

	function remove_relationship_unfollow($current_user,$other_user) {

		$response = RelationshipMessages::NONE;

		if ($this->current_relationship == RelationshipState::FRIENDS) {
			if ($this->remove_relationship_friends($current_user,$other_user)){
				$this->current_relationship = RelationshipState::FOLLOWED;
				$response = RelationshipMessages::UNFOLLOWED;
			}
		} else if ($this->current_relationship == RelationshipState::FOLLOWING) {
			if ($this->remove_relationship_following($current_user,$other_user)){
				$this->current_relationship = RelationshipState::NONE;
				$response = RelationshipMessages::UNFOLLOWED;
			}
		} else {
			$response = RelationshipMessages::NOT_FOLLOWING;
		}
		return $response;
	}

	function remove_relationship_unblock($current_user,$other_user) {
		$response = RelationshipMessages::NONE;
		if ($this->current_relationship == RelationshipState::BLOCKING) {
			if ($this->remove_relationship_block($current_user,$other_user)){
				$this->current_relationship = RelationshipState::NONE;
				$response = RelationshipMessages::UNBLOCKED;
			}
		} else {
			$response = RelationshipMessages::NOT_BLOCKED;
		}
		return $response;
	}

	function add_relationship_following($follower,$followee) {
		return $this->db_prayer_rw->add_relationship($follower,$followee,
													RelationshipState::FOLLOWING,
													RelationshipState::FOLLOWED);
	}

	function add_relationship_blocking($blocker,$blockee) {
		return $this->db_prayer_rw->add_relationship($blocker,$blockee,
													RelationshipState::BLOCKING,
													RelationshipState::BLOCKED);
	}

	function update_relationship_blocking($blocker,$blockee) {
		return $this->db_prayer_rw->update_relationship($blocker,$blockee,
														RelationshipState::BLOCKING,
														RelationshipState::BLOCKED);
	}

	function update_relationship_friends($follower,$followee) {
		return $this->db_prayer_rw->update_relationship($follower,$followee,
														RelationshipState::FRIENDS,
														RelationshipState::FRIENDS);
	}

	function remove_relationship_friends($follower,$followee) {
		return $this->db_prayer_rw->update_relationship($follower,$followee,
														RelationshipState::FOLLOWED,
														RelationshipState::FOLLOWING);
	}


	function remove_relationship_following($follower,$followee) {
		return $this->db_prayer_rw->remove_relationship($follower,$followee,$followee,$follower);
	}

	function remove_relationship_block($follower,$followee) {
		return $this->db_prayer_rw->remove_relationship($follower,$followee,$followee,$follower);
	}
}

/*
18 November 2025 - Created File
22 November 2025 - Added relationship processing
4 December 2025 - Changed blocked to blocking for consistency
9 December 2025 - Added the add relationship function
10 December 2025 - Added remove relationship & removed magic numbers
11 December 2025 - Added change relationship function
12 December 2025 - Updated constants
13 December 2025 - Replaced strings with constants.
14 December 2025 - Tightened code
15 December 2025 - Updated change relationship function. Added functions for changing relationship types
16 December 2025 - Completed changing relationships
20 December 2025 - Moved functions into this file.
				 - Added check to prevent malforned variable.
*/
?>