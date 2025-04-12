/*
File: PrayerOrder Group Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 12 April 2025
Version: 1.6
*/

var createDisplayed = false;

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
	
	url = "selectGroup.php";

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
        	window.location.href = "mainGroup.php"; // Redirect on success
    	} else {
        	console.error("Error:", data.error);
    	}
	})
	.catch(error => console.error("Fetch error:", error));
};

function back() {
	window.location.href = "main.php";
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
12 April 2025 - Fixed up errors and added error box for blank
*/