# Prayer Order App #
*An app for deteriming prayer orders*

** Languages Used **
HTML,css,Javascript, php

** Objective **

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
   Group
   - Also lists the group name at the top - button can display/hide memebers - 
   - Add Bar to display the group name (and the return button will be here)
   - when select sets variable for a group
   - Search invites people to group
   - User gets message (appears at top) inviting them to join group
   - Then do create group, select group

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


##Issues##





1) Remove the Alerts for when change relationship - instead add to log
2) When change relationship, refreshes prayer page
3) When click praise button automatically reduces number of prayers, even if you don't have one.
4) Prayerbox shouldn't shrink when focus out. Probably shouldn't enlarge if already enlarged as well.

