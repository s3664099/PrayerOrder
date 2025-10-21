<?php

/*
File: PrayerOrder db functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 6 July 2025
Version: 1.18
*/

class db_functions {

	private $conn;

	/* ====================================================================================
	 * =                              Constructor
	 * ====================================================================================
	 */
	function __construct() {
	
		//Loads authentication for json file
		$json = file_get_contents(__DIR__ . '/db_login.json');
		$json_data = json_decode($json,true);

		$servername = $json_data['name'];
		$username = $json_data['user'];
		$password = $json_data['pw'];
		$dbname = $json_data['dbname'];

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($this->conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 
	}
	/* ====================================================================================
	 * +
	 * =                                      User Functions
	 * =                              
	 * ====================================================================================
	 * =                               Authentication Functions
	 * ====================================================================================
	 */



	/*====================================================================================
	* =                               User Search Functions
	* ====================================================================================
	*/

	function retrieve_data() {

		$sql = "SELECT * FROM user";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
		    error_log(print_r($row, true));
		}		

	}

	function getUserName($email) {

		$sql = "SELECT name FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();
		$userName = $result->fetch_assoc()['name'];

		return $userName;
	}



	//Search function for inviting user to group (the user isn't a current member of the group)
	function inviteUsers($name,$user,$groupKey) {

		$name = "%" . $name . "%";
    	$sql = "SELECT name, email
        	    FROM user
        	    WHERE user.name LIKE ? 
        	    	AND user.email != ? 
              		AND NOT EXISTS (
                		SELECT 1 FROM connection 
                  		WHERE follower = user.email 
                    	AND followee = ? 
                    	AND followType = 5
            		)
            		AND NOT EXISTS (
        				SELECT 1 FROM groupMembers 
        				WHERE groupMembers.email = user.email 
          				AND groupMembers.groupKey = ?
  					)
            	LIMIT 5";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssss",$name,$user,$user,$groupKey);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

	function userExists($email) {
		$userExists = false;

		$sql = "SELECT * FROM user WHERE email=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows==1) {
			$userExists = true;
		}

		return $userExists;
	}


	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	*/

	//Blocking relationships:
	//	3 - No Relationship Exists
	//	4 - Relationship Exists


	function inviteUser($email,$groupKey) {

		$success = 0;

		if($this->userExists($email)) {
			if(!$this->userInGroup($email,$groupKey)) {
				$sql = "INSERT INTO groupMembers(groupKey,email,memberType) VALUES (?,?,?)";
				$stmt = $this->conn->prepare($sql);

				if(!$stmt) {
					error_log("Prepare failed for inviteUser".$this->conn->error);
				} else {
					$memberType = "p";
					$stmt->bind_param("sss",$groupKey,$email,$memberType);
					if($stmt->execute()) {
						error_log("Success");
						$success = 1;
					}
				}

			} else {
				error_log($groupKey);
				error_log("User in group");
			} 
		} else {
			error_log("No such user");
		}

		return $success;
	}

	function executeInvite($sql,$email,$groupKey,$functionName) {

		if($this->userExists($email)) {
			if($this->userInGroup($email,$groupKey)) {
				$stmt = $this->conn->prepare($sql);

				if(!$stmt) {
					error_log("Prepare failed for ".$functionName.$this->conn->error);
				} else {
					$stmt->bind_param("ss",$groupKey,$email);
					if($stmt->execute()) {
						error_log("Success");
					}
				}
			} else {
				error_log($groupKey);
				error_log("User not in group");
			}
		} else {
			error_log("No such user");
		}		
	}

	function acceptInvite($email,$groupKey){

		$this->executeInvite("UPDATE groupMembers 
						SET memberType='m' 
						WHERE groupKey=? AND email=?",
					  $email,$groupKey,"acceptInvite");
	}

	function rejectInvite($email,$groupKey){

		$this->executeInvite("DELETE FROM groupMembers WHERE groupKey=? AND email=?",$email,$groupKey,"deleteInvite");
	}

	/*====================================================================================
	* =                               Group Functions
	* ====================================================================================
	*/

	//member type - m - member, p - pending, b - blocked, c - creator, a - admin

	//Check Group Exists
	function checkGroup($key) {

		$value_exists = false;

		$sql = "SELECT * FROM prayergroups WHERE groupKey=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$key);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$value_exists = true;
		}

		return $value_exists;
	}

	//Add a new group
	function addGroup($key,$name,$private,$owner) {

		$sql = "INSERT INTO prayergroups(groupKey,groupName,isPrivate,creator) VALUES (?,?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$success = false;

		if (!$stmt) {
			error_log("Prepare failed for prayergroups: ".$this->conn->error);
		} else {
			$stmt->bind_param("ssss",$key,$name,$private,$owner);
			if($stmt->execute()) {
				$sql = "INSERT INTO groupMembers(groupKey,email,memberType) VALUES (?,?,?)";
				$stmt = $this->conn->prepare($sql);
				
				if (!$stmt) {
					error_log("Prepare failed for groupMembers".$this->conn->error);
				} else {
					$isAdmin = "c";
					$stmt->bind_param("sss",$key,$owner,$isAdmin);

					if ($stmt->execute()) {
						error_log("Success");
						$success = true;
					} else {
						error_log("Failed Two: ".$stmt->error);
					}
				}
			} else {
				error_log("Failed One: ".$stmt->error);
			}
		}

		return $success;
	}

	function getGroups($user) {

		$sql = "SELECT prayergroups.groupName, groupMembers.memberType, prayergroups.groupKey 
				FROM prayergroups
				JOIN groupMembers ON prayergroups.groupKey=groupMembers.groupKey
				WHERE groupMembers.email = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$user);
		$stmt->execute();

		return $stmt->get_result();
	}

	function getGroupName($group_key) {

    	$sql = "SELECT groupName FROM prayergroups WHERE groupKey = ?";
    	$stmt = $this->conn->prepare($sql);
    	$stmt->bind_param("s", $group_key);
    	$stmt->execute();
    	$result = $stmt->get_result();

    	// Fetch all group names into an array
    	$groupName = null;
    	if ($row = $result->fetch_assoc()) {
    		$groupName = $row['groupName'];
    	}

	    return $groupName;
	}

	function userInGroup($email,$groupKey) {
		
		$userInGroup = false;
		$sql = "SELECT * FROM groupMembers WHERE email=? AND groupKey=?";
		$stmt=$this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$groupKey);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows==1) {
			$userInGroup = true;
		}

		return $userInGroup;
	}

	function getInvites($email) {
		$sql = "SELECT prayergroups.groupName,prayergroups.groupKey
				FROM prayergroups 
				JOIN groupMembers ON prayergroups.groupKey=groupMembers.groupKey
				WHERE groupMembers.email=? AND groupMembers.memberType='p'";
		$stmt=$this->conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

	function getUserType($key,$email) {
	
		$sql = "SELECT groupMembers.memberType
				FROM groupMembers
				WHERE groupMembers.email=? AND groupMembers.groupKey=?";
		$stmt=$this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$key);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}


	function getMembers($groupKey) {
		$sql = "SELECT user.name,user.email,groupMembers.memberType
				FROM user 
				JOIN groupMembers ON groupMembers.email=user.email
				WHERE groupMembers.groupKey=? AND (groupMembers.memberType='m'
												OR groupMembers.memberType='c'
												OR groupMembers.memberType='a')";
		$stmt=$this->conn->prepare($sql);
		$stmt->bind_param("s",$groupKey);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

	/*====================================================================================
	* =
	* =                               Prayer Functions
	* =
	* ====================================================================================
	*/






	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/






}

/*
27 July 2024 - Created file
12 September 2024 - Added check value function
13 September 2024 - Got check value working
15 September 2024 - Added function to retrieve user name for database
26 September 2024 - Retrieve users with matching name
1 October 2024 - Added code to retrieve email with search
6 October 2024 - Added notes for connection table
17 October 2024 - Added code to read and add to the connections table
19 October 2024 - Moved code to process results from connections table out.
20 October 2024 - Added code to update relationship. Added code to delete relationship
21 November 2024 - Updated authentication to hashed passwords.
22 November 2024 - SQL works where user is follower. Added code to hash password when user created
				   Added SQL to exclude current user from query
23 November 2024 - Sorted functions into categories. Finished SQL for search for users that haven't blocked user
24 Novemver 2024 - Limited what was retrieved from prayer request SQL
5 December 2024 - Increased Version
19 December 2024 - Added function to check if a reaction exists
24 December 2024 - Added shells for the reaction interactions in the database
25 December 2024 - Added code to add, update, and delete entries from the reaction table
				 - Added count function for prayer reactions
27 December 2024 - Removed the 'success' logs, and only kept the errors.
8 February 2025 - Added functions for group table
12 February 2025 - Group details now save
13 February 2025 - Added retrieval for user's groups
16 Febrary 2025 - Retrieved group id from group table for selecting group
5 April 2025 - Fixed problem where blocked users not being displayed for blocker
15 April 2025 - Retrieves Group Name
19 April 2025 - Fixed location of json file.
10 May 2025 - Added sql for inviting a user
11 May 2025 - Updated sql to handle memberType as opposed to isAdmin
13 May 2025 - Started building invite database access
			  Added validation to confirm user exists and in group
			  Added code to add invited user to group
15 May 2025 - Added retrieve invite functions
18 May 2025 - Added function to change memberstatus from pending to accepted
			- Added delete invite function
20 May 2025 - Added function to retrieve all group members
27 May 2025 - Added email when retrieving group memeber
			- Added getUserType function
7 June 2025 - Fixed error when accepting invites.
6 July 2025 - Started moving functions over
*/
?>
