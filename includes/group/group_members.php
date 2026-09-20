<?php
/*
File: PrayerOrder group display page
Author: David Sarkies 
#Initial: 19 September 2026
#Update: 19 September 2026
#Version: 1.0
*/

$group_service = new group_services();
$result = $group_service->get_members($_SESSION['group']['groupKey']);

foreach ($result as $x) {
	error_log($x['name']);
    error_log($x['image']);
	echo print_r($x,true);
}




/*
function getMembers() {

    $db = new db_functions();
    $result = $db->getMembers($_SESSION['groupId']);
    
    echo ("<div class='group-prayer-box'>");
    foreach ($result as $x){
        displayMembers($x);
    }
    echo ("</div>");
}

function displayMembers($member) {
    echo("<h3 class='prayer-h3'>".$member['name']." ");
    $memberType = getMemberType($member['memberType']);
    echo($memberType);            
    echo("</h3>");
}

function getMemberType($member) {

    $memberType = "";
    if ($member == "a") {
        $memberType = "- Admin";
    } else if ($member == "c") {
        $memberType = "- Creator";
    }
    return $memberType;

}
*/


/*
 * 19 September 2026 - Created File
 */
?>