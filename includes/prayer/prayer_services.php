<?php
/*
File: PrayerOrder prayer services page
Author: David Sarkies 
#Initial: 23 December 2025
#Update: 26 December 2025
#Version: 1.2
*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_ro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_rw.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_user_ro.php';

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
		return $this->db_prayer_ro->get_prayers($user_id);
	}

	function get_user($user_id) {
		return $this->db_user_ro->get_prayer_user($user_id);
	}

	function get_prayer($prayer_key) {
    
		$prayer = false;

 	   // Check if the key exists and return the corresponding prayer
 	   if (array_key_exists($prayer_key, $this->prayer_array)) {
 	       $prayer = $this->prayer_array[$prayer_key];
 	   }
 	      
 	   return $prayer;
	}

	function countReaction($reactType,$x) {

		$reactCount = "";
		$pray_count = implode('',$this->db_prayer_ro->count_reactions($x['prayerkey'],$reactType));

		if ($pray_count>0) {
			$reactCount = $pray_count;
		}

		return $reactCount;
	}

	function checkReaction($user,$prayerKey) {
		return $this->db_prayer_ro->check_reactions($user,$prayerKey);	
	}
}

/*
23 December 2025 - Created File
24 December 2025 - Fixed errors
26 December 2025 - Added rection functions
*/
?>