<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 14 July 2025
Version: 1.0
*/

include_once '../database/db_handler.php';

class db_prayer_ro {

	private $db;
	private $conn;

	function __construct() {
		$this->db = new db_handler('../database/db_prayer_ro.json');
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
	}

}

/* 14 July 2025
*/
?>