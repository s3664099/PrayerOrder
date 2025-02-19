<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 13 Fedbruary 2025
#Update: 16 February 2025
#Version: 1.1
*/

header('Content-Type: application/json');

function getGroups($user) {

	$db = new db_functions();

	return $db->getGroups($user);
}

/*
13 February 2025 - Created File
16 February 2025 - Added backend retrieval for setting group id
				   Moved select group to new file
*/
?>