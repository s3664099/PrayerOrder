<?php
/*
File: PrayerOrder Authenticate Functions
Author: David Sarkies 
Initial: 15 November 2025
Update: 15 November 2025
Version: 1.3
*/

include_once '../database/db_user_ro.php';

class authServices {
	private static $db_user_ro;

    // Initialize DB objects once
    public static function init() {
        self::$db_user_ro = new db_user_ro();
    }

    function authenticate_user($email,$password) {
    	$authenticated = false;
    	$stored_password = self::$db_user_ro->getPassword($email);

    	if (password_verify($password, $stored_password)) {
			$authenticated = true;
		}
		return $authenticated;
    }

    function get_user_details($email) {
    	return self::$db_user_ro->getUserDetails($email);
    }
}

/*
15 November 2025 - Created File
*/