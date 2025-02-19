<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 16 Fedbruary 2025
#Update: 16 February 2025
#Version: 1.0
*/

//select group
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['group'])) {

	error_log($input['id']);
	$_SESSION['groupId'] = $input['id'];
	unset($input['group']);
	echo json_encode(["success" => true, "message" => "Group ID set successfully"]);
} else {
    error_log("Missing POST parameter");
    echo json_encode(["success" => false, "error" => "Missing required parameters"]);
}

/*
16 February 2025 - Created file
*/

?>