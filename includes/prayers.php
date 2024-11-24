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

	$postDate = new DateTime($x['postdate']);
	$currDate = new DateTime();
	$diff = $currDate->diff($postDate);
	#$date = date_create_from_format("dMYGis',$x['postdate']); #strtotime($x['postdate']);
	#$time = date_diff($date,date());

	echo "<pre>";
	echo "<h4><img id='avatar' alt='user_image' width='15' src='./Images/user.png'>".$x['name']."</h4>";
	echo $diff->format('%y years, %m months, %d days, %h hours, %i minutes, %s seconds')."</br>".$x['prayerkey']."</br></br>";
	echo "</pre>";
}

/*
24 November 2024 - Created File
*/
?>