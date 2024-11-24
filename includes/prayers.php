<?php
/*
File: PrayerOrder prayers page
Author: David Sarkies 
#Initial: 24 November 2024
#Update: 24 November 2024
#Version: 0.0
*/

include 'pray.php';

$result = getPrayers($_SESSION['user']);

foreach ($result as $x) {

	echo "<pre>";
	echo $x['name']." ".$x['postdate']."</br>".$x['prayerkey']."</br>";
	echo gettype($x['postdate'])."</br>";
	echo "</pre>";
}

/*
24 November 2024 - Created File
*/
?>