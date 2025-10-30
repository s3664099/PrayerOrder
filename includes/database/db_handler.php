<?php
/*
File: PrayerOrder DB builder functions
Author: David Sarkies 
Initial: 20 June 2025
Update: 30 October 2025
Version: 1.4
*/

class db_handler {
	
	private $conn;
	private $servername;
	private $dbname;

	/* ====================================================================================
	 * =                              Constructor
	 * ====================================================================================
	 */
	function __construct($login_file) {

		// Load and decode JSON file
		$json = @file_get_contents($login_file);
		if ($json === false) {
			throw new Exception("Failed to read login file: $login_file");
		}
		
		$json_data = json_decode($json, true);
		if (!is_array($json_data)) {
			throw new Exception("Invalid JSON in login file: $login_file");
		}

		// Validate required keys
		$required = ['host', 'user', 'pw', 'dbname'];
		foreach ($required as $key) {
			if (!array_key_exists($key, $json_data)) {
				throw new Exception("Missing '$key' in login file: $login_file");
			}
		}		

		$servername = $json_data['host'];
		$username = $json_data['user'];
		$password = $json_data['pw'];
		$dbname = $json_data['dbname'];

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		$this->conn->set_charset('utf8mb4');
		$this->servername = $servername;
		$this->dbname = $dbname;

		// Check connection
		if ($this->conn->connect_errno) {
    		throw new Exception("Connection failed: " . $this->conn->connect_error);
		}


	}

	/* ====================================================================================
	 * =                              Getters
	 * ====================================================================================
	 */
	function get_connection() {
		return $this->conn;
	}

	function get_host() {
		return $this->servername;
	}

	function get_name() {
		return $this->dbname;
	}

	/* ====================================================================================
	 * =                              Cleanup
	 * ====================================================================================
	 */
	function close_connection() {
		$this->conn->close();
	}
}

/*
20 June 2025 - Created File
30 June 2025 - Fixed errors
6 July 2025 - Moved file to DB include
28 October 2025 - Cleaned up code and added error handling
30 October 2025 - Placed DB name in got to be retrieved and set up without magic numbers
*/
?>