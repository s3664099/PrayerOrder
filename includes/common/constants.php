<?php
/*
File: PrayerOrder Relationship Service
Author: David Sarkies 
Initial: 12 December 2025
Update: 3 January 2026
Version: 1.2
*/


final class RelationshipState {
	const NONE = 0;
	const FOLLOWED = 1;
	const FRIENDS = 2;
	const BLOCKED = 3;
	const FOLLOWING = 4;
	const BLOCKING = 5;
}

final class RelationshipAction {
	const FOLLOW = 1;
	const UNFOLLOW = 0;
	const BLOCK = 3;
	const UNBLOCK = 4;
}

final class RelationshipMessages {
	const NONE = "None";
	const FOLLOWED = "Followed";
	const FRIENDS = "Friends";
	const FOLLOWING = "Following";
	const BLOCKING = "Blocking";
	const BLOCKED = "Blocked";

	const ALREADY_FOLLOWING = "Already Following";
	const ALREADY_BLOCKING = "Already Blocked";
	const UNFOLLOWED = "Unfollowed";
	const NOT_FOLLOWING = "Not Following";
	const NOT_BLOCKED = "Not Blocked";
}

final class Column {
	const FOLLOW_TYPE = "followType";
	const USER_ID = "id";
}

/* 12 December 2025 - Created file
 * 16 December 2025 - Added constants for relationship change
 * 3 January 2025 - Separated constants into related classes
*/
?>