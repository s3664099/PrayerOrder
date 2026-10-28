<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 28 October 2025
#Version: 1.8
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

			if (strlen($person['prayer'])>0) {
				array_push($absent,$person);
			}
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
		sendSMS($person);
	}

	setPrayerTime($people_copy);
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
					$members[$x]['partner_prayer'] = $members[$x]['partner_prayer'].$partner_copy[$num]['name']." - ".$partner_copy[$num]['prayer'];
					unset($partner_copy[$num]);
					$partner_copy = new ArrayObject(array_values($partner_copy->getArrayCopy()));
				}
			}
		}
	}
	return $members;
}

function sendSMS($person) {

	$baseUrl = 'https://api.textbee.dev/api/v1';
	$apikey = getenv('TEXTBEE_KEY');
	//$phone_number = "+61".substr($person['phone'],1);
	$phone_number = "+61".substr(getenv('MY_PHONE'),1);
	$using_phone = false;

	if ($using_phone) {
		$ch = curl_init("$baseUrl/gateway/send-sms");
		curl_setopt_array($ch, [
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => ["x-api-key: $apikey","Content-Type: application/json"],
			CURLOPT_POSTFIELDS => json_encode(['recipients' => [$phone_number],"message" => $person['partner_prayer']]),
		]);

		$body = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		curl_close($ch);
		
		if ($status !== 200) {
			throw new RuntimeException("HTTP $status");
		}
	}

	echo print_r($person)."</br>";

	//Pass through user id and save prayers
	//Save prayer in prayer db

}

function setPrayerTime($members) {

	//Get date & day, and then implement
	//Divide prayer into 7
	echo sizeof($members)."</br>";

	//Loop through day
	//Randomly remove number of prayer and assign to day
	//Include church for Sunday & BS for last day

	foreach ($members as $member) {
		echo print_r($member)."</br>";
	}

	//Save in group prayer
}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
8 June 2025 - Completed sorting algorithm for arranging prayer partners
10 June 2025 - Added sort for absent members and moved to separate function
24 October 2026 - Started building the prayer list
25 October 2026 - Fixed sorting so people do not get their own prayer
26 October 2026 - Added send sms function
27 October 2026 - Moved phone to env variable. Added switch to prevent sending sms
				- Started setPrayerTime
28 October 2026 - Fixed minor errors and excluded empty prayers
*/
?>