<?php
/*
File: PrayerOrder Authenticate Error Include
Author: David Sarkies 
Initial: 6 May 2025
Update: 6 May 2025
Version: 1.0
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
	if (isset($_SESSION['value'])) {
    	?>
            <div class="error">
            	<?php
					if(isset($_SESSION['email_exists']) || isset($_SESSION['phone_exists'])) {
                        ?>
                           Sign Up Failed
                        <?php
                    	unset($_SESSION['email_exists']);
                        unset($_SESSION['phone_exists']);
                     }
                ?>
            </div>
        <?php
        unset($_SESSION['value']);
    }
}


/* 6 May 2025 - Create File
*/
?>