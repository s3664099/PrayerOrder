<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 16 April 2025
Version: 1.10
*/

include 'includes/redirect_signin.php';

?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/common/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/prayer_page.css">
   </head>
   <body>
      <?php include 'includes/common/title.php'?>
      <div class="main-section">
         <div class="backcol-lblue">
            <div>
               <img src="./Images/icon/search.png" width="20" alt="search" id="search-icon" class="point"
                    title="search" onClick="switchSearch(),clearSearch()">
               <span id="search-box">
                  <input id="search-input" type="text" onKeyUp="find_user()">
                  <img src="./Images/icon/clear.png" width="20" alt="clear" title="clear" onClick="clearSearch()">
               </span>
               <img src="./Images/icon/group.png" width="20" alt="group" id="group-icon" class="pl-20p point" 
                  title="Groups" onclick="groupPage()">
            </div>
            <div id="error-box" class="prayer-error-box prayer-box-error"></div>
            <div id="search_results"></div>
         </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px">
            <h3 class="ask-prayer">Ask for Prayer</h3>
            <h4 class="prayer-error-box prayer-box-error" id="error-field"></h4>
            <form method="post" action="<?php echo htmlspecialchars('pray.php');?>" id="pray">
               <div class="submitPrayer">
<textarea class="prayer-box" name="prayer" id="prayer" onfocus="enlarge();" onfocusout="shrink();"></textarea>
                  <button class="sendButton" onclick="sendPrayer()">
                     <img width="20" src="./Images/icon/submit.png" alt="send prayer">
                  </button>
               </div>
            </form>
         </div>
         <div id="display-box" style="overflow-y:auto; max-height: 80vh;">
            <?php include 'includes/prayer/prayers.php'?>
         </div>
      </div>
      <div id="hid_loc"></div>
  <script type="text/javascript" src="/js/prayer_page.js"></script>
  <script type="text/javascript" src="/js/user_page.js"></script>
  <script type="text/javascript" src="/js/main_page.js"></script> 
</body>
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
23 Janaury 2025 - Added span to hold button either group or user. Added buttons for group and user
26 January 2025 - Fixed some of the style for the buttons in the nav bar
                - moved the prayer ask box to separate hidden area.
                - Moved the main prayer page to a hidden div
28 January 2025 - Started building the create group section
30 January 2025 - Added links to group & user pages
8 February 2025 - Added create group icon
13 February 2025 - Added php code to set page type return to
19 February 2025 - Added titles to buttons
18 March 2025 - Removed blank space from text-area
27 March 2025 - Removed the Group Prayer page
29 March 2025 - Hardcoded the find_user function to the search bar.
16 April 2025 - Moved includes into common folder. Moved prayer includer into prayer folder.
*/
?>