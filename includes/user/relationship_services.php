<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 14 December 2025
Version: 1.8
*/

include '../database/db_prayer_ro.php';
include '../database/db_prayer_rw.php';


class relationship_services extends relationship_constants {
	
	private $db_prayer_ro;
	private $db_prayer_rw;
	private $current_relationship_user = self::REL_NONE;
	private $current_relationship_other = self::REL_NONE;

	// Initialize DB objects once
    function __construct() {
        $this->db_prayer_ro = new db_prayer_ro();
        $this->db_prayer_rw = new db_prayer_rw();
    }

    function get_current_relationship($current_user,$other_user) {
    	$relationship_result = $this->db_prayer_ro->get_relationship($user,$otherUser);

		if($relationship_result->num_rows>0) {
			$this->current_relationship_user = $relationship_result->fetch_assoc()[self::FOLLOW_TYPE];
		}

		$relationship_result = $this->db_prayer_ro->get_relationship($user,$otherUser);

		if($relationship_result->num_rows>0) {
			$this->current_relationship_other = $relationship_result->fetch_assoc()[self::FOLLOW_TYPE];
		}
    }

    function get_relationship($current_user,$other_user) {

    	$relationship = $this->get_relationship_type($current_user,$other_user);
		$status = $this->transcode_relationship($relationship);

		$visible = true;

        // THE ONLY CASE HIDDEN: THEY block YOU
        if ($relationship === self::REL_BLOCKED) {
            $visible = false;
        }

        return [
            'visible' => $visible,
            'status'  => $status
        ];
    }

    function get_relationship_type($user,$otherUser) {

    	$this->get_current_relationship($current_user,$other_user);
    	$relationship = $this->current_relationship_user;

		//Has user been blocked?
		if ($relationship == self::REL_BLOCKING) {
			$relationship = self::REL_BLOCKED;
		}

		//No relationship found
		if ($relationship == self::REL_NONE) {

			$relationship = $this->current_relationship_other;

			if ($relationship == self::REL_FOLLOWED) {
				$relationship = self::REL_FOLLOWING;
		}
		return $relationship;
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

	function change_relationship($relationship_type,$user_id,$other_user) {

		$this->get_current_relationship($current_user,$other_user);

    	//Follow other user
		if ($relationship_type==self::REL_FOLLOWED) {

			//Checks the db for relationshop
			$response = $this->add_relationship($user_id,$this->current_relationship_user,
												$other_user,$this->current_relationship_other);
		
		//Block other user
		} else if ($relationship_type==self::REL_BLOCKED) {

			//Checks if exists
			if ($this->current_relationship_other != self::REL_NONE) {

				//If exists - deletes
				$this->remove_relationship($other_user,$this->current_relationship_other,
											$user_id,$this->current_relationship_user);
			}

			//Blocks user
			if ($this->current_relationship_user != self::REL_NONE) {
				$this->remove_relationship($user_id,$this->current_relationship_user,
										   $other_user,$this->current_relationship_other);
			} 
			$this->db_prayer_rw->update_relationship($user_id,$other_user,self::REL_BLOCKING);
		
		//Unfollow other user
		} else if ($relationship_type==self::REL_NONE) {
			$response = $this->remove_relationship($user_id,$this->current_relationship_user,
													$other_user,$this->current_relationship_other);

		//Unblocks user
		} else if ($relationship_type==self::REL_FOLLOWING) {
			$response = $this->remove_relationship($user_id,$this->current_relationship_user,
													$other_user,$this->current_relationship_other);
			$response = self::UNBLOCKED;
		}

		$relationship = $this->get_relationship_type($user_id,$other_user);
		$relationship = $this->transcode_relationship($relationship);
		
		return [
			'response'=>$response,
			'relationship'=>$relationship
		];
	}


	function add_relationship($follower,$follower_relationship,$followee,$followee_relationship) {

		$response = "";
		if ($followee_relationship == self::REL_FOLLOWED) {
			$this->db_prayer_rw->update_relationship($followee,$follower,self::REL_FRIENDS);
			$response = self::FRIENDS;$follower_relationship
		} else if ($followee_relationship == self::REL_BLOCKED) {
			$response = self::HAS_BLOCKED;
		} else if ($followee_relationship == self::REL_NONE) {
			if($follower_relationship == self::REL_NONE) {
				$this->db_prayer_rw->update_relationship($follower,$followee,self::REL_FOLLOWED);
				$response = self::FOLLOWING;
			} else {
				$response = self::ALREADY_FOLLOWING;
			}
		} else {
			$response = self::NOTHING;
		}

		return $response;
	}

	function remove_relationship($follower,$follower_relationship,$followee,$followee_relationship) {

		if($followee_relationship == self::REL_FRIENDS) {
			$this->db_prayer_rw->update_relationship($followee,$follower,self::REL_NONE);
			$response = self::UNFOLLOWED;
		} else if ($followee_relationship == self::REL_NONE) {
			if ($follower_relationship != self::REL_NONE) {
				$this->db_prayer_rw->remove_relationship($follower,$followee);
				$response = self::UNFOLLOWED;
			} else {
				$response = self::NOT_FOLLOWED;
			}
		} else {
			$response = self::NOT_FOLLOWED;
		}

		return $response;
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
*/
?>