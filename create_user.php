<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 7 February 2024
Update: 7 February 2024
Version: 0.0

Needs to check whether email & phone has already been used - rejects it if it is
*/
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$password = $_POST['password'];
	}

/*
7 February 2024 - Created File
*/
?>