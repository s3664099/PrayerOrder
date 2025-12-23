<?php
/*
File: PrayerOrder write to user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 23 December 2025
Version: 1.7

Limit size of phone to what db will allow
*/

include_once '../database/db_handler.php';

$USER_ID = 'id';

class db_user_rw {

	private $db;
	private $conn;

	function __construct() {

		try {
			$this->db = new db_handler(__DIR__ . '/../database/db_user_rw.json');
			$this->conn = $this->db->get_connection();
		} catch (Exception $e) {
            error_log("DB init failed: " . $e->getMessage());
            throw $e;
        }
	}

	private function begin() {
 	   $this->conn->begin_transaction();
	}

	private function commit() {
    	$this->conn->commit();
	}

	private function rollback() {
    	$this->conn->rollback();
	}

	function add_user($user_id, $name,$email,$phone,$password) {

		$success = false;
		$this->begin();

		try {
			$stmt = $this->conn->prepare("INSERT INTO user (id, name, email, phone, password) VALUES (?,?,?,?,?)");
		
			if (!$stmt) {
	            throw new Exception("Prepare failed: " . $this->conn->error);
	        }

			$stmt->bind_param("sssss",$user_id,$name, $email , $phone, $password);
			
			if (!$stmt->execute()) {
        	    throw new Exception($stmt->error);
        	}
        	error_log("success");
        	$success = true;
        	$this->commit();
			$stmt->close();
		} catch (Throwable $e) {
			$this->rollback();
			error_log("Add user failed: ".$e->getMessage());
		}

		return $success;
	}
}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
 * 7 July 2025 - Changed name of class
 * 28 October 2025 - Fixed issues with code
 * 30 October 2025 - Updated code based on recommendations
 * 9 November 2025 - Polished class
 * 9 December 2025 - Added constant for id title column
 * 23 December 2025 - Added transactions
*/
?>