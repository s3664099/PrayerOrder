<?php
/*
File: PrayerOrder Redirect Program
Author: David Sarkies 
Initial: 2 March 2024
Update: 5 December 2024
Version: 1.0
*/

session_start();

if (!isset($_SESSION['user'])) {
	header("Location: signin.php");
}

/*
2 March 2024 - Created File
5 December 2024 - Increased version
*/
?>