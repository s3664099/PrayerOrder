<?php
/*
File: PrayerOrder Authenticate Functions
Author: David Sarkies 
Initial: 15 November 2025
Update: 22 November 2025
Version: 1.4
*/

include_once '../database/db_user_ro.php';

class auth_services {
	private $db_user_ro;

    // Initialize DB objects once
    function __construct() {
        $this->$db_user_ro = new db_user_ro();
    }

    function authenticate_user($email,$password) {
    	$authenticated = false;
    	$stored_password = $this->$db_user_ro->get_password($email);

    	if (password_verify($password, $stored_password)) {
			$authenticated = true;
		}
		return $authenticated;
    }

    function get_user_details($email) {
    	return $this->$db_user_ro->get_user_details($email);
    }
}

/*
15 November 2025 - Created File
22 November 2025 - Changed function names for consistency
                   Removed static
*/