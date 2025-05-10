<?php
/*
File: PrayerOrder Create Group Program
Author: David Sarkies 
Initial: 10 Mau 2025
Update: 10 May 2025
Version: 1.0
*/

include '../database/db_functions.php';
session_start();
$db = new db_functions();

if (isset($_GET['users'])) {

	$allUsers = [];

	$result = $db->inviteUsers($_GET['users'],$_SESSION['user'],$_SESSION['groupId']);
	while ($x=$result->fetch_assoc()) {
		$allUsers[] = $x;
	}

	echo json_encode($allUsers);
}

/* 10 May 2025 - Created File
*/
?>