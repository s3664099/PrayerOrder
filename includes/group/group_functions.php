<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 13 Fedbruary 2025
#Update: 11 May 2025
#Version: 1.4
*/
include 'includes/database/db_functions.php';

//member type - m - member, p - pending, b - blocked, c - creator, a - admin
function display_groups() {

	foreach (get_groups($_SESSION['user']) as $x) {

        if ($x['memberType'] != 'p' && $x['memberType'] != 'b') {
            echo "<div>";
         	if ($x['memberType']=='m') {
            	echo "<span class='pl-15p'>";
            } else if ($x['memberType'] == 'c' || $x['memberType']=='a') {
                echo "<span><img src='./Images/icon/admin.png' width='20' class='pr-2p'>";
            }

            echo "<button class='groupSelect' onclick='selectGroup(this)' id='".$x['groupKey']."'>".$x['groupName'];
            echo "</button></span></div>";
        }
    }
}

function get_groups($user) {
    $db = new db_functions();
	return $db->getGroups($user);
}

function set_group_name() {
    $db = new db_functions();
    $_SESSION['group_name'] = $db->getGroupName($_SESSION['groupId']);
}

/*
13 February 2025 - Created File
16 February 2025 - Added backend retrieval for setting group id
				   Moved select group to new file
15 April 2025 - Retrieves the group name
19 April 2025 - Moved database file
24 April 2025 - Fixed problem with groups not displaying.
11 May 2025 - Update code to use memberType as opposed to isAdmin
*/
?>