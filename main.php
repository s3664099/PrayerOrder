<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 28 September 2024
Version: 0.3
*/

include 'includes/redirect_signin.php';

?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/header.php'?>
      <script type="text/javascript" src="/js/prayer_page.js"></script>
      <link type="text/css" rel="stylesheet" href="./css/prayer_page.css">
   </head>
   <body>
      <?php include 'includes/title.php'?>
      <div class="main-section">
         <div class="prayer-header">
            <div>
               <img src="./Images/search.png" width="20" alt="search" id="search-icon"
                    onClick="switchSearch(),clearSearch()">
               <span id="search-box">
                  <input id="search-input" type="text" onkeyup="find_user(this)">
                  <button onClick="clearSearch()">X</button>
               </span>
               <span id="options-box"></span>
               <img src="./Images/group.png" width="20" alt="group" id="group-icon">
            </div>
            <div id="search_results"></div>
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
22 September 2024 - Added styling for search box
28 September 2024 - Added function call to clear search results
*/
?>