<?php
/*
File: PrayerOrder group member display template
Author: David Sarkies 
#Initial: 20 September 2026
#Update: 7 October 2026
#Version: 1.2
*/
?>

<h3 class='prayer-h3'><?= htmlspecialchars($member['name'],ENT_QUOTES,'UTF-8') ?> <?=htmlspecialchars($member['memberTypeName'],ENT_QUOTES,'UTF-8')?>

	<?php if ($member['can_block']):?>
		<img class="search-icon" src="./Images/icon/block.png" width="20" alt="block" title="block">
	<?php endif ?>
	
	<?php if($member['can_remove']): ?>
		Remove
	<?php endif ?>

    <?php if ($member['can_promote']): ?>
    	Promote 
    <?php endif ?>

    <?php if($member['can_demote']): ?>
    	Demote
    <?php endif ?>

    <?php if($member['can_unblock']): ?>
    	<img class="search-icon" src="./Images/icon/unblock.png" width="20" alt="unblock" title="unblock">
    <?php endif ?> 
</h3>

<?php
/*
 * 20 September 2026 - Created file
 * 6 October 2026 - Changed to member type name
 */
?>