<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 20 June 2025
Update: 20 June 2025
Version: 1.0
*/

class db_handler {
	
	private $conn;

	/* ====================================================================================
	 * =                              Constructor
	 * ====================================================================================
	 */
	function __construct($login_file) {

		$json = file_get_contents($login_file);
		$json_data = json_decode($json,true);

		$servername = $json_data['name'];
		$username = $json_data['user'];
		$password = $json_data['pw'];
		$dbname = $json_data['dbname'];

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 
	}

	function get_connection() {
		return $this->conn;
	}

	function close_connection() {
		$this->conn->close();
	}

}

/*
20 June 2025 - Created File
*/
?>