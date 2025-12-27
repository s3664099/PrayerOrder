<?php
/*
File: PrayerOrder prayer services page
Author: David Sarkies 
#Initial: 23 December 2025
#Update: 26 December 2025
#Version: 1.3
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
    	
    	if ($jsonData === false) {
    		$this->prayer_array = [];
		} else {
    		$decoded = json_decode($jsonData, true);
    		$this->prayer_array = is_array($decoded) ? $decoded : [];
		}
	}

	function get_prayers($user_id) {
		return $this->db_prayer_ro->get_prayers($user_id);
	}

	function get_user($user_id) {
		return $this->db_user_ro->get_prayer_user($user_id);
	}

	function get_prayer(string $prayer_key): ?string {
    
		return $this->prayer_array[$prayer_key] ?? null;
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

	function date_diff($pastdate) {

		$currDate = new DateTime();
		$date = "";

		// Calculate the difference
		$date_diff = $currDate->diff($pastdate);


		// Determine the most significant unit
		if ($date_diff->y > 0) {
    		$date = $date_diff->y . " year" . ($date_diff->y > 1 ? "s" : "") . " ago";
		} elseif ($date_diff->m > 0) {
    		$date = $date_diff->m . " month" . ($date_diff->m > 1 ? "s" : "") . " ago";
		} elseif ($date_diff->d > 0) {
    		$date = $date_diff->d . " day" . ($date_diff->d > 1 ? "s" : "") . " ago";
		} elseif ($date_diff->h > 0) {
    		$date = $date_diff->h . " hour" . ($date_diff->h > 1 ? "s" : "") . " ago";
		} elseif ($date_diff->i > 0) {
    		$date = $date_diff->i . " minute" . ($date_diff->i > 1 ? "s" : "") . " ago";
		} else {
    		$date = "Just now";
		}

		return $date;
	}
}

/*
23 December 2025 - Created File
24 December 2025 - Fixed errors
26 December 2025 - Added rection functions
27 December 2025 - Moved date_diff here.
				 - Started fixing code per ChatGPT
*/
?>