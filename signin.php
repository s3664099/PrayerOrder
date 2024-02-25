<?php
/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 10 November 2023
Update: 25 February 2024
Version: 0.3

- Validate - Needs to be either email or phone - validates to make sure that either are used
*/
?>

<!DOCTYPE html>
   <head>
      <?php require 'header.php'?>
   </head>
   <body>
      <?php require 'title.php'?>
      <div class="main-section">
         <div id="authenticationFailure"></div>
         <form method="post" action="<?php echo htmlspecialchars('authenticate.php');?>" id="sign_in">
            <h3 style="text-align: center;">Email</h3>
            <input type="text" name="email" id="email" class="centre"/>          
            <h3 style="text-align: center;">Password</h3>
            <input type="password" name="password" id="password" class="centre">
            <div class="button-div">
               <button class="left-button" onclick="validateLogin();">Sign In</button>
               <button class="right-button" onclick="change_action('signup.php','sign_in')">Sign Up</button>
            </div>
         </form> 
      </div>

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
   25 February 2024 - Started added sign-in authentication code. Moved header into a header file.
-->