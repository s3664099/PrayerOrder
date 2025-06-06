<?php
/*
File: PrayerOrder Title page
Author: David Sarkies 
#Initial: 25 February 2024
#Update: 12 April 2025
#Version: 1.2
*/

if (!isset($_SESSION)) {
	session_start();
}

?>
<div class="title-bar">
	<?php
		if (isset($_SESSION['user'])) {
			?>
				<span class="user_login"><img id="avatar" alt="user_image" width="30" src="./Images/Avatar/user.png">
					<h2 id="user_name">
			<?php
			echo $_SESSION['name'];
			?>
				</h2></span>
			<?php
		}
	?>

	<?php
		if (isset($_SESSION['user'])) {
			echo "<button class='title-button' onclick='homePage()'>";
		}
	?>

    <img id="title_image" alt="Placeholder" class="logo
    <?php
    	if (!isset($_SESSION['user'])) {
    		?>
    		 sign_out
    		<?php
    	}
    ?>"
	     src="./Images/icon/title.png">
	 <?php


	 	if (isset($_SESSION['user'])) {

			echo "</button><button onclick='sign_out();' class='sign-out'>Sign Out</button>";
		}
	?>
</div>
<?php
/*
25 February 2024 - created file
2 March 2024 - Added a signout button
15 September 2024 - Added user name to title bar when user logged in.
17 September 2024 - Added User avatar placeholder image
5 December 2024 - Increased version
27 March 2025 - Added button to title
12 April 2025 - Added function to title for home redirect
*/
?>