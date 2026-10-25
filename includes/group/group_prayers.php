<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 25 October 2025
#Version: 1.5
*/

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['people'])){
	
	$members = array();
	$partners = array();
	$absent = array();
	$people = $_POST['people'];
	
	foreach($people as $person) {

		$present = isset($person['present']) ? true:false;
		$person['partner_prayer'] = " ";

		if($present) {
			array_push($members,$person);
		} else {
			array_push($absent,$person);
		}
	}

	if(count($members)==2) {
		$people[0]['partner_prayer'] = $members[1]['name']." - ".$members[1]['prayer'];
		$people[1]['partner_prayer'] = $members[0]['name']." - ".$members[0]['prayer'];
	} else {

		$members = sortPrayers($members,$members);
		$members = sortPrayers($members,$absent);
	}

	foreach ($members as $person) {
		emailPrayer($person);
	}

	//Print out prayer calendar for the week
}

function sortPrayers($members,$partners) {

	$partner_copy = new ArrayObject($partners);
	foreach ($members as $x => $person) {
		$match = false;
		if(count($partner_copy)>0) {
			while (!$match) {
				$num = rand(0,sizeof($partner_copy)-1);
				if ($partner_copy[$num]['email'] != $members[$x]['email']) {
					$match = true;
					$members[$x]['partner_prayer'] = $members[$x]['partner_prayer'].$partner_copy[$num]['name']." - ".$partner_copy[$num]['prayer']."</br>";
					unset($partner_copy[$num]);
					$partner_copy = new ArrayObject(array_values($partner_copy->getArrayCopy()));
				}
			}
		}
	}
	return $members;
}

function emailPerson($person) {

}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
8 June 2025 - Completed sorting algorithm for arranging prayer partners
10 June 2025 - Added sort for absent members and moved to separate function
24 October 2026 - Started building the prayer list
25 October 2026 - Fixed sorting so people do not get their own prayer
*/
?>