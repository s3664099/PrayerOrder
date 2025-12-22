<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 21 December 2025
Version: 1.10
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

		$this->begin();
		$success = false;

		$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES (?,?,?)";

		try {
			$stmt = $this->conn->prepare($sql);
		

			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("sss",$prayerKey,$user,$reaction);

				if (!$stmt->execute()) {
					error_log("Failed ".$stmt->error);
				} else {
					$this->commit();
					$success = true;
				}
				$stmt->close();
			}
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Add reaction failed: ".$e->getMessage());
		}
		return $success;
	}

	function update_reaction($user,$prayerKey,$reaction) {

		$this->begin();
		$success = false;
		$sql = "UPDATE reaction SET reaction = ? WHERE prayerkey = ? AND reactor = ?";
		
		try {
			$stmt = $this->conn->prepare($sql);

			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("sss",$reaction,$prayerKey,$user);
		
				if (!$stmt->execute()) {
					error_log("Failed ".$stmt->error);
				} else {
					$this->commit();
					$success = true;
				}
				$stmt->close();
			}
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Update reaction failed: ".$e->getMessage());
		}
		return $success;
	}

	function delete_reaction($user,$prayerKey) {

		$this->begin();
		$success = false;
		$sql = "DELETE FROM reaction WHERE prayerkey = ? AND reactor = ?";

		try {
			$stmt = $this->conn->prepare($sql);

			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("ss",$prayerKey,$user);

				if (!$stmt->execute()) {
					error_log("Failed ".$stmt->error);
				} else {
					$this->commit();
					$success = true;
				}
				$stmt->close();
			}
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Update reaction failed: ".$e->getMessage());
		}

		return $success;
	}

	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	*/


	function add_relationship($follower,$followee,$follow_type,$reverse_follow_type) {
		$stmt = "";
		$success = false;
		$this->begin();

		try {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) 
											VALUES (?,?,?),(?,?,?)");
			if (!$stmt) {
				error_log("Prepare failed: ".$this->conn->error);
			} else {
				$stmt->bind_param("ssissi",$follower,$followee,$follow_type,$followee,$follower,$reverse_follow_type);

				if($stmt->execute()) {
					error_log("Success");
					$success = true;
					$this->commit();
				} else {
					error_log("Failure: ".$stmt->error);
				}
			}
			$stmt->close();
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Add relationship failed: ".$e->getMessage());
		}
		
		return $success;
	}

	function update_relationship($follower,$followee,$follow_type,$reverse_follow_type) {
		$stmt = "";
		$success = false;
		$this->begin();

		try {
			$stmt = $this->conn->prepare("UPDATE connection 
										  SET followType = CASE
										  		WHEN follower=? AND followee=? THEN ?
										  		WHEN follower=? AND followee=? THEN ?
										  END 
										  WHERE 
										  		(follower=? AND followee=?)
										  	OR  (follower=? AND followee=?)");
			if (!$stmt) {
				error_log("Prepare failed: ".$this->conn->error);
			} else {
				$stmt->bind_param("ssississss",$follower,$followee,$follow_type,
											   $followee,$follower,$reverse_follow_type,
											   $follower,$followee,
											   $followee,$follower);

				if($stmt->execute()) {
					error_log("Success");
					$success = true;
					$this->commit();
				} else {
					error_log("Failure: ".$stmt->error);
				}
			}
			$stmt->close();
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Update relationship failed: ".$e->getMessage());
		}
		return $success;
	}

	function remove_relationship($follower,$followee) {
		$stmt = "";
		$success = false;
		$this->begin();

		try {
			$stmt = $this->conn->prepare("DELETE FROM connection 
										  WHERE 
										  		(follower=? AND followee=?)
										  	OR (follower=? AND followee=?)");
			if (!$stmt) {
				error_log("Prepare failed: ".$this->conn->error);
			} else {
				$stmt->bind_param("ssss",$follower,$followee,$followee,$follower);

				if($stmt->execute()) {
					error_log("Success");
					$success = true;
					$this->commit();
				} else {
					error_log("Failure: ".$stmt->error);
				}
			}
			$stmt->close();
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Delete relationship failed: ".$e->getMessage());
		}
		return $success;
	}

	/*====================================================================================
	* =                               Prayer Functions
	* ====================================================================================
	*/

	//Add prayer metadata
	function add_prayer($user,$postDate,$key) {

		$this->begin();
		$success = false;

		try {
			$sql = "INSERT INTO prayer(userkey,postdate,prayerkey) VALUES (?,?,?)";
			$stmt = $this->conn->prepare($sql);

			if (!$stmt) {
				error_log("Prepare failed: " . $this->conn->error);
			} else {
				$stmt->bind_param("sss",$user,$postDate,$key);
		
				if($stmt->execute()) {
					error_log("Success");
					$success = true;
					$this->commit();
				} else {
					error_log("Failure: ".$stmt->error);
				}
				$stmt->close();
			} catch (Throwable $e) {
				$this->rollback();
				error_log("Add prayer failed: ".$e->getMessage());
			}

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
 * 12 December 2025 - Removed FOLLOW_TYPE constant
 * 15 December 2025 - Changed functions for relationships
 * 16 December 2025 - Completed different functions for relationships
 * 20 December 2025 - Changed SQL so only one read to DB at a time.
 * 23 December 2025 - Added transactions
*/
?>