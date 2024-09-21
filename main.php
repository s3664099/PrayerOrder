<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 21 September 2024
Version: 0.2
*/

include 'includes/redirect_signin.php';

?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/prayer_page.css">
   </head>
   <body>
      <?php include 'includes/title.php'?>
      <div class="main-section">
         <div class="prayer-header">
            <img src="./Images/search.png" width="30" alt="search" id="search-icon">
            <span id="search-box">
               <input type="text"></span>
            </span>
            <spah id="options-box"></spah>
            <img src="./Images/group.png" width="30" alt="group" id="group-icon">
         </div>
         <h3 class="ask-prayer">Ask for Prayer</h3>
         <textarea class="prayer-box"></textarea>
      </div>
  </body>

<?php
/*
25 February 2024 - Created file
2 March 2024
21 September 2024 - Added the main section
*/
?>