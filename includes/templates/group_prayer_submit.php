<?php
/*
File: PrayerOrder group prayer item template
Author: David Sarkies 
#Initial: 20 October 2025
#Update: 21 October 2026
#Version: 1.1
*/
?>

    <div class='group-prayer-box'>
        <h3 class='prayer-h3'> <?=$user['name']?> </h3>
        <input type='hidden' name='people["<?=$user['count']?>"][email]' value='"<?=$user['email']?>"'>
        <input type='hidden' name='people["<?=$user['count']?>"][phone]' value='"<?=$user['phone']?>"'>
        <div>Present <input type='checkbox' name='people["<?=$user['count']?>"][present]'
            				id='people["<?=user['$count']?>"][present]' value='1'>
        </div>
<textarea name='people["<?=$user['count']?>"][prayer]' id='people["<?=$user['count']?>"][prayer]'></textarea>
     </div>

<?php
/* 20 October 2026 - Created file
 * 21 October 2026 - Created template
*/
?>