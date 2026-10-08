<?php
/*
File: PrayerOrder group member display template
Author: David Sarkies 
#Initial: 20 September 2026
#Update: 8 October 2026
#Version: 1.3
*/
?>

<h3 class='prayer-h3'><?= htmlspecialchars($member['name'],ENT_QUOTES,'UTF-8') ?> <?=htmlspecialchars($member['memberTypeName'],ENT_QUOTES,'UTF-8')?>

	<?php if ($member['can_block']):?>
		<img class="search-icon" src="./Images/icon/block.png" width="20" alt="block" title="block"
			 onclick="changeGroupRelationship('b')">
	<?php endif ?>
	
	<?php if($member['can_remove']): ?>
		<img class="search-icon" src="./Images/icon/remove.png" width="20" alt="remove" 
			 title="remove" onclick="changeGroupRelationship('r')">
	<?php endif ?>

    <?php if ($member['can_promote']): ?>
    	<img class="search-icon" src="./Images/icon/promote.png" width="20" alt="promote" 
    	     title="promote" onclick="changeGroupRelationship('p')"> 
    <?php endif ?>

    <?php if($member['can_demote']): ?>
    	<img class="search-icon" src="./Images/icon/unblock.png" width="20" alt="demote" 
    	     title="demote" onclick="changeGroupRelationship('d')">
    <?php endif ?>

    <?php if($member['can_unblock']): ?>
    	<img class="search-icon" src="./Images/icon/unblock.png" width="20" alt="unblock" 
    	     title="unblock" onclick="changeGroupRelationship('u')">
    <?php endif ?> 
</h3>

<?php
/*
 * 20 September 2026 - Created file
 * 6 October 2026 - Changed to member type name
 * 7 October 2026 - Added icons for action types
 * 8 October 2026 - Added function calls for actions
 */
?>