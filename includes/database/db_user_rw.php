<?php
/*
File: PrayerOrder write to user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 28 October 2025
Version: 1.3

Move the "USE po_user" to json file and call it from there.
'../database/db_user_rw.json' should come from next class
*/

include_once '../database/db_handler.php';

class db_user_rw {

	private $db;
	private $conn;

	function __construct() {

		try {
			$this->db = new db_handler('../database/db_user_rw.json');
			$this->conn = $this->db->get_connection();
			$this->conn->query("USE po_user");
		} catch (Exception $e) {
            error_log("DB init failed: " . $e->getMessage());
            throw $e;
        }
	}


	function add_user($name,$email,$phone,$password) {

		$success = null;

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            	throw new Exception("Invalid email format");
        }

		$password = password_hash($password, PASSWORD_DEFAULT);
		$user_id = bin2hex(random_bytes(16));

		$stmt = $this->conn->prepare("INSERT INTO user (id, name, email, phone, password) VALUES (?,?,?,?,?)");
		
		if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            $success = false;
        } else {

			$stmt->bind_param("sssss",$user_id,$name, $email , $phone, $password);
			$success = $stmt->execute();
			
			if (!$success) {
            	error_log("Execute failed: " . $stmt->error);
        	}

			$stmt->close();
			return $success;
		}
	}
}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
 * 7 July 2025 - Changed name of class
 * 28 October 2025 - Fixed issues with code
*/
?>