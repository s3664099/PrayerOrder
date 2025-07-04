<?php
/*
File: PrayerOrder DB update user db
Author: David Sarkies 
Initial: 4 July 2025
Update: 4 July 2025
Version: 1.0
*/

include 'db_handler.php';

$failed = False;
$db = new db_handler('db_root.json');
$conn = $db->get_connection();

$users = get_users($conn,'prayerorder');

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


function get_users($conn,$db_name) {
	execute_query($conn,"USE ".$db_name);
	$result = retrieve_data($conn,"SELECT * FROM user");

	$users = array();

	foreach ($result as $x) {
		array_push($users,array(
			'Id'=>uniqid(),
			'Name'=>$x['name'],
			'Email'=>$x['email'],
			'Phone'=>$x['phone'],
			'Regdate'=>$x['regdate'],
			'Password'=>$x['password'],
			'Image'=>$x['image'],
		));
	}

	foreach($users as $x) {
		print_r($x);
	}
	
}

/*
	Select All From user
	Add user id
	move details into a dictionary
	Add to new DB.
*/


/*
po_prayer
po_user
prayerorder
*/

/* 4 July 2025 - Created File
*/
?>