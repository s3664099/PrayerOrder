<?php
/*
File: PrayerOrder invite item template
Author: David Sarkies 
#Initial: 12 September 2026
#Update: 13 September 2026
#Version: 1.1
*/
?>

<h4 id='<?= htmlspecialchars($invite['groupKey'], ENT_QUOTES, 'UTF-8') ?>' class='accept_invite'>
	<img alt='Accept Invite' width='15' src='./Images/icon/accept.png/' onclick='acceptInvite(this)' 
		 class='accept_invite' title='Accept'>
	<img alt='Reject Invite' width='15' src='./Images/icon/reject.png/' onclick='rejectInvite(this)' 
		  class='accept_invite' title='Reject'>
	Invite: <?= htmlspecialchars($invite['groupName'], ENT_QUOTES, 'UTF-8') ?>
</h4>


<?php
/* 12 September 2026 - Created File
 * 13 September 2026 - Added invites
*/
?>