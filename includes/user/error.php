<?php
/*
File: PrayerOrder Authenticate Error Include
Author: David Sarkies 
Initial: 6 May 2025
Update: 11 November 2025
Version: 1.2
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
	if (isset($_SESSION['signup_errors'])) {
    	?>
            <div class="error">
            	<?php
					if(($_SESSION['signup_errors']['email_exists']) || ($_SESSION['signup_errors']['phone_exists']) || 
                       ($_SESSION['signup_errors']['signup_success'])) {
                        ?>
                           Sign Up Failed
                        <?php
                    	   unset($_SESSION['signup_errors']);
                     }
                ?>
            </div>
        <?php
    }
}


/* 6 May 2025 - Create File
 * 30 October 2025 - Added flag for signin failure
 * 11 November 2025 - Added single session flag for signup failures
*/
?>