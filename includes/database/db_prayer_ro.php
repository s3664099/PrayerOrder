<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 22 July 2025
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


class db_prayer_ro {

	private $db;
	private $conn;
	
	function __construct() {

		if(file_exists('../database/db_prayer_ro.json')) {
			$this->db = new db_handler('../database/db_prayer_ro.json');
		} else {
			$this->db = new db_handler('includes/database/db_prayer_rw.json');
		}
		
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_prayer");
	}

	function getPrayer($user) {

		$sql = "SELECT postdate,prayerkey,userKey,MIN(connection.followType) as followType
				FROM prayer 
				JOIN connection 
				  ON (
					 (connection.follower = ? AND connection.followType IN ('1'))
					 OR
					 (connection.followee = ? AND connection.followType IN ('2'))
				  )
				GROUP BY postdate, prayerkey, userKey";

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$user,$user);
		$stmt->execute();

		$result = $stmt->get_result();

		return $result;
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	//Check if the user has reacted to the prayer
	function checkReaction($user,$prayerKey) {

		$exists = 0;

		$sql = "SELECT * FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$user);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			$exists=$row['reaction'];
		}
		return $exists;
	}

	//Count the number of specific reactions to a prayer
	function countReaction($prayerKey,$react) {
		
		$sql = "SELECT COUNT(*) FROM reaction WHERE prayerkey = ? AND reaction = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$react);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
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
	*		4 - Your following
	*		5 - Your blocking
	*/

	function getRelationship($follower,$followee) {

		$sql = "SELECT followType FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();
		
		return $stmt->get_result();
	}

}

/* 14 July 2025 - Created File
 * 15 July 2025 - Updated SQL to only retrieve prayers from people who you are following, or are friends with
 * 16 July 2025 - Added count prayer reaction sql function
 * 19 July 2025 - Added query to check if the user has reacted to the prayer
 * 22 July 2025 - Added the check relationship query for user search
*/
?>