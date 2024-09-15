<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 11 November 2023
Version: 0.1

- Also, have a common include that basically flicks anything to the index when there is no session.
- Main page - buttpns post content & find friends.
        - Style Name and add Icon in title

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