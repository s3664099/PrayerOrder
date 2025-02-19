<?php
/*
File: PrayerOrder Sign Up Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 5 December 2024
Version: 1.0
*/
session_start();
?>

<!DOCTYPE html>
   <head>
      <?php include 'includes/header.php'?>
      <link type="text/css" rel="stylesheet" href="./css/authenticate.css">
   </head>
   <body>
      <?php include 'includes/title.php'?>
      <div class="main-section">
         <div id="authenticationFailure">
            <?php
               if (isset($_SESSION['email_fail'])) {
                  ?>
                     <div class="error">Invalid Email</div>
                  <?php
                  unset($_SESSION['email_fail']);
               }

               if (isset($_SESSION['value'])) {
                  ?>
                     <div class="error">
                  <?php

                     if(isset($_SESSION['email_exists'])) {
                        ?>
                           Email Exists<br>
                        <?php
                        unset($_SESSION['email_exists']);
                     }

                     if(isset($_SESSION['phone_exists'])) {
                        ?>
                           Phone Exists
                        <?php
                        unset($_SESSION['phone_exists']);
                     }


                  ?>
                     </div>
                  <?php
                  unset($_SESSION['value']);
               }
            ?>
         </div>
         <form method="post" action="<?php echo htmlspecialchars('create_user.php');?>" id="sign_up"
               onsubmit="event.preventDefault(); validateSignUp();" >
            <h3 style="text-align: center;">User Name</h3>
            <input type="text" name="username" id="username" class="centre"/>
            <h3 style="text-align: center;">Email</h3>
            <input type="text" name="email" id="email" class="centre"/>
            <h3 style="text-align: center;">Phone</h3>
            <input type="text" name="phone" id="phone" class="centre"/>
            <h3 style="text-align: center;">Password</h3>
            <input type="password" name="password" id="password" class="centre">
            <h3 style="text-align: center;">Confirm Password</h3>
            <input type="password" name="confirm_password" id="confirm_password" class="centre">
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
*/
?>