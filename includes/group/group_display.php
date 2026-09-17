<?php
/*
File: PrayerOrder group display page
Author: David Sarkies 
#Initial: 17 September 2026
#Update: 17 September 2026
#Version: 1.0
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/group/group_services.php';

$group_service = new group_services();
$result = $group_service->get_groups($_SESSION['user']);

foreach ($result as $x) {

	if ($x['memberType'] != 'p' && $x['memberType'] !='b') {

		$group = [
			'memberType'			=>		$x['memberType'],
			'groupKey'				=>		$x['groupKey'],
			'groupName'				=>		$x['groupName']
		];

		include $_SERVER['DOCUMENT_ROOT'] . '/includes/templates/group_item.php';
	}
}

/*
 * 17 September 2026 - Created File
 */