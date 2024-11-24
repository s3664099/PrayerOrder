<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 21 November 2024
Version: 0.1
*/

include 'db_functions.php';

session_start();

$db = new db_functions();

function getPrayers($user) {

	$db = new db_functions();

	$result = $db->getPrayer($user);

	foreach ($result as $x) {
		error_log(implode(",",$x)."\n");
	}
}

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$header = "Location: main.php";
	$prayer = $_POST['prayer'];

	error_log(strlen($prayer));

	if (strlen($prayer) == 0) {
		$header = $header."#blank";
	} else {

		$name = $_SESSION['user'];
		$d=time();
		$posted = date("Y-m-d h:i:s", $d);
		
		$key = hash("sha256",$name.$posted);

		$prayerDetails = new stdClass();
		$prayerDetails->$key = $prayer;

		#$db->addPrayer($name,$posted,$key);

		#$prayerJSON = json_encode($prayerDetails);

		//Save into json file (then into a noSQL db)
	}

	header($header);
}



/* 16 November 2024 - Created File
 * 21 November 2024 - Updated code to record prayer metadata and send it to db
*/
?>