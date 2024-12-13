<?php
/*
File: PrayerOrder prayers page
Author: David Sarkies 
#Initial: 24 November 2024
#Update: 13 December 2024
#Version: 1.1
*/

include 'pray.php';

$result = getPrayers($_SESSION['user']);

foreach ($result as $x) {

	$prayer = getPrayer($x['prayerkey']);

	if ($prayer != false) {

		$prynum = "";
		$prsnum = "";

		$postDate = new DateTime($x['postdate']);

		echo "<pre class='prayer'><h4 class='user-header'>";
	
		if (strlen($x['image'])>0) {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/".$x['image']."'>";
		} else {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/user.png'>";
		}

		echo $x['name']."</h4>";
		echo "<div class='user-header'>".datediff($postDate)."</div>";
		echo "<div class='user-header'>".$prayer."</div>";
		echo "</br>";
		echo "</pre>";
		echo "<div class='prayer-like'><button class='praybtn'>#</button><span>".$prynum."</span>";
		echo "<button class='praybtn'>$</button><span>".$prsnum."</span></div>";
	}
}

function datediff($pastdate) {

	$currDate = new DateTime();
	$date = "";

	// Calculate the difference
	$date_diff = $currDate->diff($pastdate);

	// Determine the most significant unit
	if ($date_diff->y > 0) {
    	$date = $date_diff->y . " year" . ($date_diff->y > 1 ? "s" : "") . " ago";
	} elseif ($date_diff->m > 0) {
    	$date = $date_diff->m . " month" . ($date_diff->m > 1 ? "s" : "") . " ago";
	} elseif ($date_diff->d > 0) {
    	$date = $date_diff->d . " day" . ($date_diff->d > 1 ? "s" : "") . " ago";
	} elseif ($date_diff->h > 0) {
    	$date = $date_diff->h . " hour" . ($date_diff->h > 1 ? "s" : "") . " ago";
	} elseif ($date_diff->i > 0) {
    	$date = $date_diff->i . " minute" . ($date_diff->i > 1 ? "s" : "") . " ago";
	} else {
    	$date = "Just now";
	}

	return $date;
}

/*
24 November 2024 - Created File
26 November 2024 - Moved the user header to the left. Added function to determine when prayer was posted.
1 December 2024 - Added section to retrieve prayers from JSON file based on prayer key.
5 December 2024 - Increased version
13 December 2024 - Added response buttons
*/
?>