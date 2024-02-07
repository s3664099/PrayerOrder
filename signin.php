<!--
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 10 November 2023
Update: 12 November 2023
Version: 0.2

- Validate - Needs to be either email or phone - validates to make sure that either are used

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
         <img id="title_image" alt="Placeholder" class="logo" 
	      src="./Images/title.png">
      </div>
      <div class="main-section">
         <form method="post" action="<?php echo htmlspecialchars('authenticate.php');?>" id="sign_in">
            <h3 style="text-align: center;">Email</h3>
            <input type="text" name="email" id="email" class="centre"/>
            <h3 style="text-align: center;">Phone</h3>
            <input type="text" name="phone" id="phone" class="centre"/>            
            <h3 style="text-align: center;">Password</h3>
            <input type="password" name="password" id="password" class="centre">
            <div class="button-div">
               <button class="left-button">Sign In</button>
               <button class="right-button" onclick="change_action('signup.php','sign_in')">Sign Up</button>
            </div>
         </form> 
      </div>
      <script type="text/javascript" src="/js/standard.js"></script>
	 <!-- Username/Password in form -->
         <!-- sign-in/sign-up button -->
	 <!-- sign-in authenticates and saves session --> 
	 <!-- Sign-up creates a new account -->
	 <!-- Checks session - if present goes straight to main page -->
	 <!-- Otherwise starts here -->
   </body>
</html>

<!--
   10 November 2023 - Created Page
   11 November 2023 - Configured title and added sign in form
   12 November 2023 - Added styling
-->