<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 11 November 2023
Version: 0.1

- Index 		- Checks session - if present goes straight to main page
								 - otherwise goes to sign in page
- Sign In Page	- sign-in authenticates and saves session
- Sign Up Page	- Sign-up creates a new account
				- Validate the form - so all needs to be filled out
                - password and confirm password needs to be the same
- Sign out function
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