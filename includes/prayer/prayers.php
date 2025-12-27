<?php
/*
File: PrayerOrder prayers page
Author: David Sarkies 
#Initial: 24 November 2024
#Update: 27 December 2025
#Version: 1.12
*/

include 'prayer_services.php';
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


$prayer_service = new prayer_services();
$result = $prayer_service->get_prayers($_SESSION['user']);

foreach ($result as $x) {

	$prayer = $prayer_service->get_prayer($x['prayerkey']);

	if ($prayer != null) {

		$user = $prayer_service->get_user($x['userKey']);
		$prynum = $prayer_service->countReaction(1,$x);
		$prsnum = $prayer_service->countReaction(2,$x);
		$user_reaction = $prayer_service->checkReaction($_SESSION['user'],$x['prayerkey']);	
		$postDate = new DateTime($x['postdate']);

		echo "<pre class='prayer'><h4 class='user-header'>";
	
		if (strlen($user['images'])>0) {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/".$user['images']."'>";
		} else {
			echo "<img id='avatar' alt='user_image' width='15' src='./Images/Avatar/user.png'>";
		}

		echo $user['name']."</h4>";
		echo "<div class='user-header'>".$prayer_service->date_diff($postDate)."</div>";
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
19 July 2025 - Moved check reaction to separate file.
23 December 2025 - Started moving code into a prayer services file
24 December 2025 - Fixed errors
27 December 2025 - Moved date_diff to prayer_services
*/
?>