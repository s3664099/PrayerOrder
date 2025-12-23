<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 23 December 2025
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

class db_prayer_ro {

	private $db;
	private $conn;

	private const REL_NONE = 0;
	private const REL_FOLLOWED = 1;
	private const REL_FRIENDS = 2;
	private const REL_BLOCKED = 3;
	private const REL_FOLLOWING = 4;
	private const REL_BLOCKING = 5;
	
	function __construct() {

		if(file_exists('../database/db_prayer_ro.json')) {
			$this->db = new db_handler('../database/db_prayer_ro.json');
		} else {
			$this->db = new db_handler('includes/database/db_prayer_ro.json');
		}
		
		$this->conn = $this->db->get_connection();
	}

	function get_prayers($user) {
		error_log("User ".$user);
		$result = [];
		$sql = "SELECT
    				p.postdate,
    				p.prayerkey,
    				p.userKey,
    				c.followType
				FROM prayer p
				LEFT JOIN connection c
    				ON c.followee = p.userKey
   					AND c.follower = ?
 				  	AND c.followType IN (2,4)
				WHERE
    				p.userKey = ?
    				OR c.followType IS NOT NULL
				ORDER BY p.postdate DESC;";

		$stmt = $this->conn->prepare($sql);
		
		if(!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$user,$user);
			if(!$stmt->execute()){
				error_log("Query failed: " . $stmt->error);
			} else {
				$result = $stmt->get_result();
			}
			$stmt->close();
		}

		return $result;
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	//Check if the user has reacted to the prayer
	function check_reactions($user,$prayerKey) {

		$exists = 0;

		$sql = "SELECT * FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$prayerKey,$user);
			if (!$stmt->execute()){
				error_log("Query failed: " . $stmt->error);
			} else {
				$result = $stmt->get_result();

				if ($row = $result->fetch_assoc()) {
					$exists=$row['reaction'];
				}
			}
			$stmt->close();
		}

		return $exists;
	}

	//Count the number of specific reactions to a prayer
	function count_reactions($prayerKey,$react) {
		$result = [];
		$sql = "SELECT COUNT(reaction) FROM reaction WHERE prayerkey = ? AND reaction = ?";
		$stmt = $this->conn->prepare($sql);

		if(!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$prayerKey,$react);

			if(!$stmt->execute()){
				error_log("Query failed: " . $stmt->error);
			} else {
				$result = $stmt->get_result()->fetch_assoc();
			}
			$stmt->close();
		}

		return $result;
	}

	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	*/

	function get_relationship($follower,$followee) {

		$result = [];
		$sql = "SELECT followType FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$follower,$followee);
			if (!$stmt->execute()) {
				error_log("Query failed: " . $stmt->error);
			} else {
				$result = $stmt->get_result();
			}
			$stmt->close();
		}
		
		return $result;
	}
}

/* 14 July 2025 - Created File
 * 15 July 2025 - Updated SQL to only retrieve prayers from people who you are following, or are friends with
 * 16 July 2025 - Added count prayer reaction sql function
 * 19 July 2025 - Added query to check if the user has reacted to the prayer
 * 22 July 2025 - Added the check relationship query for user search
 * 21 October 2025 - Ordered prayers by date descending
 * 11 November 2025 - Added error handling
 * 22 November 2025 - Changed function names for consistency
 * 9 December 2025 - Added constant for relationship type column name
 * 12 December 2025 - Removed FOLLOW_TYPE constant
 * 23 December 2025 - Fixed query for requesting prayers.
*/
?>