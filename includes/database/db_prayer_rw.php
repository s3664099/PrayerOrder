<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 19 July 2025
Version: 1.1
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
		$this->conn->query("USE po_prayer");
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	function addReaction($user,$prayerKey,$reaction) {

		$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			error_log("Failed to prepare statement: " . $this->conn->error);
			return false;
		}

		$stmt->bind_param("sss",$prayerKey,$user,$reaction);
		
		if (!$stmt->execute()) {
			error_log("Failed to execute statement: " . $stmt->error);
			return false;
		}

		if (!$stmt->execute()) {
			error_log("Failed ".$stmt->error);
		}

	}

	function updateReaction($user,$prayerKey,$reaction) {

		$sql = "UPDATE reaction SET reaction = ? WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$reaction,$prayerKey,$user);
		
		if (!$stmt->execute()) {
			error_log("Failed ".$stmt->error);
		}

	}

	function deleteReaction($user,$prayerKey) {

		$sql = "DELETE FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$user);
		$stmt->execute();

	}
}

/* 14 July 2025 - Created file
 * 19 July 2025 - Updated includes for handler
*/
?>