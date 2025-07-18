<?php
/*
File: PrayerOrder DB update prayer db
Author: David Sarkies 
Initial: 20 June 2025
Update: 18 July 2025
Version: 1.5
*/

include 'db_handler.php';

$failed = False;
$db = new db_handler('db_root.json');
$conn = $db->get_connection();

#swap_prayer_data($conn,'prayerorder');
#swap_connection_data($conn);
#swap_reaction_data($conn);
#swap_group_data($conn);
swap_nonuser_reactions($conn);

function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
		echo "Query Executed successfully\n";
	} else {
  		echo "Executing query: " . $conn->error."\n";
	}
}

function retrieve_data($conn,$sql) {

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->get_result();
}

function swap_prayer_data($conn) {
	execute_query($conn,"USE prayerorder");

	$result = retrieve_data($conn,"SELECT * FROM prayer");

	foreach ($result as $x) {
		execute_query($conn,"USE po_user");
		$result = retrieve_data($conn,"SELECT id FROM user WHERE email='".$x['email']."'");
		$y = $result->fetch_array(MYSQLI_NUM);
		$prayer_id = uniqid();
		print_r($x['prayerkey']."           ".$prayer_id)."\n";
		execute_query($conn,"USE po_prayer");
		execute_query($conn,"INSERT INTO prayer (userkey,postdate,prayerkey) VALUES ('".$y[0]."','".$x['postdate']."','".$prayer_id."')");
	}
}

function get_user_id($conn,$email) {
	execute_query($conn,"USE po_user");
	$result = retrieve_data($conn,"SELECT id FROM user WHERE email='".$email."'");
	return $result->fetch_array(MYSQLI_NUM);
}

function swap_connection_data($conn) {
	execute_query($conn,"USE prayerorder");

	$result = retrieve_data($conn,"SELECT * FROM connection");

	foreach ($result as $x) {
		
		$follower = get_user_id($conn,$x['follower']);
		$followee = get_user_id($conn,$x['followee']);
		echo $x['follower']."  ".$follower[0]." - ".$x['followee']." ".$followee[0]."\n";
		execute_query($conn,"USE po_prayer");
		execute_query($conn,"INSERT INTO connection(follower,followee,followType,regdate) VALUES ('".$follower[0]."','".$followee[0]."','".$x['followType']."','".$x['regdate']."')");
	}
}

function swap_reaction_data($conn) {
	execute_query($conn,"USE prayerorder");
	$result = retrieve_data($conn,"SELECT * FROM reaction");

	foreach ($result as $x) {
		execute_query($conn,"USE prayerorder");
		$result = retrieve_data($conn,"SELECT postdate FROM prayer WHERE prayerkey='".$x['prayerkey']."'");
		$prayer_date = $result->fetch_array(MYSQLI_NUM)[0];

		execute_query($conn,"USE po_user");
		$reactor = get_user_id($conn,$x['reactor'])[0];

		if (strlen(trim($reactor))>0) {
			execute_query($conn,"USE po_prayer");
			$result = retrieve_data($conn,"SELECT prayerkey FROM prayer WHERE postdate='".$prayer_date."'");
			$prayer_key = $result->fetch_array(MYSQLI_NUM)[0];
			execute_query($conn,"INSERT INTO reaction(prayerkey,reactor,reaction) VALUES ('".$prayer_key."','".$reactor."','".$x['reaction']."')");
		}

	}
}

function swap_group_data($conn) {
	execute_query($conn,"USE prayerorder");
	$result = retrieve_data($conn,"SELECT * FROM prayergroups");

	foreach($result as $x) {
		execute_query($conn,"USE po_user");
		$owner = get_user_id($conn,$x['creator'])[0];
		execute_query($conn,"USE po_prayer");
		$groupKey = uniqid();
		execute_query($conn,"INSERT INTO prayergroups(groupKey,groupName,isPrivate,creator,createDate) VALUES ('".$groupKey."','".$x['groupName']."',
					'".$x['isPrivate']."','".$owner."','".$x['createDate']."')");
		execute_query($conn,"USE prayerorder");
		$result = retrieve_data($conn,"SELECT * FROM groupMembers WHERE groupKey='".$x['groupKey']."'");
		foreach ($result as $y) {
			execute_query($conn,"USE po_user");
			$user = get_user_id($conn,$y['email'])[0];
			execute_query($conn,"USE po_prayer");
			$admin = 0;
			if ($y['memberType'] == 'c' || $y['memberType']=='a') {
				$admin = 1;
			}
			execute_query($conn,"INSERT INTO groupMembers(groupKey,user,isAdmin,memberType) VALUES ('".$groupKey."','".$user."','".$admin."','".$y['memberType']."')");
		}
	}
}

function swap_nonuser_reactions($conn) {
	execute_query($conn,"USE prayerorder");
	$result = retrieve_data($conn,"SELECT * FROM reaction");

	foreach($result as $x) {

		if (strlen($x['reactor'])<4) {
			print_r($x);
			$result = retrieve_data($conn,"SELECT postdate FROM prayer WHERE prayerkey='".$x['prayerkey']."'");
			$prayer_date = $result->fetch_array(MYSQLI_NUM);
			print_r($prayer_date);
			if(isset($prayer_date[0])) {
				execute_query($conn,"USE po_prayer");
				$result = retrieve_data($conn,"SELECT prayerkey FROM prayer WHERE postdate='".$prayer_date[0]."'");
				$prayer_key = $result->fetch_array(MYSQLI_NUM)[0];
				execute_query($conn,"INSERT INTO reaction(prayerkey,reactor,reaction) VALUES ('".$prayer_key."','".$x['reactor']."','".$x['reaction']."')");
			}
		}
	}
}

/* 20 June 2025 - Created File
 * 25 June 2025 - Added script to swap prayer details
 * 10 July 2025 - Added script to swap reaction and connection data
 * 14 July 2025 - Completed moving data
 * 18 July 2025 - Moved non user reactions
*/
?>