<?php
/*
File: PrayerOrder prayer services page
Author: David Sarkies 
#Initial: 23 December 2025
#Update: 30 December 2025
#Version: 1.5
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

	function count_reaction($reactType,$x) {

		$react_count = "";
		$result = $this->db_prayer_ro->count_reactions($x['prayerkey'],$reactType);

		if (is_array($result) || !empty($result)) {
			 
			$count = (int) array_values($result)[0];
        	if ($count > 0) {
            	$react_count = (string) $count;
        	}
		}

		return $react_count;
	}

	function check_reaction($user,$prayerKey) {
		$result = $this->db_prayer_ro->check_reactions($user, $prayerKey);
    	return (int) $result;
	}

	function formate_time_ago($pastdate) {

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


    function react() {
		$input = json_decode(file_get_contents("php://input"), true);

		if (isset($input['react'])) {

	    	$reaction = $this->db_prayer_ro->check_reactions($_SESSION['user'],$input['id']);

	    	//There is no recorded reaction (reaction = 0)
	    	if ($reaction == 0) {
	    		$this->db_prayer_rw->add_reaction($_SESSION['user'],$input['id'],$input['react']);
	    	} else if ($reaction != $input['react'] && $input['react'] !=0) {
	    		$this->db_prayer_rw->update_reaction($_SESSION['user'],$input['id'],$input['react']);
	    	} else {
	    		$this->db_prayer_rw->delete_reaction($_SESSION['user'],$input['id']);
	    	}

		} else {
		    error_log("Missing POST parameter");
		}
    }

    function add_prayer($prayer,$name) {
    	
    	$header = "Location: ../../main.php";
		if (strlen($prayer) == 0) {
			$header = $header."#blank";
		} else {
			$d=time();
			$posted = date("Y-m-d H:i:s", $d);
			$key = hash("sha256",$name.$posted);
			$db_prayer_rw->addPrayer($name,$posted,$key);

			//Save into json file (then into a noSQL db)
			$this->prayer_array[$key] = $prayer;
			$jsonData = json_encode($this->prayer_array);
			file_put_contents(__DIR__ ."/prayer_data.json", $jsonData);
		}
    }
}

/*
23 December 2025 - Created File
24 December 2025 - Fixed errors
26 December 2025 - Added rection functions
27 December 2025 - Moved date_diff here.
				 - Started fixing code per ChatGPT
28 December 2025 - Added reaction function
30 December 2025 - Added function to add prayer
*/
?>