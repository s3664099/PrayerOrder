<?php
/*
File: PrayerOrder Group Error Include
Author: David Sarkies 
Initial: 6 May 2025
Update: 6 May 2025
Version: 1.0
*/

function groupExistsError() {
	if (isset($_SESSION['group_exists'])) {
        unset($_SESSION['group_exists']);
        ?>
            <div class="error">Group Exists</div>
        <?php
    }
}

/* 6 May 2025 - Created File
*/