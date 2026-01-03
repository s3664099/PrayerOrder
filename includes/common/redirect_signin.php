<?php
/*
File: PrayerOrder Redirect Program
Author: David Sarkies 
Initial: 2 March 2024
Update: 2 January 2026
Version: 1.1
*/

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['user'])) {
	header("Location: signin.php");
	exit;
}

/*
2 March 2024 - Created File
5 December 2024 - Increased version
2 January 2026 - Added exit.
*/
?>