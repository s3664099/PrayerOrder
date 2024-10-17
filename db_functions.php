<?php

/*
File: PrayerOrder db functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 17 October 2024
Version: 0.6
*/

class db_functions {

	private $conn;

	function __construct() {
	
		//Loads authentication for json file
		$json = file_get_contents('Database/db_login.json');
		$json_data = json_decode($json,true);

		$servername = $json_data['name'];
		$username = $json_data['user'];
		$password = $json_data['pw'];
		$dbname = $json_data['dbname'];

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($this->conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 
	}

	function add_user($name,$email,$phone,$password) {
		$stmt = $this->conn->prepare("INSERT INTO user (name, email, phone,password) VALUES (?, ?, ?,?)");
		$stmt->bind_param("ssss",$name, $email , $phone, $password);
		$stmt->execute();
	}

	function authenticate_user($email,$password) {

		$authenticated = False;
		$sql = "SELECT * FROM user WHERE email=? AND password=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows == 1) {
			$authenticated = True;
		}

		return $authenticated;
	}

	function retrieve_data() {

		$sql = "SELECT * FROM user";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
		    error_log(print_r($row, true));
		}		

	}

	function checkValue($var,$value) {

		$value_exists = false;
		$sql = "SELECT * FROM user WHERE email=?";

		if ($var=="phone") {
			$sql = "SELECT * FROM user WHERE phone=?";
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$value);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$value_exists = true;
		}

		return $value_exists;
	}

	function getUserName($email) {

		$sql = "SELECT name FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();
		$userName = $result->fetch_assoc()['name'];

		return $userName;
	}

	function getUsers($name) {

		$name = "%" . $name . "%";
		$sql = "SELECT name,email FROM user WHERE name LIKE ? LIMIT 5";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$name);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

	/* Connection Types
		0) No Connection (there will none of 0, but exists for getConnectionType)
		1) Following
		2) Friends
		3) Blocked
	*/
	function addRelationship($follower,$followee) {

		$result = $this->getRelationship($follower,$followee);

		//Checks if connection exists
		if($result->num_rows>0) {

			//Are they following - makes friends
			if ($result->fetch_assoc()['followType']==1) {
				//updates follow type = 2
				error_log("friends");
			}

			//Otherwise returns an error
			//Makes sure that not blocked, if blocked does nothing

		} else {
			$this->updateRelationship($follower,$followee,1);
			error_log("Following");
		}
	}

	function updateRelationship($follower,$followee,$relType) {

		$follower = "%".$follower."%";
		$followee = "%".$followee."%";
		$stmt="";

		if ($relType==1) {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) VALUES (?,?,?)");
			$stmt->bind_param("sss",$follower,$followee,$relType);
		}
		$stmt->execute();
	}

	function getRelationship($follower,$followee) {

		$follower = "%".$follower."%";
		$followee = "%".$followee."%";
		$sql = "SELECT followType FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();
		
		return $stmt->get_result();
	}

	//Block user

	//Delete relationship
}

/*
27 July 2024 - Created file
12 September 2024 - Added check value function
13 September 2024 - Got check value working
15 September 2024 - Added function to retrieve user name for database
26 September 2024 - Retrieve users with matching name
1 October 2024 - Added code to retrieve email with search
6 October 2024 - Added notes for connection table
*/
?>