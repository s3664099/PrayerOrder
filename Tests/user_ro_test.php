<?php
/*
File: PrayerOrder Test ro_user db calls
Author: David Sarkies 
#Initial: 11 September 2026
#Update: 11 September 2026
#Version: 2.7
*/

use PHPUnit\Framework\TestCase;

class db_user_ro_test extends TestCase {

    private $db_user_ro;

    protected function setUp(): void {
        $this->db_user_ro = new db_user_ro();
    }

    public function testGetPasswordExistingUser() {

        $result = $this->db_user_ro->get_password(
            "peter@porcupine.com"
        );

        $this->assertEquals(
            "expected-password",
            $result
        );
    }
}

/*
get_password
    ✓ existing email
    ✓ nonexistent email
    ✓ empty email

check_value
    ✓ existing email
    ✓ nonexistent email
    ✓ existing phone
    ✓ nonexistent phone
    ✓ non-"phone" variable behaves as email

get_user_name
    ✓ existing email
    ✓ nonexistent email
    ✓ empty email

get_user_details
    ✓ existing email
    ✓ returns name and id
    ✓ nonexistent email

get_prayer_user
    ✓ existing ID
    ✓ returns name and images
    ✓ nonexistent ID returns false

get_users
    ✓ matching name
    ✓ partial name
    ✓ case variation
    ✓ excludes current user
    ✓ maximum 5 results
    ✓ no matches
    ✓ % treated literally
    ✓ _ treated literally

11 September 2026 - created file
*/

?>