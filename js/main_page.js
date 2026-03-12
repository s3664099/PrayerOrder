/*
File: PrayerOrder Main Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 12 March 2026
Version: 1.5
*/

const searchIcon = document.getElementById('search-icon');
if (searchIcon) {
    searchIcon.addEventListener('click', () => {
    	switchSearch();
    	clearSearch();
	});
}
const searchInput = document.getElementById('search-input');
if (searchInput) {
	searchInput.addEventListener('input', find_user);
}

document.getElementById('clear-search').addEventListener('click', clearSearch);
document.getElementById('group-icon').addEventListener('click', groupPage);
document.getElementById('pray')
    .addEventListener('submit', function(e) {
        e.preventDefault();
        sendPrayer();
    });

function switchSearch() {
	const searchBox = document.getElementById('search-box').style.visibility;
	if (searchBox == "hidden") {
		searchBox = "visible";
	} else {
		searchBox = "hidden";
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
19 February 2026 - Moved more functions to js.
12 March 2026 - Started tidying up script
*/