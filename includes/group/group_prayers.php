<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 24 October 2025
#Version: 1.4
*/

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['people'])){
	
	$members = array();
	$partners = array();
	$absent = array();
	$people = $_POST['people'];
	
	foreach($people as $person) {

		$present = isset($person['present']) ? true:false;

		if($present) {
			array_push($members,$person);
		} else {
			array_push($absent,$person);
		}
	}

	if(count($members)==2) {
		$people[0]['partner'] = $members[1];
		$people[1]['partner'] = $members[0];
	} else {

		sortPrayers($members,$members);

		echo("--------------</br>");

		$members_copy = new ArrayObject($members);
		sortPrayers($members,$absent);
	}

	//Go through arrays and add prayers to members
	//SMS prayers to selected members

	//Print out prayer calendar for the week
}

/*
*/



function sortPrayers($members,$partners) {

	$members_copy = new ArrayObject($members);
	foreach ($partners as $x) {
		$match = false;
		while (!$match) {
			$num = rand(0,sizeof($members_copy)-1);
			if ($members_copy[$num] != $x) {
				$match = true;
				echo $x." --> ".$members_copy[$num]."</br>";
				array_push($partners,[$x,$members_copy[$num]]);
				unset($members_copy[$num]);
				$members_copy = new ArrayObject(array_values($members_copy->getArrayCopy()));
			}
		}
	}
}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
8 June 2025 - Completed sorting algorithm for arranging prayer partners
10 June 2025 - Added sort for absent members and moved to separate function
24 October 2026 - Started building the prayer list
*/
?>