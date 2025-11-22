<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 13 November 2025
Update: 13 November 2025
Version: 1.0
*/

include_once '../database/db_user_ro.php';
include_once '../database/db_user_rw.php';


class SignupService {

    private static $db_user_ro;
    private static $db_user_rw;

    // Initialize DB objects once
    public static function init() {
        self::$db_user_ro = new db_user_ro();
        self::$db_user_rw = new db_user_rw();
    }

    public static function register_user($name, $email, $phone, $password) {

    	$signup_success = true;

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$signup_success = false;
		} else {

			//Check if phone & email are already used - returns error if it has
			if (self::$db_user_ro->check_value("email",$email) || self::$db_user_ro->check_value("phone",$phone)) {
				$signup_success = false;
			} else {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$user_id = bin2hex(random_bytes(16));
				$signup_success = self::$db_user_rw->add_user($user_id,$name,$email,$phone,$hashed_password);
			}
		}
		return $signup_success;
    }
}

/*
13 November 2025 - Created File
*/
?>