<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 19 April 2024
Version: 1.1

- Create read_user_db
- Create write_user_db

*/

	include '../database/db_user_ro.php';
	session_start();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$password = $_POST['password'];

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 	 		$emailErr = "Invalid email format";
 	 		$_SESSION['email_fail'] = true;
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
				$db->add_user($name,$email,$phone,$password);
				header("Location: ../../signin.php");
			} else {
				header("Location: ../../signup.php");
			}
		}
	}

/*
7 February 2024 - Created File
5 December 2024 - Increased version
19 April 2025 - Moved dabatase file
*/
?>