<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 12 December 2025
Update: 16 December 2025
Version: 1.1
*/

class relationship_constants extends column_constants {

	const REL_NONE = 0;
	const REL_FOLLOWED = 1;
	const REL_FRIENDS = 2;
	const REL_BLOCKED = 3;
	const REL_FOLLOWING = 4;
	const REL_BLOCKING = 5;

	const REL_FOLLOW = 1;
	const REL_BLOCK = 3;
	const REL_UNBLOCK= 4;
	const REL_UNFOLLOW = 0;

	const NONE = "None";
	const FOLLOWED = "Followed";
	const FRIENDS = "Friends";
	const FOLLOWING = "Following";
	const BLOCKING = "Blocking";
	const BLOCKED = "Skip";
	const UNBLOCKED = "unblocked";
	const HAS_BLOCKED = "blocked";
	const NOTHING = "nothing";
	const ALREADY_FOLLOWING = "Already Following";
	const ALREADY_BLOCKING = "Already blocked";
	const UNFOLLOWED = "Unfollowed";
	const NOT_FOLLOWING = "Not Following";
	const NOT_BLOCKED = "Not blocked";
	const NOT_BLOCKING = "Not Blocking";

}

class column_constants {
	const FOLLOW_TYPE = 'followType';
	const USER_ID = 'id';
}

/* 12 December 2025 - Created file
 * 16 December 2025 - Added constants for relationship change
*/
?>