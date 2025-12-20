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

class relationship_services extends relationship_constants {
	
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
        if ($relationship === self::REL_BLOCKED) {
            $visible = false;
        }

        return [
            'visible' => $visible,
            'status'  => $relationship_status
        ];
    }

    function get_current_relationship($current_user,$other_user) {

    	$current_relationship = self::REL_NONE;
    	$relationship_result = $this->db_prayer_ro->get_relationship($current_user,$other_user);
		if($relationship_result->num_rows>0) {
			$current_relationship = $relationship_result->fetch_assoc()[self::FOLLOW_TYPE];
		}
		return $current_relationship;
    }

    function transcode_relationship($relationship) {
		$relStatus = self::NONE;
		if ($relationship == self::REL_FOLLOWED) {
			$relStatus = self::FOLLOWED;
		} else if ($relationship == self::REL_FRIENDS) {
			$relStatus = self::FRIENDS;
		} else if ($relationship == self::REL_FOLLOWING) {
			$relStatus = self::FOLLOWING;
		} else if ($relationship == self::REL_BLOCKING) {
			$relStatus = self::BLOCKING;
		} else if ($relationship == self::REL_BLOCKED) {
			$relStatus = self::BLOCKED;
		}
		return $relStatus;
	}

	function change_relationship($relationship_type,$current_user,$other_user) {

		$this->current_relationship = $this->get_current_relationship($current_user,$other_user);
		$response = self::REL_NONE;

		if ($relationship_type==self::REL_FOLLOW) {
			$response = $this->add_relationship_follow($current_user,$other_user);
		} else if ($relationship_type == self::REL_UNFOLLOW) {
			$response = $this->remove_relationship_unfollow($current_user,$other_user);
		} else if ($relationship_type == self::REL_BLOCK) {
			$response = $this->add_relationship_block($current_user,$other_user);
		} else if ($relationship_type == self::REL_UNBLOCK) {
			$response = $this->remove_relationship_unblock($current_user,$other_user);
		}
		error_log($response);
		return [
			'response'=>$response,
			'relationship'=>$this->transcode_relationship($this->current_relationship)
		];
	}

	function add_relationship_follow($current_user,$other_user) {

		$response = self::NOTHING;
		if ($this->current_relationship == self::REL_FOLLOWED) {
			if ($this->update_relationship_friends($current_user,$other_user)){
				$this->current_relationship = self::REL_FRIENDS;
				$response = self::FRIENDS;
			}
		} else if ($this->current_relationship == self::REL_NONE) {
			if ($this->add_relationship_following($current_user,$other_user)){
				$response = self::FOLLOWING;
				$this->current_relationship = self::REL_FOLLOWING;
			}
		} else {
			$response = self::ALREADY_FOLLOWING;
		}
		return $response;
	}

	function add_relationship_block($current_user,$other_user) {
		$response = self::NOTHING;
		if ($this->current_relationship == self::REL_FOLLOWING ||
			$this->current_relationship == self::REL_FRIENDS ||
			$this->current_relationship == self::REL_FOLLOWED) {
			if ($this->update_relationship_blocking($current_user,$other_user)) {
				$response = self::BLOCKING;
				$this->current_relationship = self::REL_BLOCKING;
			}
		} else if ($this->current_relationship == self::REL_NONE) {
			if ($this->add_relationship_blocking($current_user,$other_user)) {
				$this->current_relationship = self::REL_BLOCKING;
				$response = self::BLOCKING;
			}
		} else {
			$response = self::ALREADY_BLOCKED;
		}
		return $response;
	}

	function remove_relationship_unfollow($current_user,$other_user) {

		$response = self::NOTHING;

		if ($this->current_relationship == self::REL_FRIENDS) {
			if ($this->remove_relationship_friends($current_user,$other_user)){
				$this->current_relationship = self::REL_FOLLOWED;
				$response = self::UNFOLLOWED;
			}
		} else if ($this->current_relationship == self::REL_FOLLOWING) {
			if ($this->remove_relationship_following($current_user,$other_user)){
				$this->current_relationship = self::REL_NONE;
				$response = self::UNFOLLOWED;
			}
		} else {
			$response = self::NOT_FOLLOWING;
		}
		return $response;
	}

	function remove_relationship_unblock($current_user,$other_user) {
		$response = self::NOTHING;
		if ($this->current_relationship == self::REL_BLOCKING) {
			if ($this->remove_relationship_block($current_user,$other_user)){
				$this->current_relationship = self::REL_NONE;
				$response = self::UNBLOCKED;
			}
		} else {
			$response = self::NOT_BLOCKING;
		}
		return $response;
	}

	function add_relationship_following($follower,$followee) {
		return $this->db_prayer_rw->add_relationship($follower,$followee,self::REL_FOLLOWING,self::REL_FOLLOWED);
	}

	function add_relationship_blocking($blocker,$blockee) {
		return $this->db_prayer_rw->add_relationship($blocker,$blockee,self::REL_BLOCKING,self::REL_BLOCKED);
	}

	function update_relationship_blocking($blocker,$blockee) {
		return $this->db_prayer_rw->update_relationship($blocker,$blockee,self::REL_BLOCKING,self::REL_BLOCKED);
	}

	function update_relationship_friends($follower,$followee) {
		return $this->db_prayer_rw->update_relationship($follower,$followee,self::REL_FRIENDS,self::REL_FRIENDS);
	}

	function remove_relationship_friends($follower,$followee) {
		return $this->db_prayer_rw->update_relationship($follower,$followee,self::REL_FOLLOWED,self::REL_FOLLOWING);
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