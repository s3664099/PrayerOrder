<?php

/*
File: PrayerOrder db functions
Author: David Sarkies 
Initial: 27 July 2024
Update: 15 April 2025
Version: 1.9
*/

class db_functions {

	private $conn;

	/* ====================================================================================
	 * =                              Constructor
	 * ====================================================================================
	 */
	function __construct() {
	
		//Loads authentication for json file
		$json = file_get_contents('../../Database/db_login.json');
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

	function add_user($name,$email,$phone,$password) {

		$password = hash("sha256",$password.$email);

		$stmt = $this->conn->prepare("INSERT INTO user (name, email, phone,password) VALUES (?, ?, ?,?)");
		$stmt->bind_param("ssss",$name, $email , $phone, $password);
		$stmt->execute();
	}

	function authenticate_user($email,$password) {

		$authenticated = False;
		$hashedPwd = hash("sha256",$password.$email);

		$sql = "SELECT * FROM user WHERE email=? AND password=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$email,$hashedPwd);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows == 1) {
			$authenticated = True;
		}

		return $authenticated;
	}

	function checkValue($var,$value) {

		$value_exists = false;
		$sql = "SELECT * FROM user WHERE email=?";

		if ($var=="phone") {
			$sql = "SELECT * FROM user WHERE phone=?";
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s",$value);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$value_exists = true;
		}

		return $value_exists;
	}

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

	//Search function for users who haven't blocked user
	function getUsers($name,$user) {

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
            LIMIT 5";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$name,$user,$user);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;
	}

	/*====================================================================================
	* =                               Relationship Functions
	* ====================================================================================
	*/

	//Blocking relationships:
	//	3 - No Relationship Exists
	//	4 - Relationship Exists
	function updateRelationship($follower,$followee,$relType) {

		$stmt="";

		if ($relType==1 || $relType==3 || $relType==5) {
			$stmt = $this->conn->prepare("INSERT INTO connection(follower,followee,followType) VALUES (?,?,?)");
			$stmt->bind_param("ssi",$follower,$followee,$relType);
		} else if ($relType==2 || $relType==0 || $relType==4) {

			//Unfollowing a friend
			if($relType==0) {
				$relType = 1;
			} else if ($relType==4) {
				$relType = 3;
			}

			$stmt = $this->conn->prepare("UPDATE connection SET followType=? WHERE follower=? AND followee=?");
			$stmt->bind_param("iss",$relType,$follower,$followee);
		}

		if($stmt->execute()) {
			error_log("Success");
		} else {
			error_log("Failed");
		}
	}

	function getRelationship($follower,$followee) {

		$sql = "SELECT followType FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();
		
		return $stmt->get_result();
	}

	//Delete relationship
	function removeRelationship($follower,$followee) {
		$sql = "DELETE FROM connection WHERE follower=? AND followee=?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$follower,$followee);
		$stmt->execute();

		return $stmt->get_result();
	}

	/*====================================================================================
	* =                               Group Functions
	* ====================================================================================
	*/

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
				$sql = "INSERT INTO groupMembers(groupKey,email,isAdmin) VALUES (?,?,?)";
				$stmt = $this->conn->prepare($sql);
				
				if (!$stmt) {
					error_log("Prepare failed for groupMembers".$this->conn->error);
				} else {
					$isAdmin = 1;
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

		$sql = "SELECT prayergroups.groupName, groupMembers.isAdmin, prayergroups.groupKey 
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

	/*====================================================================================
	* =
	* =                               Prayer Functions
	* =
	* ====================================================================================
	*/

	//Add prayer metadata
	function addPrayer($user,$postDate,$key) {

		$sql = "INSERT INTO prayer(email,postdate,prayerkey) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$user,$postDate,$key);
		
		if($stmt->execute()) {
			error_log("Success");
		} else {
			error_log("Failure: ".$stmt->error);
		}
	}


	function getPrayer($user) {

		$sql = "SELECT postdate,prayerkey,user.name,user.image 
				FROM prayer 
				JOIN user ON prayer.email=user.email 
				JOIN connection 
				  ON (
					 (connection.follower = ? AND connection.followee = user.email
					 						  AND connection.followType IN ('1','2'))
					 OR
					 (connection.followee = ? AND connection.follower = user.email
					 						  AND connection.followType IN ('2')))";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$user,$user);
		$stmt->execute();

		return $stmt->get_result();
	}

	/*====================================================================================
	* =                               Prayer Reactions
	* ====================================================================================
	*/

	//Reaction
	function checkReaction($user,$prayerKey) {

		$exists = 0;

		$sql = "SELECT * FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$user);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			$exists=$row['reaction'];
		}
		return $exists;
	}

	function addReaction($user,$prayerKey,$reaction) {

		$sql = "INSERT INTO reaction (prayerkey,reactor,reaction) VALUES (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$prayerKey,$user,$reaction);
		
		if (!$stmt->execute()) {
			error_log("Failed ".$stmt->error);
		}

	}

	function updateReaction($user,$prayerKey,$reaction) {

		$sql = "UPDATE reaction SET reaction = ? WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sss",$reaction,$prayerKey,$user);
		
		if (!$stmt->execute()) {
			error_log("Failed ".$stmt->error);
		}

	}

	function deleteReaction($user,$prayerKey) {

		$sql = "DELETE FROM reaction WHERE prayerkey = ? AND reactor = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$user);
		$stmt->execute();

	}

	function countReaction($prayerKey,$react) {
		
		$sql = "SELECT COUNT(*) FROM reaction WHERE prayerkey = ? AND reaction = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss",$prayerKey,$react);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
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
*/
?>
