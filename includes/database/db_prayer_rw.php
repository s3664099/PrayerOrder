<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 9 December 2025
Version: 1.5
*/

if (file_exists('../database/db_handler.php')) {
    include_once '../database/db_handler.php';
    error_log("Loaded ../database/db_handler.php");
} elseif (file_exists('db_handler.php')) {
    include_once 'db_handler.php';
    error_log("Loaded db_handler.php");
} elseif (file_exists('includes/database/db_handler.php')) {
    include_once 'includes/database/db_handler.php';
    error_log("Loaded /includes/database/db_handler.php");
} else {
    error_log("No db_handler.php found!");
}

$FOLLOW_TYPE = 'followType';

class db_prayer_rw {

	private $db;
	private $conn;

	private const REL_NONE = 0;
	private const REL_FOLLOWED = 1;
	private const REL_FRIENDS = 2;
	private const REL_BLOCKED = 3;
	private const REL_FOLLOWING = 4;
	private const REL_BLOCKING = 5;

	function __construct() {
		
		if(file_exists('../database/db_prayer_rw.json')) {
			$this->db = new db_handler('../database/db_prayer_rw.json');
		} else {
			$this->db = new db_handler('includes/database/db_prayer_rw.json');
		}

		if (!isset($this->db)) {
    		throw new Exception("No db_prayer_rw.json found!");
		}
		
		$this->conn = $this->db->get_connection();
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	function add_reaction($user,$prayerKey,$reaction) {

		$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$success = false;

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$prayerKey,$user,$reaction);

			if (!$stmt->execute()) {
				error_log("Failed ".$stmt->error);
			} else {
				$success = true;
			}
			$stmt->close();
		}
		return $success;
	}

	function update_reaction($user,$prayerKey,$reaction) {

		$sql = "UPDATE reaction SET reaction = ? WHERE prayerkey = ? AND reactor = ?";
		$success = false;
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$reaction,$prayerKey,$user);
		
			if (!$stmt->execute()) {
				error_log("Failed ".$stmt->error);
			} else {
				$success = true;
			}
			$stmt->close();
		}
		return $success;
	}

	function delete_reaction($user,$prayerKey) {

		$sql = "DELETE FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$success = false;
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$prayerKey,$user);

			if (!$stmt->execute()) {
				error_log("Failed ".$stmt->error);
			} else {
				$success = true;
			}
			$stmt->close();
		}
	}

	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	*/

	function update_relationship($follower,$followee,$relType) {

		$stmt="";
		$success = false;


		if ($relType==self::REL_FOLLOWED || $relType==self::REL_BLOCKED || $relType==self::REL_BLOCKING) {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) VALUES (?,?,?)");
			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("ssi",$follower,$followee,$relType);
			}
		} else if ($relType==self::REL_FRIENDS || $relType==self::REL_NONE || $relType==self::REL_FOLLOWING) {
			$targetType = $relType;

			//Unfollowing a friends
			if($relType==self::REL_NONE) {
				$targetType = self::REL_FOLLOWED;
			} else if ($relType==self::REL_FOLLOWING) {
				$targetType = self::REL_BLOCKED;
			}

			$stmt = $this->conn->prepare("UPDATE connection SET followType=? WHERE follower=? AND followee=?");
			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("iss",$targetType,$follower,$followee);
			}
		}

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			if($stmt->execute()) {
				error_log("Success");
				$success = true;
			} else {
				error_log("Failure: ".$stmt->error);
			}
			$stmt->close();
		}
		return $success;
	}

	//Delete relationship
	function remove_relationship($follower,$followee) {
		$sql = "DELETE FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$success = false;
		if(!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$follower,$followee);
			
			if($stmt->execute()) {
				error_log("Success");
				$success = true;
			} else {
				error_log("Failure: ".$stmt->error);
			}
			$stmt->close();
		}
		return $success;
	}

	/*====================================================================================
	* =                               Prayer Functions
	* ====================================================================================
	*/

	//Add prayer metadata
	function add_prayer($user,$postDate,$key) {

		$sql = "INSERT INTO prayer(userkey,postdate,prayerkey) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$success = false;

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$user,$postDate,$key);
		
			if($stmt->execute()) {
				error_log("Success");
				$success = true;
			} else {
				error_log("Failure: ".$stmt->error);
			}
			$stmt->close();
		}
		return $success;
	}
}

/* 14 July 2025 - Created file
 * 19 July 2025 - Updated includes for handler
 *				- Added reaction queries
 * 25 July 2025 - Added relationship functions
 * 21 October 2025 - Added the prayer function
 * 10 November 2025 - Added error handling for failed prepares. Removed magic numbers. Added responses to advise
 *					  Success or failure.
 * 22 November 2025 - changed function names for consistency
 * 9 December 2025 - Added constant for relationship type column name
*/
?>