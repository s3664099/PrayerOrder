<?php
/*
File: Database User Creator
Author: David Sarkies
Initial: 2 June 2025
Update: 2 June 2025
Version: 4.0

Usage: Requires two arguments
python3 createUser.py [schema name] [user code] [json file name default db_new.json] [RW for readwrite else RO for read only]
*/



$failed = False;

if(count($argv)<2) {
	print("You must include the database name.\n");
	$failed = True;
}

if(count($argv)<3) {
	print("You must include a code for the user.\n");
	$failed = True;
}

$auth_name = "db_new.json";
if(count($argv)>2) {
	$auth_name = $argv[3];
}

$write = False;
if(count($argv)>3){
	if ($argv[4]=="RW"){
		$write = True;
	}
}

var_dump($argv);

/*
27 June 2025 - Created file
*/
?>