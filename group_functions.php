<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 13 Fedbruary 2025
#Update: 16 February 2025
#Version: 1.1
*/
include 'db_functions.php';

function display_groups() {

	foreach (get_groups($_SESSION['user']) as $x) {
    	if ($x['isAdmin']==0) {
        	echo "<span class='pl-15p'>";
        } else {
            echo "<span><img src='./Images/icon/admin.png' width='20' class='pr-2p'>";
        }

        echo "<button class='groupSelect' onclick='selectGroup(this)' id='".$x['groupKey']."'>".$x['groupName'];
        echo "</button></span></div>";
    }
}

function get_groups($user) {

	$db = new db_functions();

	return $db->getGroups($user);
}

/*
13 February 2025 - Created File
16 February 2025 - Added backend retrieval for setting group id
				   Moved select group to new file
*/
?>