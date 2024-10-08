/*
File: PrayerOrder Prayer Page
Author: David Sarkies 
Initial: 21 September 2024
Update: 8 October 2024
Version: 0.3
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
	var search_results = document.getElementById('search_results');
	search_results.innerHTML = "";

	if (users_recieved.length>0) {
		search_results.classList.add('search-box');
	} else {
		search_results.classList.remove('search-box');
	}

	for (var x=0;x<users_recieved.length;x++) {
		create_tag("div",search_results,"search-results",users_recieved[x]['name'],users_recieved[x]['name']);
		otherUser = document.getElementById(users_recieved[x]['name']);

		if (users_recieved[x]['relationship'] == 'None') {

			img = document.createElement('img');
			img.src = "./Images/follow.png";
			img.width = 30;
			otherUser.appendChild(img);

			img = document.createElement('img');
			img.src = "./Images/block.png";
			img.width = 30;
			otherUser.appendChild(img);


			//No Icon - Can Follow/Block
		} else if (users_recieved[x]['relationship'] == 'Following') {
			//Following Icon - Unfollow/Block
		} else if (users_recieved[x]['relationship'] == 'Followed') {
			//Followed Icon - Can Follow/Block
		} else if (users_recieved[x]['relationship'] == 'Friends') {
			//Unfollowed Icon - Can Unfollow/Block
		}
	}	
}

function clearSearch() {
	document.getElementById('search_results').innerHTML = "";
	document.getElementById('search_results').classList.remove('search-box');
	document.getElementById('search-input').value = "";
}

/*
21 September 2024 - Created File
26 September 2024 - Data retrieved from backend thanks to ChatGPT
28 September 2024 - Added script to display results from search. Added script to clear search results
8 October 2024 - Added id to user tag
*/