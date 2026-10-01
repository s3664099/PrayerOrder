<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 13 February 2025
#Update: 1 October 2026
#Version: 1.13
*/

include 'includes/database/db_functions.php';
$db = new db_functions();

//member type - m - member, p - pending, b - blocked, c - creator, a - admin

function adminOnlyInvite() {

    $group_service = new group_services();

    $user_type = $group_service->get_user_type($_SESSION['group']['groupKey'],$_SESSION['user']);

    if($_SESSION['group']['adminOnlyInvite']==1 && $user_type !='c' && $user_type !='a') {
        echo("<span width='20' class='pl-5p'></span>");
    } else {
        echo("<img src='./Images/icon/invite.png' width='20' alt='back' id='invite-icon' title='Invite' 
                class='point pl-5p' onclick='invite();''>");
    }

}


function getPrayerBox() {
    $db = new db_functions();
    $result = $db->getMembers($_SESSION['groupId']);
    $count = 0;

    foreach ($result as $x) {
        echo("<div class='group-prayer-box'>");
        echo("<h3 class='prayer-h3'>".$x['name']."</h3>");
        echo("<input type='hidden' name='people[".$count."][email]' value='".$x['email']."'>");
        echo("<div>Present <input type='checkbox' name='people[".$count."][present]'");
        echo("id='people[".$count."][present]' value='1'></div>");
        echo("<textarea name='people[".$count."][prayer]' id='people[".$count."][prayer]'></textarea>");
        echo("</div>");
        $count++;
    }
    echo("<input type='hidden' id='count' value='".$count."'>");
}

/*
13 February 2025 - Created File
16 February 2025 - Added backend retrieval for setting group id
				   Moved select group to new file
15 April 2025 - Retrieves the group name
19 April 2025 - Moved database file
24 April 2025 - Fixed problem with groups not displaying.
11 May 2025 - Update code to use memberType as opposed to isAdmin
20 May 2025 - Retrieve and display group members
27 May 2025 - Added function to display prayer requests for prayer order.
            - Added functionality to return the memberType
30 May 2025 - Display member type.
3 June 2025 - Added styling for member and prayer display
8 June 2025 - Added count variable for prayers
10 June 2025 - Added ids to elements of form
1 October 2026 - Added function to hide invite if not admin for Admin Only Invite
*/
?>