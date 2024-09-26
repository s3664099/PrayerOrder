<?php
/*
File: PrayerOrder User Program
Author: David Sarkies 
Initial: 22 September 2024
Update: 26 September 2024
Version: 0.1
*/
include 'db_functions.php';

session_start();

if (isset($_GET['users'])) {
	
	$db = new db_functions();
	$users = [];

	$allUsers = $db->getUsers($_GET['users']);
	
	while ($x = $allUsers->fetch_assoc()) {
	 	$users[] = $x;
	}

	foreach($users as $x) {
		error_log(implode(" ",$x));
	}
}

/*
22 September 2024 - Created File
26 September 2024 - Retrieved the names matching the string entered
*/