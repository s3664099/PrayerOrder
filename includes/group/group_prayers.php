<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 8 June 2025
#Version: 1.2
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
				if ($people_copy[$num] != $x) {
					$match = true;
					echo $x." --> ".$people_copy[$num]."    ".$num."</br>";
					array_push($partners,[$x,$people_copy[$num]]);
					unset($people_copy[$num]);
					$people_copy = new ArrayObject(array_values($people_copy->getArrayCopy()));
				}
			}
		}
	}

	print_r($partners);

	
	//Go through list
	//Select random from second array
		//Is user - if so select again
		//If not - match to user and drop entry
}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
8 June 2025 - Completed sorting algorithm for arranging prayer partners
*/
?>