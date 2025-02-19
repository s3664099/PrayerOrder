/*
File: PrayerOrder Main Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 13 February 2025
Version: 1.1
*/

function setPrayerPage() {
	document.getElementById("button-type").innerHTML = document.getElementById('group-button').innerHTML;
	document.getElementById("input-box").innerHTML = document.getElementById('prayer-ask').innerHTML;
	document.getElementById("display-box").innerHTML = document.getElementById('prayers').innerHTML;
	document.getElementById("search-input").addEventListener('keyup',find_user);
	removeErrorBox();
}

function switchSearch() {

	if (document.getElementById('search-box').style.visibility == "hidden") {
		document.getElementById('search-box').style.visibility = "visible";
	} else {
		document.getElementById('search-box').style.visibility = "hidden";
	}
}

/*
30 January 2025 - Created file
13 February 2025 - Added function call to remove error box
*/