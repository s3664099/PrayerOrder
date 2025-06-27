<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 20 June 2025
Update: 26 June 2025
Version: 1.1
*/

include 'db_handler.php';

//execute query
function execute_query($conn,$sql) {

	if ($conn->query($sql) === TRUE) {
		echo "Query Executed successfully";
	} else {
  		echo "Executing query: " . $conn->error;
	}
}

function create_user_db($conn) {

	$db = new db_handler();
	$conn = $db->get_connection();

	execute_query($conn,"DROP DATABASE po_user");
	execute_query($conn,"CREATE DATABASE po_user");
	execute_query($conn,"USE po_user");


}

function setup_user_db($conn) {

	//Drop tables
	execute_query($conn,"DROP TABLE user");
	execute_query($conn,"DROP TABLE connection");
	execute_query($conn,"DROP TABLE groupMembers");
	execute_query($conn,"DROP TABLE prayergroups");

 	//Create tables
	execute_query($conn,"CREATE TABLE user(id VARCHAR(20) NOT NULL UNIQUE, name VARCHAR(50),email VARCHAR(200),
						 phone VARCHAR(10), password VARCHAR(65), regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
						 images VARCHAR(50PRIMARY KEY(id))");
	execute_query($comm,"CREATE TABLE connection(follower VARCHAR(20),followee VARCHAR(20),followType INT(1),
						 regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(follower,followee),FOREIGN KEY(
						 follower) REFERENCES user(email),FOREIGN KEY(followee) REFERENCES user(email))");
	execute_query($conn,"CREATE TABLE prayergroups(groupKey VARCHAR(20) NOT NULL UNIQUE, groupName VARCHAR(150), 
						 isPrivate BOOLEAN, creator VARCHAR(20),createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,	
						 FOREIGN KEY (creator) REFERENCES user(id), PRIMARY KEY(groupKey))");

	#member type - m - member, p - pending, b - blocked, c - creator, a - admin
	execute_query($conn,"CREATE TABLE groupMembers(groupKey VARCHAR(20) NOT NULL,user VARCHAR(20) NOT NULL, 
						 isAdmin BOOLEAN, memberType VARCHAR(1), PRIMARY KEY (groupKey,user), FOREIGN KEY 
						 (groupKey) REFERENCES prayergroups(groupKey), FOREIGN KEY (user) REFERENCES user(id))");

	//Add table that generates session data. The data is removed after a set amount of time
}

function create_prayer_db($conn) {
	execute_query($conn,"DROP DATABASE po_prayer");
	execute_query($conn,"CREATE DATABASE po_prayer");
	execute_query($conn,"USE po_prayer");
}

function setup_prayer_db($conn) {

	//Drop tables
	execute_query($conn,"DROP TABLE prayer");
	execute_query($conn,"DROP TABLE reaction");

	//Create Tables
	execute_query($conn,"CREATE TABLE prayer(userkey VARCHAR(20) NOT NULL, postdate DATETIME, prayerkey VARCHAR(20)
						 NOT NULL UNIQUE, PRIMARY KEY(userkey,prayerkey)");
	execute_query($conn,"CREATE TABLE reaction(prayerkey VARCHAR(20) NOT NULL, reactor VARCHAR(20) NOT NULL, 							 reaction INT(1),PRIMARY KEY(prayerkey,reactor), FOREIGN KEY(prayerkey) 
						 REFERENCES prayer(prayerkey)");
}

$db = new db_handler('db_login.json');
$conn = $db->get_connection();

echo "Hello\n";
$id = uniqid();
echo $id."\n";
echo strlen($id)."\n";

/*
20 June 2025 - Created File
26 June 2025 - Moved sql into functions and created user and prayer db
*/
?>