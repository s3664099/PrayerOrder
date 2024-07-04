<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 4 July 2024
Version: 0.3
*/
include 'db_functions.php';

session_start();

print_r($_POST);

//Checks if it is a sign-in function
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['type']) && $_POST['type'] == 'signin') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$db = new db_functions();
	
	if ($db->authenticate_user($email,$password)) {
		echo "Sign in success";
		$_SESSION['user'] = $email;
		//header("Location: main.php");
	} else {
		$_SESSION['failed'] = true;
		header("Location: signin.php");
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
*/
?>