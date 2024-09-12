<?php

/*
File: PrayerOrder db functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 27 July 2024
Version: 0.0
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

	function checkValue($var,$value) {

		$value_exists = false;
		$sql = "SELECT * FROM user WHERE ?=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$var,$value);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 1) {
			$value_exists = true;
			error_log("Working");
		}

		return $value_exists;
	}
}

/*
27 July 2024 - Created file
*/
?>