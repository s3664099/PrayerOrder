<?php
/*
File: PrayerOrder Group Error Include
Author: David Sarkies 
Initial: 6 May 2025
Update: 15 September 2026
Version: 1.1
*/

function groupExistsError() {
	if (isset($_SESSION['group_exists'])) {
        unset($_SESSION['group_exists']);
        ?>
            <div class="error">Group Exists</div>
        <?php
    } else if (isset($_SESSION['add_failed'])) {
        ?>
            <div class="error">Add Group Failed</div>
        <?php
    }
}

/* 6 May 2025 - Created File
 * 15 September 2026 - Added add group failed
*/