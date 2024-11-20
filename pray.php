<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 16 September 2024
Version: 0.0
*/

session_start();

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$name = $_SESSION['user'];
	$d=mktime(11, 14, 54, 8, 12, 2014);
	$posted = date("Y-m-d h:i:sa", $d);
	$prayer = $_POST['prayer'];
	$key = hash("sha256",$name.$posted);

	$prayerDetails = new stdClass();
	$prayerDetails->name = $name;
	$prayerDetails->date = $posted;
	$prayerDetails->prayer = $prayer;

	$prayerJSON = new stdClass();
	$prayerJSON->$key = json_encode($prayerDetails);

	error_log(json_encode($prayerJSON));

	//Save into json file (then into a noSQL db)

	header("Location: main.php");
}

/* 16 November 2024 - Created File
*/
?>