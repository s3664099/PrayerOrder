<?php
/*
File: PrayerOrder Redirect Program
Author: David Sarkies 
Initial: 2 March 2024
Update: 2 March 2024
Version: 0.1
*/

session_start();

if (!isset($_SESSION['user'])) {
	header("Location: signin.php");
}

/*
2 March 2024 - Created File
*/
?>