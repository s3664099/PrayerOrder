/*
File: PrayerOrder Group Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 30 January 2025
Version: 1.0
*/

var createDisplayed = false;

function setGroup() {
	document.getElementById("button-type").innerHTML = document.getElementById('group-button').innerHTML;
	document.getElementById("input-box").innerHTML = document.getElementById('prayer-ask').innerHTML;
	document.getElementById("display-box").innerHTML = document.getElementById('prayers').innerHTML;
	document.getElementById('input-box').classList.add("bt-solid-1px");
	document.getElementById('input-box').classList.add("bb-solid-3px");
	document.getElementById("search-input").addEventListener('keyup',find_user);

	if (document.getElementById('search-icon').onclick == null) {
		document.getElementById('search-icon').setAttribute("onClick", "switchSearch(),clearSearch()");
	}
}

function createGroup() {

	console.log(document.getElementById('search-icon').onclick)

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
}

/*
30 January 2025 - Create file
*/