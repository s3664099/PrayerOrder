<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 5 December 2024
Version: 1.0
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
            <div>
               <img src="./Images/icon/search.png" width="20" alt="search" id="search-icon" 
                    onClick="switchSearch(),clearSearch()">
               <span id="search-box">
                  <input id="search-input" type="text" onkeyup="find_user(this)">
                  <img src="./Images/icon/clear.png" width="20" alt="clear" onClick="clearSearch()">
               </span>
               <span id="options-box"></span>
               <img src="./Images/icon/group.png" width="20" alt="group" id="group-icon">
            </div>
            <div id="search_results"></div>
         </div>
         <div id="prayer-ask">
            <h3 class="ask-prayer">Ask for Prayer</h3>
            <h4 class="prayer-error-box prayer-box-error" id="error-field"></h4>
            <form method="post" action="<?php echo htmlspecialchars('pray.php');?>" id="pray">
               <div class="submitPrayer">
                  <textarea class="prayer-box" name="prayer" id="prayer" onfocus="enlarge();" onfocusout="shrink();">
                  </textarea>
                  <button class="sendButton" onclick="sendPrayer()">
                    <img width="20" src="./Images/icon/submit.png" alt="send prayer">
                  </button>
               </div>
            </form>
         </div>
         <div class="prayer-request-box">
            <?php include 'includes/prayers.php'?>
         </div>
      </div>
      <div id="hid_loc"></div>
  </body>
  <script type="text/javascript" src="/js/prayer_page.js"></script>
<?php
/*
25 February 2024 - Created file
2 March 2024
21 September 2024 - Added the main section
22 September 2024 - Added styling for search box
28 September 2024 - Added function call to clear search results
16 November 2024 - Added button to submit a prayer to the general list
23 November 2024 - Added div to hold prayer error. Moved js for backend validation
24 November 2024 - Added prayer display box
26 November 2024 - Moved icon to specific folder. Added on focus and out focus events
5 December 2024 - Increased version
*/
?>