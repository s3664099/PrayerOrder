<?php
/*
File: PrayerOrder Create Group Program
Author: David Sarkies 
Initial: 10 Mau 2025
Update: 13 May 2025
Version: 1.1
*/

include '../database/db_functions.php';
session_start();
$db = new db_functions();
$input = json_decode(file_get_contents("php://input"), true);

if (isset($_GET['users'])) {

	$allUsers = [];

	$result = $db->inviteUsers($_GET['users'],$_SESSION['user'],$_SESSION['groupId']);
	while ($x=$result->fetch_assoc()) {
		$allUsers[] = $x;
	}

	echo json_encode($allUsers);
}

//Invites user to group
if (isset($_GET['invite'])) {
	$result = $db->inviteUser($_GET['invite'],$_SESSION['groupId']);

	echo($result);
}

if (isset($input['invite_response'])) {
	if ($input['invite_response']=="Y") {
		$db->acceptInvite($_SESSION['user'],$input['id']);
	} else if ($input['invite_response']=="N") {
		$db->rejectInvite($_SESSION['user'],$input['id']);
	}
}

/* 10 May 2025 - Created File
 * 13 May 2025 - Implemented function to send invite to user
*/

?>