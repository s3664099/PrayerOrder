<?php
/*
File: PrayerOrder groups page
Author: David Sarkies 
#Initial: 13 February 2025
#Update: 12 April 2025
#Version: 1.5
*/

include "includes/redirect_signin.php";

?>
<!DOCTYPE html>
   <head>
      <?php include 'includes/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/prayer_page.css">
      <link type="text/css" rel="stylesheet" href="./css/group_page.css">
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
               <img src="./Images/icon/addGroup.png" width="20" alt="add group" id="add-group" class="pl-10p point"
                    title="Add Group" onclick="createGroup()">
               <img src="./Images/icon/user.png" width="20" alt="user" id="user-icon" class="pl-5p point" 
                    title="Back to User" onclick="userPage()">
            </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px"></div>
         <div id="display-box" style="overflow-y:auto; max-height: 80vh;"></div>
      </div>
      <div id="hid_loc"></div>
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
             <small class="error-message" id="error-box"></small>
         </form>
      </div>
      <div id="search_results"></div>
      <div id="groups" class="group-display-box">
         <?php
            include 'group_functions.php';
            display_groups();
         ?>
      </div>
  <script type="text/javascript" src="/js/group_page.js"></script>
  <script type="text/javascript" src="/js/main_page.js"></script> 
</body>
<?php
/*
13 February 2025 - Created File
14 February 2025 - Added styling for group list
16 February 2025 - Added groupId to group select and group select function
27 March 2025 - Made file another page
11 April 2025 - Fixed initial errors with display
12 April 2025 - Added error box. Added redirect to sign in if not signed in
*/
?>