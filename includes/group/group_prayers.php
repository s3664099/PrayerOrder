<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 10 June 2025
#Version: 1.3
*/

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['people'])){
	
	$members = array();
	$partners = array();
	$prayers = [];
	$absent = array();
	$people = $_POST['people'];
	
	foreach($people as $person) {

		$email = $person['email'];
		$present = isset($person['present']) ? true:false;
		$prayer = $person['prayer'];

		if($present) {
			array_push($members,$email);
		} else {
			array_push($absent,$email);
		}
		$prayers[$email] = $prayer;
	}

	if(count($members)==2) {
		$partners = array([$members[0],$members[1]],[$members[1],$members[0]]);
	} else {

		sortPrayers($members,$members);

		echo("--------------</br>");

		$members_copy = new ArrayObject($members);
		sortPrayers($members,$absent);
	}
}

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
*/
?>