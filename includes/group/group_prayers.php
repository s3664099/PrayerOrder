<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 26 October 2025
#Version: 1.6
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
		sendSMS($person);
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

function sendSMS($person) {

	$baseUrl = 'https://api.textbee.dev/api/v1';
	$apikey = getenv('TEXTBEE_KEY');
	//$phone_number = "+61".substr($person['phone'],1);
	$phone_number = "+61415670421";

	echo $apikey."</br>";
	echo print_r($person)."</br>";
	echo $phone_number."</br>";

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

//fuction setPrayerTime($member) {
	//We need to divide it tthr
//}

/*
3 June 2025 - Created File
7 June 2025 - Started working on the prayer sorting algorithm
8 June 2025 - Completed sorting algorithm for arranging prayer partners
10 June 2025 - Added sort for absent members and moved to separate function
24 October 2026 - Started building the prayer list
25 October 2026 - Fixed sorting so people do not get their own prayer
26 October 2026 - Added send sms function
*/
?>