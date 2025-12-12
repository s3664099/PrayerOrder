<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 18 November 2025
Update: 12 December 2025
Version: 1.6
*/

include '../database/db_prayer_ro.php';
include '../database/db_prayer_rw.php';


class relationship_services extends relationship_constants {
	
	private $db_prayer_ro;
	private $db_prayer_rw;

	// Initialize DB objects once
    function __construct() {
        $this->db_prayer_ro = new db_prayer_ro();
        $this->db_prayer_rw = new db_prayer_rw();
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

		$relationship = self::REL_NONE;

		// First: their relationship to you
		$relResult = $this->db_prayer_ro->get_relationship($otherUser,$user);

		if($relResult->num_rows>0) {
			$relationship = $relResult->fetch_assoc()[self::FOLLOW_TYPE];
		}

		//Has user been blocked?
		if ($relationship == self::REL_BLOCKING) {
			$relationship = self::REL_BLOCKED;
		}

		//No relationship found
		if ($relationship == self::REL_NONE) {

			// Second: your relationship to them
			$relResult = $this->db_prayer_ro->get_relationship($user,$otherUser);

			if($relResult->num_rows>0) {
				$relationship = $relResult->fetch_assoc()[self::FOLLOW_TYPE];
				error_log($relationship);
				if ($relationship == self::REL_FOLLOWED) {
					$relationship = self::REL_FOLLOWING;
				}
			}
		}
		return $relationship;
	}

	function transcode_relationship($relationship) {

		$relStatus = "None";
		if ($relationship == self::REL_FOLLOWED) {
			$relStatus = 'Followed';
		} else if ($relationship == self::REL_FRIENDS) {
			$relStatus = 'Friends';
		} else if ($relationship == self::REL_FOLLOWING) {
			$relStatus = 'Following';
		} else if ($relationship == self::REL_BLOCKING) {
			$relStatus = 'Blocking';
		} else if ($relationship == self::REL_BLOCKED) {
			$relStatus = 'Skip';
		}
		return $relStatus;
	}

	function change_relationship($relationship_type,$user_id,$other_user) {

    	//Follow other user
		if ($relationship_type==self::REL_FOLLOWED) {

			//Checks the db for relationshop
			$response = $this->add_relationship($user_id,$other_user);
		
		//Block other user
		} else if ($relationship_type==self::REL_BLOCKED) {

			//Checks if exists
			if ($this->db_prayer_ro->get_relationship($other_user,$user_id) != self::REL_NONE) {

				//If exists - deletes
				$this->remove_relationship($other_user,$user_id);
			}

			//Blocks user
			if ($this->db_prayer_ro->get_relationship($user_id,$other_user) != self::REL_NONE) {
				$this->remove_relationship($user_id,$other_user);
			} 
			$this->db_prayer_rw->update_relationship($user_id,$other_user,self::REL_BLOCKING);
		
		//Unfollow other user
		} else if ($$relationship_type==self::REL_NONE) {
			$response = $this->remove_relationship($user_id,$other_user);

		//Unblocks user
		} else if ($relationship_type==self::REL_FOLLOWING) {
			$response = $this->remove_relationship($user_id,$other_user);
			$response = "unblocked";
		}

		$relationship = $this->get_relationship_type($user_id,$other_user);
		$relationship = $this->transcode_relationship($relationship);
		return array('response'=>$response,'relationship'=>$relationship);
	}

	function add_relationship($follower,$followee) {

		//Checks if other user already following current user
		$relationship = self::REL_NONE;
		$result = $this->db_prayer_ro->get_relationship($followee,$follower);
		$response = "";

		//Checks if connection exists
		if($result->num_rows>0) {

			$relationship = $result->fetch_assoc()[self::FOLLOW_TYPE];

			//Are they following - makes friends
			if ($relationship==1) {
				$this->db_prayer_rw->update_relationship($followee,$follower,self::REL_FRIENDS);
				$response = "Friends";
			} else if ($relationship==self::REL_BLOCKED) {
				$response = "blocked";
			} else {
				$response = "nothing";
			}

		} else {

			//Checks if current user already following other user
			$result = $this->db_prayer_ro->get_relationship($follower,$followee);
		
			//Adds a following relationship
			if ($result->num_rows==0) {
				$this->db_prayer_rw->update_relationship($follower,$followee,self::REL_FOLLOWED);
				$response = "Following";
			} else {
				$response = "Already Following";
			}
		}

		return $response;
	}

	function remove_relationship($follower,$followee) {

		$result = $this->db_prayer_ro->get_relationship($followee,$follower);
		$response = "";

		if($result->num_rows>0) {

			$relationship = $result->fetch_assoc()[self::FOLLOW_TYPE];
			if($relationship == self::REL_FRIENDS) {
				$this->db_prayer_rw->update_relationship($followee,$follower,self::REL_NONE);
				$response = "Unfollowed";
			} else {
				$response = "Not Following";
			}
		} else {

			$result = $this->db_prayer_ro->get_relationship($follower,$followee);

			if ($result->num_rows>0) {
				$this->db_prayer_rw->remove_relationship($follower,$followee);
				$response = "Unfollowed";
			} else {
				$response = "Not Following";
			}
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
*/
?>