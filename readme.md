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




## TODO
Add attempt counts so as to prevent brute force attacks - delay responses
Add extra flags to alert user if account disabled
IP registering for potential bot accounts
Prevent brute force attacks

- this will then require password changing/forgotten.

- in relationship_services - get relationship, it is called twice - this should only be once and it is extra reads
      need up update query to do both.
- some instances where the DB column name is used - should use a constant - possibly put it in the files where they're read
   eg: ($relationship = $relationship_service->get_relationship($user_id,$other_user['id']);)


[Sat Dec 13 08:50:47 2025] Missing POST parameter











   
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
   phone - varchar(10) - 
   regdate - timestamp - no change
   password - varchar(65) - 
   image - varchar(60) - no change


- Untangle the code with regards to relationships
- Tighten db code further regarding SQL Queries (and add close as well)



---

## 🧭 **Recommended Review Order**
























3. `includes/user/users.php`
4. `includes/user/message.php`

6. `includes/user/error.php`

👉 *Goal:* verify input sanitization, password handling, session safety, and correctness of SQL joins for user relationships.

---

### **3. Prayer Logic (main app domain)**

Next, review how your core domain works — this is where most logic bugs and inefficiencies hide.

1. `includes/prayer/prayer.php`
2. `includes/prayer/prayers.php`
3. Any prayer-related AJAX endpoints referenced in `prayer_page.js`.

👉 *Goal:* check data retrieval, display logic, and consistency between read/write DB layers.

---

### **4. Group Logic (secondary domain)**

Once user and prayer systems are confirmed solid, look at group behaviour.
They depend on both users and prayers.

1. `includes/group/group_functions.php`
2. `includes/group/group_prayers.php`
3. `includes/group/group_select.php`
4. `includes/group/create_group.php`
5. `includes/group/error.php`
6. `includes/user/inviteUsers.php`

👉 *Goal:* ensure proper joins to `groupMembers`, correct handling of invitations, and no redundant queries.

---

### **5. Common Includes (cross-cutting)**

Now review the shared glue code — they influence every page indirectly.

1. `includes/common/redirect_signin.php`
2. `includes/common/header.php`
3. `includes/common/title.php`

👉 *Goal:* confirm consistent session usage and prevent header/session race conditions.

---

### **6. Front-end Pages (entry points)**

After confirming all back-end logic, move to the actual PHP pages in root.
They assemble HTML and JS and wire everything together.

1. `index.php`
2. `signin.php`
3. `signup.php`
4. `main.php`
5. `prayer_page.php`
6. `group_page.php`
7. `groups.php`

👉 *Goal:* check for correct includes, minimal logic in views, clean routing, and session checks.

---

### **7. JavaScript Frontend**

Finally, review the client-side logic that interacts with the backend.

1. `js/standard.js` (global utilities)
2. `js/login_page.js`
3. `js/main_page.js`
4. `js/prayer_page.js`
5. `js/group_page.js`
6. `js/user_page.js`

👉 *Goal:* verify AJAX paths, consistent JSON structures, and error handling.

---

### **8. CSS (optional aesthetic pass)**

Last, if you want a polish pass, you can look at:

* `css/standard.css` (base)
* Then page-specific ones.

---

Would you like me to **start the audit** from step 1 (`db_handler.php`) right now — with the *Good, Bad, and Ugly* breakdown format?
