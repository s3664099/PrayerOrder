<?php
/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 10 November 2023
Update: 8 January 2026
Version: 1.5
*/

require 'includes/user/error.php';
require 'includes/user/message.php';

?>
<!DOCTYPE html>
   <head>
      <?php require 'includes/common/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/authenticate.css">
   </head>
   <body>
      <?php require 'includes/common/title.php'?>
      <div class="main-section">
         <div id="authenticationFailure">
            <?php
               signInError();
               signUpSuccess();
            ?>            
         </div>
         <form method="post" action="includes/user/authenticate.php" id="sign_in">
            <label for="email">
               <h3 style="text-align: center;">Email</h3>
            </label>
            <input type="text" name="email" id="email" class="centre" aria-describedby="email-error" 
                   autocomplete="email" required/>
            <small class="error-message centre" id="email-error" aria-live="polite"></small>
            <label for="password">
               <h3 style="text-align: center;">Password</h3>
            </label>
            <input type="password" name="password" id="password" class="centre" aria-describedby="password-error"
                   autocomplete="password" required>
            <small class="error-message centre" id="password-error" aria-live="polite"></small>
            <input type="hidden" name="type" id="type" value="signin">
            <div class="button-div">
               <button type="button" class="left-button" onclick="validateLogin();">
                  Sign In
               </button>
               <button type="button" class="right-button" onclick="change_action('signup.php','sign_in')">
                  Sign Up
               </button>
            </div>
         </form> 
      </div>
   </body>
</html>

<?php
/*
   10 November 2023 - Created Page
   11 November 2023 - Configured title and added sign in form
   12 November 2023 - Added styling
   25 February 2024 - Started added sign-in authentication code. Moved header into a header file.
   2 March 2024 - Moved common includes to directory
   4 July 2024 - Added Login failed display
   18 July 2024 - Added div to hold error messages
   27 September 2024 - Added reference to css page for signing in
   5 December 2024 - Increased version
   16 April 2025 - Moved includes into common folder
   19 April 2025 - Updated location of authenticate
   6 May 2025 - Moved error display to separate file.
   8 July 2025 - Created display for successful signin.
   8 January 2026 - Fixed file for accessiblity and other minor issues
*/
?>