<?php
/*
File: PrayerOrder prayers page
Author: David Sarkies 
#Initial: 24 November 2024
#Update: 16 July 2025
#Version: 1.8
*/

include 'pray.php';

$result = getInvites($_SESSION['user']);

foreach ($result as $x) {
	echo "<h4 id='".$x['groupKey']."' class='accept_invite'>";
	echo "<img alt='Accept Invite' width='15' src='./Images/icon/accept.png/' onclick='acceptInvite(this)' 
		  class='accept_invite' title='Accept'>";
		echo "<img alt='Reject Invite' width='15' src='./Images/icon/reject.png/' onclick='rejectInvite(this)' 
		  class='accept_invite' title='Reject'>";
	echo "Invite: ".$x['groupName']."</h4>";
}

$result = getPrayers($_SESSION['user']);

foreach ($result as $x) {

	$prayer = getPrayer($x['prayerkey']);

	if ($prayer != false) {

		$user = getUser($x['userKey']);
		$prynum = countReaction(1,$x);
		$prsnum = countReaction(2,$x);
		$user_reaction = $db->checkReaction($_SESSION['user'],$x['prayerkey']);		
		$postDate = new DateTime($x['postdate']);

		echo "<pre class='prayer'><h4 class='user-header'>";
	
		if (strlen($user['images'])>0) {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/".$user['images']."'>";
		} else {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/user.png'>";
		}

		echo $user['name']."</h4>";
		echo "<div class='user-header'>".datediff($postDate)."</div>";
		echo "<div class='user-header'>".$prayer."</div>";
		echo "</br>";
		echo "</pre>";

		#Prayer reaction
		echo "<div class='prayer-like'><button class='praybtn";
		if ($user_reaction==1) {
			echo " selected";
		} 
		echo "' id='pray".$x['prayerkey']."' ";
		echo "onclick='react(this)'>";
		echo "<img src='/Images/icon/pray.png' width=20></button><span id='pry".$x['prayerkey']."'>".$prynum."</span>";

		#Praise reaction
		echo "<button class='praybtn ";
		if ($user_reaction==2) {
			echo " selected";
		} 
		echo "' id='praise".$x['prayerkey']."' onclick='react(this)'>";
		echo "<img src='/Images/icon/praise.png' width=20></button><span id='prs".$x['prayerkey']."'>".$prsnum;
		echo "</span></div>";
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
25 December 2024 - Displays the selected reaction. Added call to count function
27 December 2024 - Added numbers to reactions
28 December 2024 - Added key to prayer and praise count spans
15 May 2025 - Added retrieval for invites. Added invite display
18 May 2025 - Changed name for function for accepting invite
			- Added icon for rejecting invite
15 July 2025 - Updated code to use new database to get prayers, and also call to retrieve user details
16 July 2025 - Updated to display name and image
*/
?>