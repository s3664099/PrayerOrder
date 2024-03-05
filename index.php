<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 11 November 2023
Version: 0.1

- If Password Incorrect sends error message back to sign-in page
                - https://stackoverflow.com/questions/66927134/can-i-pass-variables-in-hyperlink-without-using-url-in-php-for-use-in-a-table
- Sign In Page	- sign-in authenticates and saves session
- Sign Up Page	- Sign-up creates a new account
				- Validate the form - so all needs to be filled out
                - password and confirm password needs to be the same
- Sign out function
- Sign In Page	- reads from DB and authenticates user
- Also, have a common include that basically flicks anything to the index when there is no session.

*/
    session_start();

    if (isset($_SESSION['user'])) {
    	header("Location: main.php");
    } else {
		header("Location: signin.php");
    }
/*
10 November 2023 - Created File
11 November 2023 - Set file run
*/
?>