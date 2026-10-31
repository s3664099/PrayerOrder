<?php
/*
File: PrayerOrder Group Functions page
Author: David Sarkies 
#Initial: 3 June 2025
#Update: 31 October 2025
#Version: 1.9
*/

include $_SERVER['DOCUMENT_ROOT'] . '/includes/prayer/prayer_services.php';

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

	//foreach ($members as $person) {
	//	sendSMS($person);
	//}

	setWeeklyPrayer($people);
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

	//Saves prayers
	$prayer_service = new prayer_services();
	$prayer = trim($person['partner_prayer']);
	$prayer_service->add_prayer($prayer,$person['id'],1);
}

function setWeeklyPrayer($members) {

	$days = array();
	$start_date = new DateTimeImmutable('tomorrow');

	for ($i = 0; $i<7;$i++) {

		$date = $start_date->modify("+$i days");

		$days[$i] = array(
			'date' => $date->format('Y-m-d'),
			'day' => $date->format('l'),
			'member_count' => 0
		);

		//Sunday: add the church-service prayer
		if($date->format('w') == 0) {
			$days[$i]['prayers'][] = array(
				'name' => 'Church Service',
				'prayer' => 'May the service go well day, and we have some good conversations'
			);
			$days[$i]['member_count']++;
		}
	
		if ($i == 6) {
			$days[$i]['prayers'][] = array(
				'name'=> 'Bible Study',
				'prayer' => "That we will have a good discussion for bible study tonight"
			);
		}
	}

	shuffle($members);
	$number_members = count($members);

	//Allocate members
	for ($i=0; $i<min($number_members,7);$i++) {
		if($number_members <7) {
			if ($number_members == 1) {
				$day_index = 3;
			} else {
				if($days[$i]['member_count']==0) {
					$day_index = $i;
				}
			}
			echo $day_index."</br>";
		} else {
			$day_index = $i;
		}

		$days[$day_index]['prayers'][] = $members[$i];
		$days[$day_index]['member_count']++;
	}

	foreach($days as $day) {
		echo print_r($day)."</br>";
	}

	//Get date & day, and then implement
	//Divide prayer into 7
	//echo sizeof($members)."</br>";

	//Loop through day
	//Randomly remove number of prayer and assign to day
	//Include church for Sunday & BS for last day

	//foreach ($members as $member) {
	//	echo print_r($member)."</br>";
	//}

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
31 October 2026 - Added week prayer calendar
*/
?>