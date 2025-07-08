<?php
/*
File: PrayerOrder User messages
Author: David Sarkies 
Initial: 8 July 2023
Update: 8 July 2025
Version: 1.0
*/

function signUpSuccess() {
	if (isset($_SESSION['signup_success'])) {
        unset($_SESSION['signup_success']);
        ?>
            <div class="message">Successful Signup - Sign in to continue</div>
        <?php
    }
}

/* 8 July 2025 - Created file
*/
?>