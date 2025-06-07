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
		echo ($people."</br>");
		echo ($people_copy."</br>");
	}

	//Copy the array
	//Go through list
	//Select random from second array
		//Is user - if so select again
		//If not - match to user and drop entry
}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
*/
?>