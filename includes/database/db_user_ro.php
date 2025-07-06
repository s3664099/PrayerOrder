<?php
/*
File: PrayerOrder read user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 6 July 2025
Version: 1.1
*/

include '../database/db_handler.php';

class db_user_ro {

	private $db;
	private $conn;

	function __construct() {
		$this->db = new db_handler('../database/db_user_ro.json');
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
	}


	function checkValue($var,$value) {

		$value_exists = false;
		$sql = "SELECT * FROM user WHERE email=?";

		if ($var=="phone") {
			$sql = "SELECT * FROM user WHERE phone=?";
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$value);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$value_exists = true;
		}

		return $value_exists;
	}
}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
*/
?>