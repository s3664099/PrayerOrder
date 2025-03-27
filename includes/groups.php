<?php
/*
File: PrayerOrder groups page
Author: David Sarkies 
#Initial: 13 Fedbruary 2025
#Update: 27 March 2025
#Version: 1.3
*/

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
      <div id="group-create">
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
      <div id="groups" class="prayer-request-box">
         <?php include 'includes/group_display.php' ?>
      </div>
      <div id="blank" class="prayer-request-box"></div>
  <script type="text/javascript" src="/js/user_page.js"></script>
  <script type="text/javascript" src="/js/group_page.js"></script>
  <script type="text/javascript" src="/js/main_page.js"></script> 
  <script type="text/javascript">setUser();</script>
</body>
<?php
/*
include 'groupFunctions.php';

foreach ($result as $x) {

	if ($x['isAdmin']==0) {
		echo "<span class='pl-15p'>";
	} else {
		echo "<span><img src='./Images/icon/admin.png' width='20' class='pr-2p'>";
	}

	echo "<button class='groupSelect' onclick='selectGroup(this)' id='".$x['groupKey']."'>".$x['groupName'];
	echo "</button></span></div>";
}
*/

/*
13 February 2025 - Created File
14 February 2025 - Added styling for group list
16 February 2025 - Added groupId to group select and group select function
27 March 2025 - Made file another page
*/
?>