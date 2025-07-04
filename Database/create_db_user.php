<?php
/*
File: Database User Creator
Author: David Sarkies
Initial: 2 June 2025
Update: 3 June 2025
Version: 4.1

Usage: Requires two arguments
php create_user.php [schema name] [user code] [json file name default db_new.json] [RW for readwrite else RO for read only]
*/

include 'db_handler.php';

$failed = False;
$db = new db_handler('db_root.json');
$conn = $db->get_connection();

if (!validate_args($argv)) {
	create_user($argv,$conn,$db->get_host());
}

function generatePassword($n) {
	
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
		echo "Query Executed successfully\n";
	} else {
  		echo "Executing query: " . $conn->error."\n";
	}
}

function validate_args($argv) {

	$failed = false;

	if(count($argv)<2) {
		print("You must include the database name.\n");
		$failed = True;
	}

	if(count($argv)<3) {
		print("You must include a code for the user.\n");
		$failed = True;
	}

	return $failed;
}

function create_user($argv,$conn,$host) {
	$password_size = 80;
	$auth_name = "db_new.json";
	if(count($argv)>3) {
		$auth_name = $argv[3];

		//Check is auth_name ends with json
	}

	//Need to add one for admin user as well.
	$write = "RO";
	if(count($argv)>4){
		if ($argv[4]=="RW"){
			$write = $argv[4];
		}
	}

	$user_name = $argv[2].$write."_".uniqid();
	$password = generatePassword($password_size);

	$json = @file_get_contents($auth_name);

	if ($json) {
		$json_data = json_decode($json,true);
		$old_name = $json_data['User'];

		if ($old_name && strpos($old_name,$argv[2])===0) {
			execute_query($conn,"DROP USER IF EXISTS ".$old_name."@localhost");
		}
	}

	execute_query($conn,"CREATE USER ".$user_name."@localhost IDENTIFIED BY '".$password."'");

	if ($write == "RW") {
		execute_query($conn,"GRANT SELECT,INSERT,UPDATE,DELETE ON ".$argv[1].".* TO '".$user_name."'@'".$host."'");
	} else {
		execute_query($conn,"GRANT SELECT ON ".$argv[1].".* TO '".$user_name."'@'".$host."'");
	}

	$data = array('Name'=>$host,
			 'User'=>$user_name,
			 'password'=>$password,
			 'DB'=>$argv[1],
			 'TimeStamp'=>time(),
			);
	file_put_contents($auth_name, json_encode($data, JSON_PRETTY_PRINT));
}

/*
27 June 2025 - Created file
3 July 2025 - Built random pw and username
			- Completed function to create users

- Update PHP to 8.0+ and change strpos to str_starts_with
*/
?>