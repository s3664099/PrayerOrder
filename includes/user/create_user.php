<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 13 November 2025
Version: 1.4
*/


session_start();
ob_start();

$header_referral = "Location: ../../signin.php";
require_once 'signup_services.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$name = substr($_POST['username'],0,$NAME_LENGTH);
	$email = substr($_POST['email'],0,$EMAIL_LENGTH);
	$phone = substr($_POST['phone'],0,$PHONE_LENGTH);
	$password = $_POST['password'];

	$_SESSION['signup_errors'] = false;

	$result = SignupService::registerUser($name, $email, $phone, $password);

	if($result) {
		$_SESSION['signup_errors'] = true;
		$header_referral = "Location: ../../signup.php";
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
*/
?>