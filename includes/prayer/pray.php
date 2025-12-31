<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 31 December 2025
Version: 1.12
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/prayer/prayer_services.php';

session_start();

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$prayer_service = new prayer_services();

	$header = "Location: ../../main.php";

	if (!$prayer_service->add_prayer($_POST['prayer'],$_SESSION['user'])) {
		$header = $header."#blank";
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
 * 19 July 2025 - Added function call to check the existence of the reaction
 * 21 October 2025 - Added the prayer function
 *				   - Updated for 24 Hr time
 * 23 December 2025 - Started moving code over to prayer services
 * 26 December 2025 - Removed reaction functions
 * 30 December 2025 - Moved add prayer code to prayer services
 * 31 December 2025 - Added header constructor
*/
?>