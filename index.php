<?php
/*
File: PrayerOrder Main File
Author: David Sarkies 
Initial: 10 November 2023
Update: 15 May 2025
Version: 1.4

*/
session_start();

if (isset($_SESSION['user'])) {
	header("Location: main.php");
	exit;
} else {
	header("Location: signin.php");
	exit;
}

/*
Icons
<a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Smashicons - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/search" title="search icons">Search icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/people" title="people icons">People icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/clear" title="clear icons">Clear icons created by icon wind - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/user-follow" title="user follow icons">User follow icons created by SBTS2018 - Flaticon</a> - Followed By
<a href="https://www.flaticon.com/free-icons/follow" title="follow icons">Follow icons created by Handicon - Flaticon</a> - Follow
<a href="https://www.flaticon.com/free-icons/follow" title="follow icons">Follow icons created by Handicon - Flaticon</a> - Following
<a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Freepik - Flaticon</a> - Friends
<a href="https://www.flaticon.com/free-icons/block-user" title="block user icons">Block user icons created by zafdesign - Flaticon</a> - Block
<div> Icons made by <a href="https://www.flaticon.com/authors/meaicon" title="meaicon"> meaicon </a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com'</a></div>
<a href="https://www.flaticon.com/free-icons/pray" title="pray icons">Pray icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/praise" title="praise icons">Praise icons created by Adury5711 - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/user" title="user icons">User icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/group" title="group icons">Group icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/culture" title="culture icons">Culture icons created by justicon - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/idea" title="idea icons">Idea icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/settings" title="settings icons">Settings icons created by riajulislam - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/back" title="back icons">Back icons created by Jesus Chavarria - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/obligation" title="obligation icons">Obligation icons created by shmai - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/invitation" title="invitation icons">Invitation icons created by Freepik - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/invitation" title="invitation icons">Invitation icons created by Muhammad Atif - Flaticon</a>
<a href="https://www.flaticon.com/free-icons/messege" title="messege icons">Messege icons created by Nur syifa fauziah - Flaticon</a>

10 November 2023 - Created File
11 November 2023 - Set file run
5 December 2024 - Increased version
8 February 2025 - Added create group icon
14 February 2025 - Added Admin Icon
19 February 2025 - Added Back, Prayer Group & Invite Icons
11 May 2025 - Added send invite icon
15 May 2025 - Added accept invite icon
*/
?>