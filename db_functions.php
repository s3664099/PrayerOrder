<?php

/*
File: PrayerOrder db functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 21 November 2024
Version: 0.9
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
		$hashedPwd = hash("sha256",$password.$email);

		$sql = "SELECT * FROM user WHERE email=? AND password=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$hashedPwd);
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

	//Blocking relationships:
	//	3 - No Relationship Exists
	//	4 - Relationship Exists
	function updateRelationship($follower,$followee,$relType) {

		$stmt="";

		if ($relType==1 || $relType==3 || $relType==5) {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) VALUES (?,?,?)");
			$stmt->bind_param("ssi",$follower,$followee,$relType);
		} else if ($relType==2 || $relType==0 || $relType==4) {

			//Unfollowing a friend
			if($relType==0) {
				$relType = 1;
			} else if ($relType==4) {
				$relType = 3;
			}

			$stmt = $this->conn->prepare("UPDATE connection SET followType=? WHERE follower=? AND followee=?");
			$stmt->bind_param("iss",$relType,$follower,$followee);
		}

		if($stmt->execute()) {
			error_log("Success");
		} else {
			error_log("Failed");
		}
	}

	function getRelationship($follower,$followee) {

		$sql = "SELECT followType FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();
		
		return $stmt->get_result();
	}

	//Delete relationship
	function removeRelationship($follower,$followee) {
		$sql = "DELETE FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();

		return $stmt->get_result();
	}

	//Add prayer metadata
	function addPrayer($user,$postDate,$key) {

		$sql = "INSERT INTO prayer(email,postdate,prayerkey) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$user,$postDate,$key);
		
		if($stmt->execute()) {
			error_log("Success");
		} else {
			error_log("Failure: ".$stmt->error);
		}
	}

	function getPrayer($user) {

		$sql = "SELECT * 
				FROM prayer 
				JOIN user ON prayer.email=user.email 
				JOIN connection ON user.email=connection.follower
				WHERE connection.followee=?";
		$stmt = $this->conn->prepare($sql);

		if(!$stmt) {
			error_log("Error: ".$this->conn->error);
		}

		$stmt->bind_param("s",$user);
		$stmt->execute();

		return $stmt->get_result();
	}
}

/*
27 July 2024 - Created file
12 September 2024 - Added check value function
13 September 2024 - Got check value working
15 September 2024 - Added function to retrieve user name for database
26 September 2024 - Retrieve users with matching name
1 October 2024 - Added code to retrieve email with search
6 October 2024 - Added notes for connection table
17 October 2024 - Added code to read and add to the connections table
19 October 2024 - Moved code to process results from connections table out.
20 October 2024 - Added code to update relationship. Added code to delete relationship
21 November 2024 - Updated authentication to hashed passwords.
*/
?>