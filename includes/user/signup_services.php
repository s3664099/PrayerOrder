<?php
/*
File: PrayerOrder Create User Program
Author: David Sarkies 
Initial: 13 November 2025
Update: 16 December 2026
Version: 1.3
*/

include_once '../database/db_user_ro.php';
include_once '../database/db_user_rw.php';


class Signup_service {

    private $db_user_ro;
    private $db_user_rw;

    // Initialize DB objects once
    public function __construct() {
        $this->db_user_ro = new db_user_ro();
        $this->db_user_rw = new db_user_rw();
    }

    public function register_user($name, $email, $phone, $password) {

    	$signup_success = true;


		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || trim($name) == '' || trim($email) == '' || trim($phone) == '' || trim($password) == '') {
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
23 December 2025 - Removed static nature of class
16 January 2026 - Added validation for blank
*/
?>