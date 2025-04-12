<?php
/*
File: PrayerOrder Create Group Program
Author: David Sarkies 
Initial: 8 February 2025
Update: 12 April 2025
Version: 1.1
*/

	include 'db_functions.php';
	session_start();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = $_POST['group-name'];
		$owner = $_SESSION['user'];
		$private = $_POST['isPrivate'];
		$_SESSION['groupPage'] = true;
		$key = hash("sha256",$name.$owner);
		$success = false;

		$db = new db_functions();

		//Checks if key already present (ie user created group of the same name)
		if ($db->checkGroup($key)) {
			$_SESSION['group_exists'] = true;
			error_log("Group Exists");
		} else {
			$success = $db->addGroup($key,$name,$private,$owner);
		}

		header("Location:groups.php");
	}

/*
8 February 2025 - Created File
12 April 2025 - Redirected to group page
*/
?>