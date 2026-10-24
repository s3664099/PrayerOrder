<?php
/*
File: PrayerOrder group prayer item template
Author: David Sarkies 
#Initial: 20 October 2025
#Update: 24 October 2026
#Version: 1.4
*/
?>

    <div class='group-prayer-box'>
        <h3 class='prayer-h3'> <?=$user['userName']?> </h3>
        <input type="hidden" name='people[<?=$user['count']?>][name]' value='<?=$user['userName']?>'>
        <input type='hidden' name='people[<?=$user['count']?>][email]' value='<?=$user['email']?>'>
        <input type='hidden' name='people[<?=$user['count']?>][phone]' value='<?=$user['phone']?>'>
        <input type='hidden' name='people[<?=$user['count']?>][partner_prayer]' value=''>
        <div>Present <input type='checkbox' name='people[<?=$user['count']?>][present]'
            				id='people[<?=$user['count']?>][present]' value='1'>
        </div>
<textarea name='people[<?=$user['count']?>][prayer]' id='people[<?=$user['count']?>][prayer]'></textarea>
     </div>

<?php
/* 20 October 2026 - Created file
 * 21 October 2026 - Created template
 * 22 October 2026 - Removed quotes from count
 * 23 October 2026 - Fixed variables so prayers are now sent
 * 24 October 2026 - Added name as a hidden input
*/
?>