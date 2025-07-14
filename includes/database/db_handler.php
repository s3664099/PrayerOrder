<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 20 June 2025
Update: 6 July 2025
Version: 1.2
*/

class db_handler {
	
	private $conn;

	/* ====================================================================================
	 * =                              Constructor
	 * ====================================================================================
	 */
	function __construct($login_file) {
		error_log(getcwd());
		$json = file_get_contents($login_file);
		$json_data = json_decode($json,true);

		$servername = $json_data['name'];
		$username = $json_data['user'];
		$password = $json_data['pw'];
		$dbname = $json_data['dbname'];

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		$this->servername = $servername;

		// Check connection
		if ($this->conn-> connect_errno) {
		  die("Connection failed: " . $conn->connect_error);
		} 
	}

	function get_connection() {
		return $this->conn;
	}

	function get_host() {
		return $this->servername;
	}

	function close_connection() {
		$this->conn->close();
	}

}

/*
20 June 2025 - Created File
30 June 2025 - Fixed errors
6 July 2025 - Moved file to DB include
*/
?>