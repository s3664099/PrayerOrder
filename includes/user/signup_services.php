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

$NAME_LENGTH = 50;
$PHONE_LENGTH = 10;
$EMAIL_LENGTH = 200;

class SignupService {

	$db_user_ro = new db_user_ro();
	$db_user_rw = new db_user_rw();

    public static function registerUser($name, $email, $phone, $password) {

    	$signup_failure = false;

		//Validates email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$emailErr = "Invalid email format";
	 		$signup_failure = false;
		} else {

			//Check if phone & email are already used - returns error if it has
			if ($db_user_ro->checkValue("email",$email) || $db_user_ro->checkValue("phone",$phone)) {
				$signup_failure = true;
			} else {
				$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$user_id = bin2hex(random_bytes(16));
				$signup_failure = $db_user_rw->add_user($user_id,$name,$email,$phone,$hashed_password);
			}
		}
		return $signup_failure;
    }
}

/*
13 November 2025 - Created File
*/
?>