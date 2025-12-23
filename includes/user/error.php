<?php
/*
File: PrayerOrder Authenticate Error Include
Author: David Sarkies 
Initial: 6 May 2025
Update: 13 November 2025
Version: 1.3
*/

function signInError() {
	if (isset($_SESSION['failed'])) {
        unset($_SESSION['failed']);
        ?>
            <div class="error">Login Failed</div>
        <?php
    }
}

function signUpError() {
	if (isset($_SESSION['signup_failed'])) {
      unset($_SESSION['signup_failed']);
    	?>
         <div class="error">Sign Up Failed</div>
      <?php
    }
}


/* 6 May 2025 - Create File
 * 30 October 2025 - Added flag for signin failure
 * 11 November 2025 - Added single session flag for signup failures
 * 13 November 2025 - Updated code to signup_success
 * 23 December 2025 - Fixed signUpError to make it less brittle
*/
?>