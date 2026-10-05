<?php
/*
File: PrayerOrder group display page
Author: David Sarkies 
#Initial: 19 September 2026
#Update: 5 October 2026
#Version: 1.2
*/

$group_service = new group_services();

//The membership type should be stored in the session, but group and membership type cleared when go to group page.

//Admin/creator can see all members - So, in the group services we get the members based on membership type
$result = $group_service->get_members($_SESSION['group']['groupKey']);
$current_user_is_creator = $_SESSION['group']['memberType'] == 'c';
$current_user_is_admin = $_SESSION['group']['memberType'] == 'a' || $current_user_is_creator;

foreach ($result as $member) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/templates/group_member_display.php';
}

/*
 * 19 September 2026 - Created File
 * 20 September 2026 - Completed display group members
 * 5 October 2026 - Added flag for current user type
 */
?>