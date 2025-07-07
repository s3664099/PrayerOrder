<?php
/*
File: PrayerOrder write to user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 7 July 2025
Version: 1.2

*/

include_once '../database/db_handler.php';

class db_user_rw {

	private $db;
	private $conn;

	function __construct() {
		echo "test";
		$this->db = new db_handler('../database/db_user_rw.json');
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
	}


	function add_user($name,$email,$phone,$password) {

		$password = hash("sha256",$password.$email);
		$user_id = uniqid();

		$stmt = $this->conn->prepare("INSERT INTO user (id, name, email, phone, password) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssss",$user_id,$name, $email , $phone, $password);
		$stmt->execute();
	}

}

/* 6 July 2025 - Created File
 *			   - Fixed error so now reading and writing to user DB
 * 7 July 2025 - Changed name of class
*/
?>