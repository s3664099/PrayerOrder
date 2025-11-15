<?php
/*
File: PrayerOrder Authenticate Include
Author: David Sarkies 
Initial: 7 February 2024
Update: 15 November 2025
Version: 1.4
*/

require_once __DIR__ . '/auth_services.php';

session_start();
$header = "Location: ../../signin.php";

$auth_service = new authServices();

//Checks if it is a sign-in function
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['type']) && $_POST['type'] == 'signin') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	if ($auth_service->authenticate_user($email,$password)) {

		$user_details = $auth_service->get_user_details($email);

		$_SESSION['name'] = $user_details['name'];
		$_SESSION['user'] = $user_details['id'];
		$header = "Location: ../../main.php";
	
	} else {
		$_SESSION['failed'] = true;
	}
}

//Checks if calling a sign-out finction
if (isset($_POST['action']) && $_POST["action"] === "sign_out") {
	session_destroy();
} 
header($header);

/*
7 February 2024 - Created File
25 February 2024 - Created basic authentication
4 July 2024 - Added session to set login failed.
15 September 2024 - Added call to retrieve user name from database
5 December 2024 - Increased version
19 April 2025 - Moved DB functions. Updated locations of files.
8 July 2025 - Shifted authentication to new dbs.
14 July 2025 - Changed user from email to id
15 November 2025 - Moved authentication to separate file
*/
?>