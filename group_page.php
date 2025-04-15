<?php
/*
File: PrayerOrder Group Main Prayer Page
Author: David Sarkies 
Initial: 14 February 2024
Update: 15 April 2025
Version: 1.5
*/

include "includes/redirect_signin.php";
include "group_functions.php";

set_group_name();

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
         <div class="backcol-lblue pt-2p pb-2p">
            <span>
               <button onclick="back()" class="group-button">
                  <img src="./Images/icon/back.png" width="20" alt="back" id="back-icon" title="Back" class="point pl-5p">
               </button>
            </span>
            <span><img src="./Images/icon/invite.png" width="20" alt="back" id="invite-icon" title="Invite" class="point pl-5p"></span>
            <h3 class="inline ml-15p mr-15p"><?php echo($_SESSION['group_name']) ?></h3>
            <span><img src="./Images/icon/group.png" width="20" alt="back" id="group-icon" title="Group Members" class="point pr-5p"></span> 
            <span><img src="./Images/icon/prayergroup.png" width="20" alt="pray" id="pray-icon" title="Group Prayer" class="point"></span>
            <!--
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
            <div id="error-box" class="prayer-error-box prayer-box-error"></div>
            <div id="search_results"></div>
         -->
         </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px"></div>
         <div id="display-box" style="overflow-y:auto; max-height: 80vh;">
         </div>
      </div>
      <!--
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
         <form method="post" action="<?php /*echo htmlspecialchars('pray.php');?>" id="pray">
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
         <form method="post" action="<?php /*echo htmlspecialchars('create_group.php');?>" id="create-group"
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
         <?php /*include 'includes/prayers.php'*/?>
      </div>
      <div id="groups" class="prayer-request-box">
         <?php /*include 'includes/groups.php'*/ ?>
      </div>
      <div id="blank" class="prayer-request-box"></div>
      -->

  <script type="text/javascript" src="/js/group_page.js"></script>
</body>

<?php
/*
14 February 2025 - Created file
17 February 2025 - Added outline for the heading for the prayer groups
19 February 2025 - Styled the title and added images
18 March 2025 - Added back button to go back to main screen
12 April 2025 - Renamed page. Redirected to sign in if not signed in.
15 April 2025 - Displayed group name
*/
?>