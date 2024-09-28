<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 11 November 2023
Version: 0.1

- Also, have a common include that basically flicks anything to the index when there is no session.
- Main page - buttpns post content & find friends.

*/
    session_start();

    if (isset($_SESSION['user'])) {
    	header("Location: main.php");
    } else {
		header("Location: signin.php");
    }
/*
Icons
<a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Smashicons - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/search" title="search icons">Search icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/people" title="people icons">People icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/clear" title="clear icons">Clear icons created by icon wind - Flaticon</a>

10 November 2023 - Created File
11 November 2023 - Set file run
*/
?>