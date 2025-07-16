<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 16 July 2025
Version: 1.6
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_functions.php';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_prayer_ro.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/database/db_user_ro.php';

session_start();

$db = new db_functions();

function getPrayers($user) {
	$db = new db_prayer_ro();
	return $db->getPrayer($user);
}

function getUser($id) {
	$db = new db_user_ro();
	return $db->getPrayerUser($id);
}

function getInvites($user) {
	$db = new db_functions();
	return $db->getInvites($user);
}

function getPrayer($prayerKey) {

	// Read the JSON file
    $jsonData = file_get_contents(__DIR__ ."/prayer_data.json");
    
    // Decode JSON into an associative array
    $prayerArray = json_decode($jsonData, true);
    
    // Check if the key exists and return the corresponding prayer
    if (array_key_exists($prayerKey, $prayerArray)) {
        return $prayerArray[$prayerKey];
    } else {
        return false;
    }
}

function countReaction($reactType,$x) {

	$db = new db_prayer_ro();
	$reactCount = "";
	$pray_count = implode('',$db->countReaction($x['prayerkey'],$reactType));

	if ($pray_count>0) {
		$reactCount = $pray_count;
	}

	return $reactCount;

}

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$header = "Location: ../../main.php";
	$prayer = $_POST['prayer'];

	if (strlen($prayer) == 0) {
		$header = $header."#blank";
	} else {

		$name = $_SESSION['user'];
		$d=time();
		$posted = date("Y-m-d h:i:s", $d);
		
		$key = hash("sha256",$name.$posted);
		$db->addPrayer($name,$posted,$key);

		//Save into json file (then into a noSQL db)
		$inp = file_get_contents(__DIR__ .'/prayer_data.json');
		$tempArray = json_decode($inp,true);
		$tempArray[$key] = $prayer;
		$jsonData = json_encode($tempArray);
		file_put_contents(__DIR__ ."/prayer_data.json", $jsonData);
	}

	header($header);
}

/* 16 November 2024 - Created File
 * 21 November 2024 - Updated code to record prayer metadata and send it to db
 * 1 December 2024 - Added function to load prayers from JSON file based on key
 * 5 December 2024 - Increased version
 * 18 March 2025 - Fixed issue with prayers not appending to JSON file.
 * 11 April 2025 - Fixed problem with saving prayers
 * 19 April 2025 - Moved database file. Fixed issue with locating the db file.
 * 15 May 2025 - Added function call to retrieve invites
 * 15 July 2025 - Added the function to retrieve the user details for prayers
 * 16 July 2025 - Moved count prayer reaction function here
*/
?>