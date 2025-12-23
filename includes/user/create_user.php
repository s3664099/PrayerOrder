<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 23 December 2025
Version: 1.6
*/


session_start();
ob_start();

$NAME_LENGTH = 50;
$PHONE_LENGTH = 10;
$EMAIL_LENGTH = 200;

$header_referral = "Location: ../../signin.php";
require_once 'signup_services.php';
$signup_service = new Signup_service();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$name = substr($_POST['username'],0,$NAME_LENGTH);
	$email = substr($_POST['email'],0,$EMAIL_LENGTH);
	$phone = substr($_POST['phone'],0,$PHONE_LENGTH);
	$password = $_POST['password'];

	$result =$signup_service->register_user($name, $email, $phone, $password);

	if(!$result) {
		$header_referral = "Location: ../../signup.php";
		$_SESSION['signup_failed'] = true;
	} else {
		$_SESSION['signup_success'] = true;
	}

	header($header_referral);
}

/*
7 February 2024 - Created File
5 December 2024 - Increased version
19 April 2025 - Moved dabatase file
30 October 2025 - Moved hash pw and id creation here.
				- Fixed so failure to sign in displays
11 November 2025 - Remove unset signup success so displays success
				 - Added single session flag for signup failures
13 November 2025 - Created one DB creation for DB types
				 - Added validations for name and phone
22 November 2025 - Updated function names for consitency
23 December 2025 - Removed static nature of signup_services
				 - added session for signup failure
*/
?>