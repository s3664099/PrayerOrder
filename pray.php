<?php
/*
File: PrayerOrder Submit Prayer Program
Author: David Sarkies 
Initial: 16 November 2024
Update: 16 September 2024
Version: 0.0
*/

include 'db_functions.php';

session_start();

$db = new db_functions();

//Checks if the user has submitted a prayer
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$name = $_SESSION['user'];
	$d=mktime(11, 14, 54, 8, 12, 2014);
	$posted = date("Y-m-d h:i:s", $d);
	$prayer = $_POST['prayer'];
	$key = hash("sha256",$name.$posted);

	$prayerDetails = new stdClass();
	$prayerDetails->$key = $prayer;

	$db->addPrayer($name,$posted,$key);


	$prayerJSON = json_encode($prayerDetails);



	

	//Save into json file (then into a noSQL db)

	header("Location: main.php");
}

/* 16 November 2024 - Created File
*/
?>