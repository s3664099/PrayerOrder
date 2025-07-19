<?php
/*
File: PrayerOrder read prayer db
Author: David Sarkies 
Initial: 14 July 2025
Update: 14 July 2025
Version: 1.0
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

class db_prayer_rw {

	private $db;
	private $conn;

	function __construct() {
		
		if(file_exists('../database/db_prayer_ro.json')) {
			$this->db = new db_handler('../database/db_prayer_ro.json');
		} else {
			$this->db = new db_handler('includes/database/db_prayer_rw.json');
		}
		
		$this->conn = $this->db->get_connection();
		$this->conn->query("USE po_user");
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

}

/* 14 July 2025
*/
?>