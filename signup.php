<?php
/*
File: PrayerOrder Sign Up Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 8 January 2026
Version: 1.7
*/
session_start();
require 'includes/user/error.php';
?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/common/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/authenticate.css">
   </head>
   <body>
      <?php include 'includes/common/title.php'?>
      <div class="main-section">
         <div id="authenticationFailure">
            <?php
               signUpError();
            ?>
         </div>
         <form method="post" action="includes/user/create_user.php" id="sign_up"
               onsubmit="event.preventDefault(); validateSignUp();" >
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <h3 style="text-align: center;">User Name</h3>
            <input type="text" name="username" id="username" class="centre" maxlength="50" 
                   onblur="validateSignUpInput(this,'User Name','username-error')" />
            <small class="error-message centre" id="username-error"></small>
            <h3 style="text-align: center;">Email</h3>
            <input type="text" name="email" id="email" class="centre" maxlength="200" 
                     onblur="validateEmailInput(this,'Email','email-error')" />
            <small class="error-message centre" id="email-error"></small>
            <h3 style="text-align: center;">Phone</h3>
            <input type="text" name="phone" id="phone" class="centre" maxlength="10" 
                   onblur="validateSignUpInput(this,'Phone','phone-error')"/>
            <small class="error-message centre" id="phone-error"></small>
            <h3 style="text-align: center;">Password</h3>
            <input type="password" name="password" id="password" class="centre" maxlength="65" 
                   onblur="validateSignUpInput(this,'Password','password-error')">
            <small class="error-message centre" id="password-error"></small>
            <h3 style="text-align: center;">Confirm Password</h3>
            <input type="password" name="confirm_password" id="confirm_password" class="centre" maxlength="65" 
                   onblur="validateConfirmInput(this,'Confirm Password','confirm-error')">
            <small class="error-message centre" id="confirm-error"></small>
            <div class="button-div">
               <button class="right-button">Submit</button>
               <button class="left-button" onclick="change_action('index.php','sign_up');">Cancel</button>
            </div>
         </form> 
      </div>
   </body>
</html>

<?php
/*
   5 January 2024 - Created Page
   6 February 2024 - Added More fields
   8 February 2024 - Fixed ids and names to match inputs
   25 February 2024 - Moved sections to common includes
   2 March 2024 - Moved includes to separate file
   19 July 2024 - Added div to hold errors.
   10 September 2024 - Switched position of buttons
   12 September 2024 - Added styling for invalid email
   27 September 2024 - Added reference to css page for signing in
   5 December 2024 - Increased version
   23 February 2025 - Changed error to simply say user exists (not identifying email or phone)
                    - Changed validation
   27 February 2025 - Added blur validations for email and confirm password
   16 April 2025 - Moved includes into common folder
   6 May 2025 - Moved error display to separate file
   9 November 2025 - Limited size of phone field.
   13 November 2025 - Limited size of password and name fields
   8 January 2026 - Added crfs token
*/
?>