<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 13 November 2025
Version: 1.4
*/

	include_once '../database/db_user_ro.php';
	include_once '../database/db_user_rw.php';
	session_start();
	ob_start();

	$header_referral = "Location: ../../signup.php";
	$db_user_ro = new db_user_ro();
	$db_user_rw = new db_user_rw();

	$NAME_LENGTH = 50;
	$PHONE_LENGTH = 10;
	$EMAIL_LENGTH = 200;

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = substr($_POST['username'],0,$NAME_LENGTH)
		$email = substr($_POST['email'],0,$EMAIL_LENGTH)
		$phone = substr($_POST['phone'],0,$PHONE_LENGTH)
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$user_id = bin2hex(random_bytes(16));

		$_SESSION['signup_errors'] = [
    		'email_exists' => false,
    		'phone_exists' => false,
    		'invalid_email' => false,
    		'signup_fail' => false
		];

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 	 		$emailErr = "Invalid email format";
 	 		$_SESSION['signup_errors']['invalid_email'] = true;
 	 		$_SESSION['value'] = true;
		} else {

			//Saves it in the database and then returns to the index
			$_SESSION['value'] = false;

			//Check if phone & email are already used - returns error if it has
			if ($db_user_ro->checkValue("email",$email)) {
				$_SESSION['value'] = true;
				$_SESSION['signup_errors']['email_exists'] = true;
			}

			if ($db_user_ro->checkValue("phone",$phone)) {
				$_SESSION['value'] = true;
				$_SESSION['signup_errors']['phone_exists'] = true;
			}

			if($_SESSION['value']==false) {

				unset($_SESSION['value']);
				$_SESSION['signup_success'] = $db_user_rw->add_user($user_id,$name,$email,$phone,$password);

				if($_SESSION['signup_success']) {
					unset($_SESSION['signup_errors']);
					$header_referral = "Location: ../../signin.php";
				} else {
					$_SESSION['signup_errors']['signup_fail'] = true;
				}
			}
		}
	}
	header($header_referral);

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