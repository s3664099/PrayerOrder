<?php
/*
File: PrayerOrder read user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 9 December 2025
Version: 1.11
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

$USER_ID = 'id';

class db_user_ro {

	private $db;
	private $conn;

	function __construct() {

		try {
			if(file_exists(__DIR__.'/../database/db_user_ro.json')) {
				$this->db = new db_handler(__DIR__.'/../database/db_user_ro.json');
			} else {
				$this->db = new db_handler(__DIR__.'/../includes/database/db_user_ro.json');
			}

			$this->conn = $this->db->get_connection();
		} catch (Exception $e) {
            error_log("DB init failed: " . $e->getMessage());
            throw $e;
        }
	}

	function get_password($email) {

		$stored_password = null;
		$sql = "SELECT password FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$result = $stmt->get_result();

			if($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$stored_password = $row ? $row['password'] : null;
			}
		}
		$stmt->close();
		return $stored_password;
	}

	function check_value($var,$value) {

		$value_exists = false;
		$field = ($var === "phone") ? "phone" : "email";
		$sql = "SELECT 1 FROM user WHERE $field=?";

		$stmt = $this->conn->prepare($sql);
		IF (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("s",$value);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$value_exists = true;
			}
		}
		$stmt->close();
		return $value_exists;
	}

	function get_user_name($email) {

		$userName = null;
		$sql = "SELECT name FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$userName = $row ? $row['name'] : null;
		}
		$stmt->close();
		return $userName;
	}

	function get_user_details($email) {

		$details = null;
		$sql = "SELECT name,id FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$result = $stmt->get_result();
			$details = $result->fetch_assoc();
		}
		$stmt->close();

		return $details;
	}

	function get_prayer_user($id) {

		$users = null;
		$sql = "SELECT name,images FROM user WHERE id=?";
		$stmt = $this->conn->prepare($sql);
		if(!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("s",$id);
			$stmt->execute();
			$result = $stmt->get_result();
			$users = $result->fetch_assoc();
		}
		$stmt->close();

		return $users;
	}

	//Search function for users who haven't blocked user
	function get_users($name,$user) {

		$name = str_replace(['%','_'],['\%','\_'],$name);
		$name = "%$name%";
		$result = null;

    	$sql = "SELECT name, id
        	    FROM user
        	    WHERE name LIKE ? 
        	    	AND id != ? 
	            LIMIT 5";
		$stmt = $this->conn->prepare($sql);
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
		} else {
			$stmt->bind_param("ss",$name,$user);
			$stmt->execute();
			$result = $stmt->get_result();
		}
		$stmt->close();

		return $result;
	}
}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
 * 7 July 2025 - Fixed multiple includes
 * 8 July 2025 - Added getUserName and authenticate user functions
 * 14 July 2025 - Change user retrieval function to get details
 * 15 July 2025 - Added function to retrieve user details
 * 19 July 2025 - Added checks for including handler
 * 22 July 2025 - move search user function here
 * 29 October 2025 - Updated password verification
 * 9 November 2025 - Polished class and fixed errors
 * 15 November 2025 - Removed password verification
 * 22 November 2025 - Updated class names for consistency
 * 9 December 2025 - Added constant for id title column
*/
?>