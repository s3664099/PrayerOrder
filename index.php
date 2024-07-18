<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 11 November 2023
Version: 0.1

- Sign Up Page	- Sign-up creates a new account
                - Validates proper Email
                - Confirms that email & Phone not being used
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