<?php
/*
File: PrayerOrder group display page
Author: David Sarkies 
#Initial: 19 September 2026
#Update: 6 October 2026
#Version: 1.3
*/

$group_service = new group_services();

$result = $group_service->get_members($_SESSION['group']['groupKey']);
$current_user_is_creator = $_SESSION['group']['memberType'] == 'c';
$current_user_is_admin = $_SESSION['group']['memberType'] == 'a' || $current_user_is_creator;

foreach ($result as $member) {

    $member['can_block'] = false;
    $member['can_remove'] = false;
    $member['can_promote'] = false;
    $member['can_demote'] = false;

    if($member['user'] != $_SESSION['user']) {

        if ($member['memberType'] === 'm' && $current_user_is_admin) {
            $member['can_block'] = true;
            $member['can_remove'] = true;
            $member['can_promote'] = true;
        }

        if ($member['memberType'] === 'p' && $current_user_is_admin) {
            $member['can_block'] = true;
            $member['can_remove'] = true;
        }

        if ($member['memberType'] === 'b' && $current_user_is_admin) {
            $member['can_block'] = true;
        }

        if ($member['memberType'] === 'a' && $current_user_is_creator) {
            $member['can_demote'] = true;
            $member['can_block'] = true;
            $member['can_remove'] = true;
        }
    }

    error_log($member['name']);
    error_log($member['memberType']);

    if ($member['memberType'] === 'a' || $member['memberType'] === 'm' || $member['memberType'] == 'c' 
        || ($current_user_is_admin && ($member['memberType'] == 'p' || $member['memberType'] == 'b'))) {
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/templates/group_member_display.php';
    }
}

/*
 * 19 September 2026 - Created File
 * 20 September 2026 - Completed display group members
 * 5 October 2026 - Added flag for current user type
 *                - Added settings for user options
 */
?>