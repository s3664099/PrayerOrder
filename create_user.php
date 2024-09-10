<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 7 February 2024
Version: 0.0
*/

	include 'db_functions.php';
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
 	 		header("Location: signup.php");
		} else {

			//Saves it in the database and then returns to the index
			$db = new db_functions();

			//Check if phone & email are already used - returns error if it has
			$db->add_user($name,$email,$phone,$password);
			header("Location: signin.php");
		}
	}

/*
7 February 2024 - Created File
*/
?>