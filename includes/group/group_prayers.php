<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 7 June 2025
#Version: 1.1
*/

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$people = array();
	$partners = array();
	$count = 0;
	foreach ($_POST as $x) {
		
		if ($count%2 == 0) {
			array_push($people, $x);
		}
		$count++;
	}

	if(count($people)==2) {
		$partners = array([$people[0],$people[1]],[$people[1],$people[0]]);
	} else {
		$people_copy = new ArrayObject($people);
		foreach ($people as $x) {
			$match = false;
			while (!$match) {
				$num = rand(0,sizeof($people_copy)-1);
				echo $x." --> ".$people_copy[$num]."    ".$num."</br>";
				if ($people_copy[$num] != $x) {
					$match = true;
					unset($people_copy[$num]);
					$people_copy = reorder_array($people_copy);
				}
			}
		}
	}

	
	//Go through list
	//Select random from second array
		//Is user - if so select again
		//If not - match to user and drop entry
}

function reorder_array($unOrderedArray) {
	$orderedArray = array();
	foreach ($unOrderedArray as $x){
		array_push($orderedArray,$x);
	}
	return $orderedArray;
}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
*/
?>