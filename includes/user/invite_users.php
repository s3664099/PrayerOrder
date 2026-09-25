<?php
/*
File: PrayerOrder Create Group Program
Author: David Sarkies 
Initial: 10 May 2025
Update: 25 September 2026
Version: 1.6
*/

require_once  $_SERVER['DOCUMENT_ROOT'] . '/includes/group/group_services.php';
include '../database/db_functions.php';

header('Content-Type: application/json'); // Set content type to JSON

if (!isset($_SESSION)) {
	session_start();
}

$db = new db_functions();
$input = json_decode(file_get_contents("php://input"), true);
$group_service = new group_services();

if (isset($_GET['users'])) {

	$result = $group_service->invite_users($_GET['users'],$_SESSION['user'],$_SESSION['group']['groupKey']);

	echo json_encode($result);
}

//Invites user to group
if (isset($_GET['invite'])) {
	$result = $group_service->send_invite($_GET['invite'],$_SESSION['group']['groupKey']);

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
 * 20 September 2026 - Changed name for consistency
 * 21 September 2026 - Added call to invite users
 * 22 September 2026 - Now sucessfully calls group services
 * 24 September 2026 - Returns filtered users
 * 25 Seotember 2026 - Updated for sending invite
*/

?>