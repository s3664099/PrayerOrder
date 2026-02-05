/*
File: PrayerOrder Main Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 5 February 2026
Version: 1.3
*/

document.getElementById('search-icon').addEventListener('click', switchSearch);
document.getElementById('search-icon').addEventListener('click', clearSearch);

function switchSearch() {

	if (document.getElementById('search-box').style.visibility == "hidden") {
		document.getElementById('search-box').style.visibility = "visible";
	} else {
		document.getElementById('search-box').style.visibility = "hidden";
	}
}

function clearSearch() {
	document.getElementById('search_results').innerHTML = "";
	document.getElementById('search_results').classList.remove('search-box');
	document.getElementById('search-input').value = "";
}

function groupPage() {
	window.location.href = "groups.php";
}

function userPage() {
	window.location.href = "main.php";
}

/*
30 January 2025 - Created file
13 February 2025 - Added function call to remove error box
29 March 2025 - Removed the SetPrayerPage function and added the clearSearch function
				Added function to redirect to group
5 February 2026 - Added js to add click functions to search button
*/