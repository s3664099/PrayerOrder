/*
File: PrayerOrder Prayer Page
Author: David Sarkies 
Initial: 21 September 2024
Update: 21 September 2024
Version: 0.0
*/

function switch_search() {

	if (document.getElementById('search-box').style.visibility == "hidden") {
		document.getElementById('search-box').style.visibility = "visible";
	} else {
		document.getElementById('search-box').style.visibility = "hidden";
	}
}

function find_user(search_query) {

	url = "users.php?users="+search_query.value;
	console.log(url);

	fetch(url,{method: "GET"})
    .then(response => response.text())
    .catch(error => {
        console.error('Error:', error);
    });
}

/*
21 September 2024 - Created File
*/