# Prayer Order App #
*An app for deteriming prayer orders*

** Languages Used **
HTML,css,Javascript, php

** Objective **

- Add error to the create group page if group exists
- Remove php code for authentication failure on signup to separate file
- Change so that it doesn't reveal what the issue is - just failed to create user.


1) Search for group

   - Add buttons to move to this screen.
   - On click sets session with group id
   - then refers to page which retrieves prayers connected to group id

   Prayer
   - Create NoSQL db to store prayers
   - Once done can increase number and move onto groups

2) Create Group
   - Create Group - displays error if group exists, but removes it when interacting with screen
   
   v1.0
   Group - Invite Member workflow
      - click invite member - opens search panel for members
      - type in names and available names appears
         - doesn't display: Blocked, Invited, You, in Group
         - sends invitation which appears above prayers
         - user can select/reject
         - select adds to group - removes invitation
         - reject - remove invitation
   Group Members
      - displays all members with authority (creator) on it

3) Enter Prayers

	- Post prayer in group - prayers are the same, but group id
	- Respond to prayer
   - The ask prayer has arrows to circle through people in group to add prayer
   - Add to all users and then press pray
   - Also tick to advise whether available

4) Determine Order
5) Send Prayers
   - sends prayer to random person in group
      - Does not get own prayer
      - Can get more than one prayer if users not present

6) Daily Prayer List

##Other##
- Validate - Needs to be either email or phone - validates to make sure that either are used - Signin

##Issues##

