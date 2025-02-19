<?php
/*
File: PrayerOrder groups page
Author: David Sarkies 
#Initial: 13 Fedbruary 2025
#Update: 16 February 2025
#Version: 1.2
*/

include 'groupFunctions.php';

$result = getGroups($_SESSION['user']);

foreach ($result as $x) {
	echo "<div class='centre pl-15p pt-5p'>";

	if ($x['isAdmin']==0) {
		echo "<span class='pl-15p'>";
	} else {
		echo "<span><img src='./Images/icon/admin.png' width='20' class='pr-2p'>";
	}

	echo "<button class='groupSelect' onclick='selectGroup(this)' id='".$x['groupKey']."'>".$x['groupName'];
	echo "</button></span></div>";
}


/*
13 February 2025 - Created File
14 February 2025 - Added styling for group list
16 February 2025 - Added groupId to group select and group select function
*/
?>