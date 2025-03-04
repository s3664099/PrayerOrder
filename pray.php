<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 5 December 2024
Version: 1.0
*/

include 'db_functions.php';

$db = new db_functions();

function getPrayers($user) {

	$db = new db_functions();

	return $db->getPrayer($user);
}

function getPrayer($prayerKey) {

	// Read the JSON file
    $jsonData = file_get_contents("prayer_data.json");
    
    // Decode JSON into an associative array
    $prayerArray = json_decode($jsonData, true);
    
    // Check if the key exists and return the corresponding prayer
    if (array_key_exists($prayerKey, $prayerArray)) {
    	error_log("One");
        return $prayerArray[$prayerKey];
    } else {
        return false;
    }
}

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$header = "Location: main.php";
	$prayer = $_POST['prayer'];

	if (strlen($prayer) == 0) {
		$header = $header."#blank";
	} else {

		$name = $_SESSION['user'];
		$d=time();
		$posted = date("Y-m-d h:i:s", $d);
		
		$key = hash("sha256",$name.$posted);

		$prayerDetails = new stdClass();
		$prayerDetails->$key = $prayer;

		$db->addPrayer($name,$posted,$key);

		$prayerJSON = json_encode($prayerDetails);

		//Save into json file (then into a noSQL db)
		file_put_contents("prayer_data.json", $prayerJSON);
	}

	header($header);
}

/* 16 November 2024 - Created File
 * 21 November 2024 - Updated code to record prayer metadata and send it to db
 * 1 December 2024 - Added function to load prayers from JSON file based on key
 * 5 December 2024 - Increased version
*/
?>