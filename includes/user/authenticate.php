<?php
/*
File: PrayerOrder Authenticate Include
Author: David Sarkies 
Initial: 7 February 2024
Update: 19 April 2025
Version: 1.1
*/
include '../database/db_functions.php';

session_start();

//Checks if it is a sign-in function
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['type']) && $_POST['type'] == 'signin') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$db = new db_functions();
	
	if ($db->authenticate_user($email,$password)) {

		$_SESSION['name'] = $db->getUserName($email);
		$_SESSION['user'] = $email;
		header("Location: ../../main.php");
	
	} else {
		$_SESSION['failed'] = true;
		header("Location: ../../signin.php");
	}
}

//Checks if calling a sign-out finction
if (isset($_POST['action']) && $_POST["action"] === "sign_out") {
	session_destroy();
} 

/*
7 February 2024 - Created File
25 February 2024 - Created basic authentication
4 July 2024 - Added session to set login failed.
15 September 2024 - Added call to retrieve user name from database
5 December 2024 - Increased version
19 April 2025 - Moved DB functions. Updated locations of files.
*/
?>