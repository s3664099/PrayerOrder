<?php
/*
File: PrayerOrder write to user db
Author: David Sarkies 
Initial: 6 July 2025
Update: 6 July 2025
Version: 1.0

- Create read_user_db
- Create write_user_db

*/

include 'db_handler.php';

class db_user_ro {

	private $db;
	private $conn;

	function __construct() {
		$this->$db = new db_handler('db_user_rw.json');
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
*/
?>