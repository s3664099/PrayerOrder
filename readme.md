# Prayer Order App #
*An app for deteriming prayer orders*

** Languages Used **
HTML,css,Javascript, php

** Objective **

- Root
   - group_page.php
   - groups.php
   - index.php
   - main.php
   - signin.php
   - signup.php
- css
   - authenticate.css
   - group_page.css
   - group_prayer.css
   - prayer_page.css
   - standard.css
   - title.css
- js
   - group_page.js
   - login_page.js
   - main_page.js
   - prayer_page.js
   - standard.js
   - user_page.js
- includes
   - common
      - header.php
      - redirect_signin.php
      - title.php
   - database
      - db_handler.php
      - db_prayer_ro.php
      - db_prayer_rw.php
      - db_user_ro.php
      - db_user_rw.php
   - group
      - create_group.php
      - error.php
      - group_functions.php
      - group_prayers.php
      - group_select.php
   - prayer
      - prayer.php
      - prayers.php
   - user
      - authenticate.php
      - create_user.php
      - error.php
      - inviteUsers.php
      - message.php
      - users.php
   - 




- Change sections of code to refer to userKey as opposed to user email




   
   #The user key is the reference for the prayers - so that the group key can also be used.
   #Record how the database is set up
   #Create table to hold reference to prayer user has selected
   #Add prayers to table and JSON
   #Separate the authentication tables from the prayer tables
   #Change how the keys are encoded.

1) Search for group

   - then refers to page which retrieves prayers connected to group id

   Prayer
   - Create NoSQL db to store prayers
   - Once done can increase number and move onto groups

2) Create Group
   
3) Enter Prayers

	- Post prayer in group - prayers are the same, but group id
	- Respond to prayer
   - Can't submit if there is only one member of the group


4) Determine Order
5) Send Prayers
   - sends prayer to random person in group
      - Does not get own prayer
      - Can get more than one prayer if users not present

6) Daily Prayer List

##Other##
- Validate - Needs to be either email or phone - validates to make sure that either are used - Signin
- Change password encryption
- Retrieve users photo as well

##Issues#
- Doesn't change style when viewed on small screen.
- Remove css and use tailwind.



##Database##
connection
   follower - Change to user key
   followee - Change to user key
   followType - int - no change
   regdate -timestamp - no change

groupMembers
   groupKey - No Change
   email - Change to user key
   memberType - No Change

prayer
   email - Change to key for both user and group
   postdate - No Change
   prayerkey - No Change

prayergroupsArray
   groupKey - varchar(65) - No Change
   groupName - varchar(150) - No Change
   isPrivate - tinyint(1) - No Change
   creator - Change to user Key
   createDate - timestamp - No change

reaction
   prayerkey - varchar(65) - No change
   reactor - change to user key
   reaction - int - No Change

user
   userKey - Add
   name - varchar(50) - No change
   email - varchar(200) - No change
   phone - varchar(10) - Increase size??
   regdate - timestamp - no change
   password - varchar(65) - change how encoded
   image - varchar(60) - no change