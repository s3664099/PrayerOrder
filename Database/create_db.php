<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 20 June 2025
Update: 29 October 2025
Version: 1.3
*/

include 'db_handler.php';

//execute query
function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
		echo "Query Executed successfully\n";
	} else {
  		echo "Executing query: " . $conn->error."\n";
	}
}

function create_user_db($conn) {
	echo "Drop user database\n";
	execute_query($conn,"DROP DATABASE po_user");
	execute_query($conn,"CREATE DATABASE po_user");
	execute_query($conn,"USE po_user");
}

function setup_user_db($conn) {

	echo "Create user table\n";
 	//Create tables
	execute_query($conn,"CREATE TABLE user(id VARCHAR(40) NOT NULL UNIQUE, name VARCHAR(50),email VARCHAR(200),
						 phone VARCHAR(10), password VARCHAR(65), regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
						 images VARCHAR(50), PRIMARY KEY(id))");

	//Add table that generates session data. The data is removed after a set amount of time
}

function create_prayer_db($conn) {
	echo "Drop prayer database \n";
	execute_query($conn,"DROP DATABASE po_prayer");
	execute_query($conn,"CREATE DATABASE po_prayer");
	execute_query($conn,"USE po_prayer");
}

function setup_prayer_db($conn) {

	echo "connection table\n";
	//Create Tables
	execute_query($conn,"CREATE TABLE connection(follower VARCHAR(40),followee VARCHAR(40),followType INT(1),
						 regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(follower,followee))");

	echo "prayer group table\n";
	execute_query($conn,"CREATE TABLE prayergroups(groupKey VARCHAR(40) NOT NULL UNIQUE, groupName VARCHAR(150), 
						 isPrivate BOOLEAN, creator VARCHAR(20),createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,	
						 PRIMARY KEY(groupKey))");

	#member type - m - member, p - pending, b - blocked, c - creator, a - admin
	echo "Group Member Table\n";
	execute_query($conn,"CREATE TABLE groupMembers(groupKey VARCHAR(40) NOT NULL,user VARCHAR(40) NOT NULL, 
						 isAdmin BOOLEAN, memberType VARCHAR(1), PRIMARY KEY (groupKey,user), FOREIGN KEY 
						 (groupKey) REFERENCES prayergroups(groupKey))");

	echo "Prayer table \n";
	execute_query($conn,"CREATE TABLE prayer(userkey VARCHAR(40) NOT NULL, postdate DATETIME, prayerkey VARCHAR(40)
						 NOT NULL UNIQUE, PRIMARY KEY(userkey,prayerkey))");

	echo "Rection table \n";
	execute_query($conn,"CREATE TABLE reaction(prayerkey VARCHAR(40) NOT NULL, reactor VARCHAR(40) NOT NULL, 
						 reaction INT(1),PRIMARY KEY(prayerkey,reactor), FOREIGN KEY(prayerkey) 
						 REFERENCES prayer(prayerkey))");
}

$db = new db_handler('db_root.json');
$conn = $db->get_connection();

echo "hello\n";

create_user_db($conn);
setup_user_db($conn);
create_prayer_db($conn);
setup_prayer_db($conn);

/*
echo "Hello\n";
$id = uniqid();
echo $id."\n";
echo strlen($id)."\n";


20 June 2025 - Created File
26 June 2025 - Moved sql into functions and created user and prayer db
29 June 2025 - Script works and creates database.
29 October 2025 - Increased size of user key
*/
?>