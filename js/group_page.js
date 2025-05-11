/*
File: PrayerOrder Group Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 11 May 2025
Version: 1.9
*/

var createDisplayed = false;
var inviteDisplayed = false;
var inputBox = document.getElementById("input-box");

function invite() {

	if (!inviteDisplayed) {
		inputBox.innerHTML = document.getElementById('invite-box').innerHTML;
		inviteDisplayed = true;
	} else {
		inputBox.innerHTML="";
		inviteDisplayed = false;
	}
}

function clearSearch(inputField) {
	inputField.value = "";
}


function findUser() {

	search_query = document.getElementById('invite-input')
	url = "includes/user/inviteUsers.php?users="+search_query.value;
	
	if (search_query.value.length>0) {

		fetch(url,{method: "GET"})
		.then(response => response.json())
	    .then(data => {
            displayUsers(data); // Call function to display users
        })
	    .catch(error => {
	        console.error('Error:', error);
	    });
	} else {
		document.getElementById('search_results').innerHTML = "";
	}
}

function displayUsers(users_recieved) {

	//Creates area to hold user details
	var search_results = document.getElementById('search_results');
	var hid_locs = document.getElementById('hid_loc');
	search_results.innerHTML = "";
	hid_locs.innerHTML = "";

	if (users_recieved.length>0) {
		search_results.classList.add('search-box');
	} else {
		search_results.classList.remove('search-box');
	}

	for (var x=0;x<users_recieved.length;x++) {

		hid_tag = "hidusrdtls"+x;
		create_tag("div",search_results,"search-results",users_recieved[x]['name'],x);
		create_tag("span",hid_locs,"hidden","",hid_tag);
		document.getElementById(hid_tag).innerHTML = users_recieved[x]['email'];
		user = document.getElementById(x);
		addImgFront('send-invite.png',user,'search-icon','imvite');

		//Add status to the user in the group (member, pending, banned)
		//Add an invite button that sends out an invite to the user
		//When an invite is sent, the user will added to the group with a status of pending
		//If the user rejects the invite, the user is removed from the group
	}	
}

function sendInvite() {
	alert("Invite sent");
}

function createGroup() {

	if (!createDisplayed) {
		document.getElementById("input-box").innerHTML = document.getElementById('group-create').innerHTML;
		document.getElementById("add-group").src="./Images/icon/removeGroup.png";
		document.getElementById('input-box').classList.add("bb-solid-3px");
		document.getElementById('search-icon').removeAttribute('onClick');
		createDisplayed = true;
	} else {
		document.getElementById("input-box").innerHTML = "";
		document.getElementById('input-box').classList.remove("bb-solid-3px");
		document.getElementById("add-group").src="./Images/icon/addGroup.png";
		document.getElementById('search-icon').setAttribute("onClick", "switchSearch(),clearSearch()");
		createDisplayed = false;
	}

	removeErrorBox();
}

//Validates group being created
function newGroup() {
	
	event.preventDefault();
	prayer = document.getElementById("group-name");
	
	if (prayer.value.length==0) {
		displayError(document.getElementById("error-box"),"Group needs a name name!");
	} else {
		document.getElementById("create-group").submit();
	}
}

function displayError(display,errorMessage) {
	display.innerHTML = errorMessage;
	display.style.display = "block";
}

//Group exists error
function displayGroupExists(){
	groupExists = document.getElementById('error-field');
	groupExists.style.display = "block";
	groupExists.innerHTML = "Group Already Exists";
}

function removeErrorBox() {
	groupExists = document.getElementById('error-field');
	if (groupExists.style.display == "block") {
		groupExists.style.display = "none";
		groupExists.innerHTML = "";
	}
}

function selectGroup(group) {
	
	url = "includes/group/group_select.php";

	fetch(url,{   
		method: "POST",
   	headers: {
        "Content-Type": "application/json" // Sending JSON
    	},
    	body: JSON.stringify({
    		group:0,
        	id: group.id
    	})
	})
	.then(response => response.json())  // Convert response to JSON
	.then(data => {
    	
    	if (data.success) { // Assuming the response contains a "success" field
        	window.location.href = "group_page.php"; // Redirect on success
    	} else {
        	console.error("Error:", data.error);
    	}
	})
	.catch(error => console.error("Fetch error:", error));
};

function back() {
	window.location.href = "groups.php";
}

function main_screen() {
	window.location.href = "main.php";
}


/*
30 January 2025 - Create file
8 February 2025 - Added function to validate group submission
13 February 2025 - Added function to remove error box when displayed
16 February 2025 - Added selectGroup function. Added fetch for setting group
18 March 2025 - Added function to return to main screen and back to group page
29 March 2025 - Removed setGroup function
12 April 2025 - Fixed up errors and added error box for blank. Renamed group page
			  - Changed redirect for back to groups
19 April 2025 - Moved group_select
10 May 2025 - Added function for retrieving users to send invites to.
11 May 2025 - Added function to add image to front of text
*/