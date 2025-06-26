<?php
/*
File: PrayerOrder Group Main Prayer Page
Author: David Sarkies 
Initial: 14 February 2024
Update: 8 July 2025
Version: 1.5
*/

include "includes/common/redirect_signin.php";
include "includes/group/group_functions.php";

set_group_name();

?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/common/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/prayer_page.css">
      <link type="text/css" rel="stylesheet" href="./css/group_page.css">
      <link type="text/css" rel="stylesheet" href="./css/group_prayer.css">
   </head>
   <body>
      <?php include 'includes/common/title.php'?>
      <div class="main-section">
         <div class="backcol-lblue pt-2p pb-2p">
            <span>
               <button onclick="back()" class="group-button">
                  <img src="./Images/icon/back.png" width="20" alt="back" id="back-icon" title="Back" class="point pl-5p">
               </button>
            </span>
            <span>
               <img src="./Images/icon/invite.png" width="20" alt="back" id="invite-icon" title="Invite" 
                    class="point pl-5p" onclick="invite();">
            </span>
            <h3 class="inline ml-15p mr-15p"><?php echo($_SESSION['group_name']) ?></h3>
            <span>
               <img src="./Images/icon/group.png" width="20" alt="back" id="group-icon" title="Group Members" 
                    class="point pr-5p" onclick="displayMembers();">
            </span> 
            <span>
               <img src="./Images/icon/prayergroup.png" width="20" alt="pray" id="pray-icon" title="Group Prayer" 
                    class="point" onclick="displayPrayersBox();">
            </span>
         </div>
         <div id="input-box" class="bt-solid-1px bb-solid-3px"></div>
         <div id="display-box" style="overflow-y:auto; max-height: 80vh;">
         </div>
      </div>
      <div id="invite-box" class="hidden">
         <div>
            <input id="invite-input" type="text" onKeyUp="findUser()">
            <img src="./Images/icon/clear.png" width="20" alt="clear" class="point" 
                 onClick="clearSearch(document.getElementById('invite-input'))">
         </div>
         <div id="error-box" class="prayer-error-box prayer-box-error"></div>
         <div id="search_results"></div>
      </div>
      <div id="member-box" class="hidden">
         <?php
            getMembers();
         ?>
      </div>
      <div id="prayer-box" class="hidden">
         <div id="error-message"></div>
         <form method="post" action="<?php echo htmlspecialchars('includes/group/group_prayers.php');?>">
            <input type="submit" value="Submit Prayers" class='submit-prayers' onclick="submitPrayers(this);">
            <?php
               getPrayerBox();
            ?>
         </form>
      </div>
      <div id="hid_loc"></div>
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
16 April 2025 - Moved includes into common folder. Moved prayers include into prayer folder
24 April 2025 - Fixed problem with not going to page
10 May 2025 - Added send invite box
20 May 2025 - Added display members box. Added call to display members of group
27 May 2025 - Added display prayer box
3 July 2025 - Added styling for member and prayer display
            - Added form for submitting prayers
8 July 2025 - Added submission function for prayers
*/
?>