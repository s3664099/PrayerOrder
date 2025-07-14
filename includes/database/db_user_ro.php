<?php
/*
File: PrayerOrder read user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 14 July 2025
Version: 1.3
*/

include_once '../database/db_handler.php';

class db_user_ro {

	private $db;
	private $conn;

	function __construct() {
		$this->db = new db_handler('../database/db_user_ro.json');
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
	}

	function authenticate_user($email,$password) {

		$authenticated = False;
		$hashedPwd = hash("sha256",$password.$email);

		$sql = "SELECT * FROM user WHERE email=? AND password=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$hashedPwd);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows == 1) {
			$authenticated = True;
		}

		return $authenticated;
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

	function getUserName($email) {

		$sql = "SELECT name FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();
		$userName = $result->fetch_assoc()['name'];

		return $userName;
	}

	//Also retrieve photo

	function getUserDetails($email) {

		$sql = "SELECT name,id FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();
	}
}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
 * 7 July 2025 - Fixed multiple includes
 * 8 July 2025 - Added getUserName and authenticate user functions
 * 14 July 2025 - Change user retrieval function to get details
*/
?>