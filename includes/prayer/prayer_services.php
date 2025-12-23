<?php
/*
File: PrayerOrder prayer services page
Author: David Sarkies 
#Initial: 23 December 2025
#Update: 23 December 2025
#Version: 1.0
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_ro.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_rw.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_user_ro.php';

class prayer_services {
	private $db_user_ro;
	private $db_prayer_ro;
	private $db_prayer_rw;
	private $prayer_array;

	function __construct() {
		$this->db_user_ro = new db_user_ro();
		$this->db_prayer_ro = new db_prayer_ro();
		$this->db_prayer_rw = new db_prayer_rw();

		// Read the JSON file
    	$jsonData = file_get_contents(__DIR__ ."/prayer_data.json");
    
    	// Decode JSON into an associative array
    	$this->prayer_array = json_decode($jsonData, true);
	}

	function get_prayers($user_id) {
		return $db_prayer_ro->get_prayers($user_id);
	}

	function get_user($user_id) {
		return $db_user_ro->get_prayer_user($user_id);
	}
}

/*
23 December 2025 - Created File
*/
?>