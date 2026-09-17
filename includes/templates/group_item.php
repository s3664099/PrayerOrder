<?php
/*
File: PrayerOrder invite item template
Author: David Sarkies 
#Initial: 17 September 2026
#Update: 17 September 2026
#Version: 1.0
*/
?>

<div>
	<?php if ($group['memberType']=='m') {
		?><span class='pl-15p'><?php
	} else if ($group['memberType']=='c' || $group['memberType']=='a') {
		?><span><img src='./Images/icon/admin.png' width='20' class='pl-2p pr-2p'><?php
	}?>
		<button class='groupSelect' onclick='selectGroup(this)' id='<?= htmlspecialchars($group["groupKey"],ENT_QUOTES,"UTF-8")?>'>
			<?=htmlspecialchars($group['groupName'],ENT_QUOTES,"UTF-8")?>
		</button>
	</span>
</div>

<?php
/* 12 September 2026 - Created File
*/
?>