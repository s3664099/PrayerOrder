<?php
/*
File: PrayerOrder Title page
Author: David Sarkies 
#Initial: 25 February 2024
#Update: 6 January 2026
#Version: 1.4
*/

if (!isset($_SESSION)) {
	session_start();
	if (!isset($_SESSION['csrf_token'])) {
    	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
}

$logged_in = isset($_SESSION['user']);

?>
<div class="title-bar">
	<?php
		if ($logged_in) {
			?>
				<span class="user_login"><img id="avatar" alt="user_image" width="30" src="./Images/Avatar/user.png">
					<span id="user_name">
				 		<?= htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') ?>
					</span>
				</span>
			<?php
		}
	?>

	<?php
		if ($logged_in) {
			?>
				<button class='title-button' onclick='homePage()'>
			<?php
		}
	?>

    <img id="title_image" alt="Placeholder" 
    	 class="logo <?= $logged_in ? '':'sign_out'?>"
	     src="./Images/icon/title.png">
	 <?php


	 	if ($logged_in) {
	 		?>
				</button><button onclick='sign_out();' class='sign-out'>Sign Out</button>
			<?php
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
2 January 2026 - Fixed issues. Change h2 to span.
6 Jnauary 2026 - Added crsf token
*/
?>