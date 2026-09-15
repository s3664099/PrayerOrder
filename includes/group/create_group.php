<?php
/*
File: PrayerOrder Create Group Program
Author: David Sarkies 
Initial: 8 February 2025
Update: 15 September 2026
Version: 1.4
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/group/group_services.php';

if (!isset($_SESSION)) {
	session_start();
}

//Checks if a group has been created
if($_SERVER['REQUEST_METHOD'] == "POST") {

	if (!isset($_POST['csrf_token'])
    	|| !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

    	// Invalid request — reject it
    	die("Invalid CSRF token");
	}

	$group_service = new group_services();

	$name = $_POST['group-name'];
	$owner = $_SESSION['user'];
	$private = $_POST['isPrivate'];
	$adminInvite = $_POST['isAdminOnlyInvite'];
	$_SESSION['groupPage'] = true;
	$key = hash("sha256",$name.$owner);
	$success = false;

	//Checks if key already present (ie user created group of the same name)
	$group_result = $group_service->get_group($key);
	if ($group_result == 1) {
		$_SESSION['group_exists'] = true;
	} else if ($group_result == 2) {
		$_SESSION['add_failed'] = true;
	} else {
		$success = $group_service->addGroup($key,$name,$private,$owner,$adminOnlyInvite);

		if (!$success) {
			$_SESSION['add_failed'] = true;
		}
	}
	header("Location:../../groups.php");
}

/*
8 February 2025 - Created File
12 April 2025 - Redirected to group page
19 April 2025 - Moved database & create group files
14 September 2026 - Updated to use group services
15 September 2026 - Updated to handle failure to add group
*/
?>