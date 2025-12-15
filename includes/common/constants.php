<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 12 December 2025
Update: 12 December 2025
Version: 1.0
*/

class relationship_constants extends column_constants {

	const REL_NONE = 0;
	const REL_FOLLOWED = 1;
	const REL_FRIENDS = 2;
	const REL_BLOCKED = 3;
	const REL_FOLLOWING = 4;
	const REL_BLOCKING = 5;

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
	const UNFOLLOWED = "Unfollowed";
	const NOT_FOLLOWING = "Not Following";

}

class column_constants {
	const FOLLOW_TYPE = 'followType';
	const USER_ID = 'id';
}

/* 12 December 2025
*/
?>