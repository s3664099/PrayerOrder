<?php
/*
File: PrayerOrder Sign Up Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 25 February 2024
Version: 0.3
*/
session_start();
?>

<!DOCTYPE html>
   <head>
      <?php include 'header.php'?>
   </head>
   <body>
      <?php include 'title.php'?>
      <div class="main-section">
         <form method="post" action="<?php echo htmlspecialchars('create_user.php');?>" id="sign_up">
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
               <button class="left-button" onclick="change_action('index.php','sign_up')">Cancel</button>
               <button class="right-button">Submit</button>
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
   25 February 2024 - Moved 
*/
?>