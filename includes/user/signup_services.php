<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 13 November 2025
Update: 22 November 2025
Version: 1.1
*/

include_once '../database/db_user_ro.php';
include_once '../database/db_user_rw.php';


class SignupService {

    private $db_user_ro;
    private $db_user_rw;

    // Initialize DB objects once
    public static function init() {
        $this->db_user_ro = new db_user_ro();
        $this->db_user_rw = new db_user_rw();
    }

    public static function register_user($name, $email, $phone, $password) {

    	$signup_success = true;

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$signup_success = false;
		} else {

			//Check if phone & email are already used - returns error if it has
			if ($this->db_user_ro->check_value("email",$email) || $this->db_user_ro->check_value("phone",$phone)) {
				$signup_success = false;
			} else {
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$user_id = bin2hex(random_bytes(16));
				$signup_success = $this->db_user_rw->add_user($user_id,$name,$email,$phone,$hashed_password);
			}
		}
		return $signup_success;
    }
}

/*
13 November 2025 - Created File
22 November 2025 - Removed static
*/
?>