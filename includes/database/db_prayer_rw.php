<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 10 November 2025
Version: 1.4
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

class db_prayer_rw {

	private $db;
	private $conn;

	function __construct() {
		
		if(file_exists('../database/db_prayer_rw.json')) {
			$this->db = new db_handler('../database/db_prayer_rw.json');
		} else {
			$this->db = new db_handler('includes/database/db_prayer_rw.json');
		}
		
		$this->conn = $this->db->get_connection();
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	function addReaction($user,$prayerKey,$reaction) {

		$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$prayerKey,$user,$reaction);

			if (!$stmt->execute()) {
				error_log("Failed ".$stmt->error);
			}
		}

	}

	function updateReaction($user,$prayerKey,$reaction) {

		$sql = "UPDATE reaction SET reaction = ? WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$reaction,$prayerKey,$user);
		
			if (!$stmt->execute()) {
				error_log("Failed ".$stmt->error);
			}
		}
	}

	function deleteReaction($user,$prayerKey) {

		$sql = "DELETE FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);

		if (!stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$prayerKey,$user);
			$stmt->execute();
		}
	}

	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	* 
	* Differentiate from followed & following
	* and in relation to who has been blocked
	*		1 - You're being followed
	*		2 - Friends
	*       3 - You've been blocked
	*		4 - You're following
	*		5 - You're blocking
	*/

	function updateRelationship($follower,$followee,$relType) {

		$stmt="";


		if ($relType==1 || $relType==3 || $relType==5) {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) VALUES (?,?,?)");
			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("ssi",$follower,$followee,$relType);
			}
		} else if ($relType==2 || $relType==0 || $relType==4) {

			//Unfollowing a friend
			if($relType==0) {
				$relType = 1;
			} else if ($relType==4) {
				$relType = 3;
			}

			$stmt = $this->conn->prepare("UPDATE connection SET followType=? WHERE follower=? AND followee=?");
			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("iss",$relType,$follower,$followee);
			}
		}

		if (!$stmt) {
			error_log("Prepare failed");
		} else {
			if($stmt->execute()) {
				error_log("Success");
			} else {
				error_log("Failed");
			}
		}
	}

	//Delete relationship
	function removeRelationship($follower,$followee) {
		$sql = "DELETE FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		if(!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$follower,$followee);
			$stmt->execute();
		}
		return $stmt->get_result();
	}

	/*====================================================================================
	* =                               Prayer Functions
	* ====================================================================================
	*/

	//Add prayer metadata
	function addPrayer($user,$postDate,$key) {

		$sql = "INSERT INTO prayer(userkey,postdate,prayerkey) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("sss",$user,$postDate,$key);
		
			if($stmt->execute()) {
				error_log("Success");
			} else {
				error_log("Failure: ".$stmt->error);
			}
		}
	}
}

/* 14 July 2025 - Created file
 * 19 July 2025 - Updated includes for handler
 *				- Added reaction queries
 * 25 July 2025 - Added relationship functions
 * 21 October 2025 - Added the prayer function
 * 10 November 2025 - Added error handling for failed prepares
*/
?>