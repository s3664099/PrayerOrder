<?php
/*
File: PrayerOrder group member display template
Author: David Sarkies 
#Initial: 20 September 2026
#Update: 20 September 2026
#Version: 1.0
*/
?>

<h3 class='prayer-h3'><?= htmlspecialchars($member['name'],ENT_QUOTES,'UTF-8') ?> <?=htmlspecialchars($member['memberType'],ENT_QUOTES,'UTF-8') ?>
	<!-- 
		If admin/Creatore has special options
		- All types removed/blocked
		- Current members - made admine
		- Admin - can remove? Good question - maybe only creator can remove
		- Is creator special type, or just the admin that created group
		- Also remove it back into members and just echo
	-->
</h3>

<?php
/*
 * 20 September 2026 - Created file
 */
?>