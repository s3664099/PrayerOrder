<?php
/*
File: PrayerOrder Authenticate Functions
Author: David Sarkies 
Initial: 15 November 2025
Update: 15 November 2025
Version: 1.3
*/

require_once __DIR__ . '/../database/db_user_ro.php';

class authServices {
	private static $db_user_ro;

    // Initialize DB objects once
    public static function init() {
        self::$db_user_ro = new db_user_ro();
    }

}



/*
15 November 2025 - Created File
*/