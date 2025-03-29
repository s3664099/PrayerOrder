/*
File: PrayerOrder Main Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 29 March 2025
Version: 1.2
*/

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
	window.location.href = "index.php";
}

/*
30 January 2025 - Created file
13 February 2025 - Added function call to remove error box
29 March 2025 - Removed the SetPrayerPage function and added the clearSearch function
				Added function to redirect to group
*/