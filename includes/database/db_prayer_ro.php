<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 14 July 2025
Version: 1.0
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

		$sql = "SELECT postdate,prayerkey,userKey 
				FROM prayer 
				JOIN connection 
				  ON (
					 (connection.follower = ? AND connection.followType IN ('1','2'))
					 OR
					 (connection.followee = ? AND connection.followType IN ('2')))";

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$user,$user);
		$stmt->execute();

		$result = $stmt->get_result();

		foreach($result as $x) {
			error_log($x);
		}

		return $result;
	}

}

/* 14 July 2025
*/
?>