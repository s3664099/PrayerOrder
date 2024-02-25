<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 25 February 2024
Version: 0.1
*/
	session_start();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (($email == "dude@dude.com") && ($password == "PooPoo")) {
			echo "Sign in success";
			$_SESSION['user'] = $email;
			header("Location: main.php");
		} else {
			header("Location: signin.php");
		}
	}

/*
7 February 2024 - Created File
25 February 2024 - Created basic authentication
*/
?>