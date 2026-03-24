/*
File: PrayerOrder Main Page functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 12 March 2026
Version: 1.6
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
const clearSearchElement = document.getElementById('clear-search');
if(clearSearchElement) {
	clearSearchElement.addEventListener('click', clearSearch);
}
const groupIcon = document.getElementById('group-icon');
if (groupIcon) {
	groupIcon.addEventListener('click', groupPage);
}
const prayIcon = document.getElementById('pray');
if (prayIcon) {
	prayIcon.addEventListener('submit', function(e) {
        e.preventDefault();
        sendPrayer();
    });
}

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
19 February 2026 - Moved more functions to js.
12 March 2026 - Tidied up script
*/