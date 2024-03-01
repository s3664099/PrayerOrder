<?php
/*
File: PrayerOrder Title page
Author: David Sarkies 
#Initial: 25 February 2024
#Update: 2 March 2024
#Version: 0.2
*/

session_start();
?>
<div class="title-bar">
    <img id="title_image" alt="Placeholder" class="logo" 
	     src="./Images/title.png">
	 <?php
	 	if (isset($_SESSION['user'])) {
			echo "<button onclick='sign_out();'>Sign Out</button>";
		}
	?>
</div>
<?php
/*
25 February 2024 - created file
2 March 2024 - Added a signout button
*/
?>