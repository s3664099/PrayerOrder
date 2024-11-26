<?php
/*
File: PrayerOrder prayers page
Author: David Sarkies 
#Initial: 24 November 2024
#Update: 26 November 2024
#Version: 0.1
*/

include 'pray.php';

$result = getPrayers($_SESSION['user']);

foreach ($result as $x) {

	$postDate = new DateTime($x['postdate']);
	$currDate = new DateTime();
	$diff = $currDate->diff($postDate);
	#$date = date_create_from_format("dMYGis',$x['postdate']); #strtotime($x['postdate']);
	#$time = date_diff($date,date());

	echo "<pre><h4 class='user-header'>";
	
	if (strlen($x['image'])>0) {
		echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/".$x['image']."'>";
	} else {
		echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/user.png'>";
	}

	echo $x['name']."</h4>";
	echo "<div class='user-header'>".$diff->format('%y years,%m months, %d days, %h hours, %i minutes, %s seconds')."</div>";
	echo "<div class='user-header'>".$x['prayerkey']."</div>";
	echo "</br>";
	echo "</pre>";
}

/*
24 November 2024 - Created File
26 November 2024 - Moved the user header to the left
*/
?>