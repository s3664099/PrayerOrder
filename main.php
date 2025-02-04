<?php
/*
File: PrayerOrder Main Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 30 January 2025
Version: 1.4
*/

include 'includes/redirect_signin.php';

//Group button reveals 'add group' button and changes the search to search for groups.
      //Prayer ask field is hidden until a group is selected.
      //When group is selected, search becomes an invite
      //Group button changes to user
      //The prayer list changes to list of groups user is involved in.
      //Group shows two buttons next to name - view, which is like standard view
      //                                     - prayer - group prayer

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
                    onClick="switchSearch(),clearSearch()">
               <span id="search-box">
                  <input id="search-input" type="text">
                  <img src="./Images/icon/clear.png" width="20" alt="clear" onClick="clearSearch()">
               </span>
               <span id="button-type">
               </span>
            </div>
            <div id="search_results"></div>
         </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px"></div>
         <div id="display-box"></div>
      </div>
      <div id="hid_loc"></div>
      <span id="group-button" class="hidden">
          <img src="./Images/icon/group.png" width="20" alt="group" id="group-icon" class="pl-20p point" 
               onclick="setUser()">
      </span>
      <span id="user-button" class="hidden">
         <img src="./Images/icon/addGroup.png" width="20" alt="add group" id="add-group" class="pl-10p point"
              onclick="createGroup()">
         <img src="./Images/icon/user.png" width="20" alt="user" id="user-icon" class="pl-5p point" 
              onclick="setGroup()">
      </span>
      <div id="prayer-ask" class="hidden">
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
      <div id="group-create" class="hidden">
         <h3 class="ask-prayer">Create Group</h3>
         <h4 class="prayer-error-box prayer-box-error" id="error-field"></h4>
         <form method="post" action="<? echo htmlspecialchars('creategroup.php');?>" id="create-group"
               class="pl-15p pt-2p pb-5p">
            <input name="group-name" placeholder="Group Name" width="20">
            <span class="pl-5p">Private</span>
            <input name="isPrivate" type="checkbox">
            <button class="sendButton" onclick="newGroyp()">
               <img width="20" src="./Images/icon/addGroup.png" alt="send prayer">
            </button>
         </form>
      </div>
      <div id="prayers" class="prayer-request-box">
         <?php include 'includes/prayers.php'?>
      </div>
      <div id="blank" class="prayer-request-box"></div>
  </body>
  <script type="text/javascript" src="/js/prayer_page.js"></script>
  <script type="text/javascript" src="/js/user_page.js"></script>
  <script type="text/javascript" src="/js/group_page.js"></script>
  <script type="text/javascript" src="/js/main_page.js"></script>
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
*/
?>