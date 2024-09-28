/*
File: PrayerOrder Prayer Page
Author: David Sarkies 
Initial: 21 September 2024
Update: 28 September 2024
Version: 0.2
*/

function switchSearch() {

	if (document.getElementById('search-box').style.visibility == "hidden") {
		document.getElementById('search-box').style.visibility = "visible";
	} else {
		document.getElementById('search-box').style.visibility = "hidden";
	}
}

function find_user(search_query) {

	url = "users.php?users="+search_query.value;

	if (search_query.value.length>0) {

		fetch(url,{method: "GET"})
		.then(response => response.json())
	    .then(data => {
            console.log(data); // Log the response (array of users)
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
	document.getElementById('search_results').innerHTML = "";

	for (var x=0;x<users_recieved.length;x++) {
		create_tag("div",document.getElementById('search_results'),"",users_recieved[x]['name']);
	}	
}

function clearSearch() {
	document.getElementById('search_results').innerHTML = "";
	document.getElementById('search-input').value = "";
}

/*
21 September 2024 - Created File
26 September 2024 - Data retrieved from backend thanks to ChatGPT
28 September 2024 - Added script to display results from search. Added script to clear search results
*/