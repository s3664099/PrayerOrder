<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 16 July 2025
Version: 1.2
*/

include_once 'db_handler.php';

class db_prayer_ro {

	private $db;
	private $conn;

	function __construct() {
		$this->db = new db_handler('includes/database/db_prayer_ro.json');
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
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

	//Reaction
	function countReaction($prayerKey,$react) {
		
		$sql = "SELECT COUNT(*) FROM reaction WHERE prayerkey = ? AND reaction = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$react);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

}

/* 14 July 2025 - Created File
 * 15 July 2025 - Updated SQL to only retrieve prayers from people who you are following, or are friends with
 * 16 July 2025 - Added count prayer reaction sql function
*/
?>