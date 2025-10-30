<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 30 October 2025
Version: 1.2

- Add Note when sign up success

*/

	include_once '../database/db_user_ro.php';
	include_once '../database/db_user_rw.php';
	session_start();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$user_id = bin2hex(random_bytes(16));

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 	 		$emailErr = "Invalid email format";
 	 		$_SESSION['email_fail'] = true;
 	 		$_SESSION['value'] = true;
 	 		header("Location: ../../signup.php");
		} else {

			//Saves it in the database and then returns to the index
			$db = new db_user_ro();
			$_SESSION['value'] = false;

			//Check if phone & email are already used - returns error if it has
			if ($db->checkValue("email",$email)) {
				$_SESSION['value'] = true;
				$_SESSION['email_exists'] = true;
			}

			if ($db->checkValue("phone",$phone)) {
				$_SESSION['value'] = true;
				$_SESSION['phone_exists'] = true;
			}

			if($_SESSION['value']==false) {

				unset($_SESSION['value']);
				$db = new db_user_rw();
				$_SESSION['signup_success'] = $db->add_user($id,$name,$email,$phone,$password);

				if($_SESSION['signup_success']) {
					header("Location: ../../signin.php");
					unset($_SESSION['signup_success']);
				} else {
					header("Location: ../../signup.php");
					$_SESSION['value'] = true;
				}
			} else {
				header("Location: ../../signup.php");
			}
		}
	}

/*
7 February 2024 - Created File
5 December 2024 - Increased version
19 April 2025 - Moved dabatase file
30 October 2025 - Moved hash pw and id creation here.
				- Fixed so failure to sign in displays
*/
?>