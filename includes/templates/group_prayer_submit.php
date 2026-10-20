<?php
/*
File: PrayerOrder group prayer item template
Author: David Sarkies 
#Initial: 20 October 2025
#Update: 20 October 2026
#Version: 1.0
*/
?>

            echo("<div class='group-prayer-box'>");
            echo("<h3 class='prayer-h3'>".$x['name']."</h3>");
            echo("<input type='hidden' name='people[".$count."][email]' value='".$x['email']."'>");
            echo("<div>Present <input type='checkbox' name='people[".$count."][present]'");
            echo("id='people[".$count."][present]' value='1'></div>");
            echo("<textarea name='people[".$count."][prayer]' id='people[".$count."][prayer]'></textarea>");
           echo("</div>");

<?php
/* 20 October 2026 - Created file
*/
?>