<!--
File: PrayerOrder Sign Up Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 5 January 2024
Version: 0.0
-->

<!DOCTYPE html>
   <head>
      <title>PrayerOrder</title>
      <meta name="viewport" content="initial-scale=1.0">
      <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
      <meta name="robots" content="noindex">
      <meta charset="utf-8">
      <link type="text/css" rel="stylesheet" href="./css/title.css">
      <link type="text/css" rel="stylesheet" href="./css/standard.css">
   </head>
   <body>
      <div class="title-bar">
         <img id="title_image" alt="Placeholder" class="logo centre" 
	      src="./Images/title.png">
      </div>
      <div class="main-section">
         <form method="post" action="<?php echo htmlspecialchars('create_user.php');?>" id="sign_up">
            <h3 style="text-align: center;">User Name</h3>
            <input type="text" name="username" id="username" class="centre"/>
            <h3 style="text-align: center;">Email</h3>
            <input type="text" name="username" id="username" class="centre"/>
            <h3 style="text-align: center;">Mobile</h3>
            <input type="text" name="username" id="username" class="centre"/>
            <h3 style="text-align: center;">Password</h3>
            <input type="password" name="password" id="password" class="centre">
            <h3 style="text-align: center;">Confirm Password</h3>
            <input type="password" name="confirm_password" id="confirm_password" class="centre">
            <div class="button-div">
               <button class="left-button" onclick="change_action('index.php','sign_up')">Cancel</button>
               <button class="right-button">Submit</button>
            </div>
         </form> 
      </div>
      <script type="text/javascript" src="/js/standard.js"></script>
   </body>
</html>

<!--
   5 January 2024 - Created Page
-->