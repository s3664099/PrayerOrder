<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 18 March 2025
Version: 1.8


- The prayer shouldn't overwrite the prayer file, but rather append (this is only tempoorary)


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
         <div class="backcol-lblue">
            <div>
               <img src="./Images/icon/search.png" width="20" alt="search" id="search-icon" class="point"
                    title="search" onClick="switchSearch(),clearSearch()">
               <span id="search-box">
                  <input id="search-input" type="text">
                  <img src="./Images/icon/clear.png" width="20" alt="clear" title="clear" onClick="clearSearch()">
               </span>
               <span id="button-type">
               </span>
            </div>
            <div id="error-box" class="prayer-error-box prayer-box-error"></div>
            <div id="search_results"></div>
         </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px"></div>
         <div id="display-box" style="overflow-y:auto; max-height: 80vh;"></div>
      </div>
      <div id="hid_loc"></div>
      <span id="group-button" class="hidden">
          <img src="./Images/icon/group.png" width="20" alt="group" id="group-icon" class="pl-20p point" 
               title="Groups" onclick="setUser()">
      </span>
      <span id="user-button" class="hidden">
         <img src="./Images/icon/addGroup.png" width="20" alt="add group" id="add-group" class="pl-10p point"
              title="Add Group" onclick="createGroup()">
         <img src="./Images/icon/user.png" width="20" alt="user" id="user-icon" class="pl-5p point" 
              title="Back to User" onclick="setGroup()">
      </span>
      <div id="prayer-ask" class="hidden">
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
      <div id="group-create" class="hidden">
         <h3 class="ask-prayer">Create Group</h3>
         <h4 class="prayer-error-box prayer-box-error" id="error-field"></h4>
         <form method="post" action="<?php echo htmlspecialchars('create_group.php');?>" id="create-group"
               class="pl-15p pt-2p pb-5p">
            <input name="group-name" id="group-name" placeholder="Group Name" width="20">
            <span class="pl-5p">Private</span>
            <input name="isPrivate" type="hidden" value="0">
            <input name="isPrivate" type="checkbox" value="1">
            <button class="sendButton" onclick="newGroup()">
               <img width="40" src="./Images/icon/createGroup.png" alt="send prayer">
            </button>
         </form>
      </div>
      <div id="prayers" class="prayer-request-box">
         <?php include 'includes/prayers.php'?>
      </div>
      <div id="groups" class="prayer-request-box">
         <?php include 'includes/groups.php' ?>
      </div>
      <div id="blank" class="prayer-request-box"></div>
  <script type="text/javascript" src="/js/prayer_page.js"></script>
  <script type="text/javascript" src="/js/user_page.js"></script>
  <script type="text/javascript" src="/js/group_page.js"></script>
  <script type="text/javascript" src="/js/main_page.js"></script> 
<?php
if (isset($_SESSION['groupPage'])) {
   unset($_SESSION['groupPage']);
   ?><script type="text/javascript">setUser();</script><?php

   if (isset($_SESSION['group_exists'])) {
      unset($_SESSION['group_exists']);
      ?><script type="text/javascript">displayGroupExists();</script><?php
   }
} else {
   
   ?><script type="text/javascript">setGroup();</script><?php
}
   ?></body>
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
*/
?>