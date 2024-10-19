/*
File: PrayerOrder Prayer Page
Author: David Sarkies 
Initial: 21 September 2024
Update: 19 October 2024
Version: 0.5
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

	//Creates area to hold user details
	var search_results = document.getElementById('search_results');
	var hid_locs = document.getElementById('hid_loc');
	search_results.innerHTML = "";
	hid_locs.innerHTML = "";

	if (users_recieved.length>0) {
		search_results.classList.add('search-box');
	} else {
		search_results.classList.remove('search-box');
	}

	for (var x=0;x<users_recieved.length;x++) {

		hid_tag = "hidusrdtls"+users_recieved[x]['no'].substr(4);

		create_tag("div",search_results,"search-results",users_recieved[x]['name'],users_recieved[x]['no']);
		otherUser = document.getElementById(users_recieved[x]['no']);
		create_tag("span",hid_locs,"hidden","",hid_tag);
		document.getElementById(hid_tag).innerHTML = users_recieved[x]['email'];
		relationship = users_recieved[x]['relationship'];

		if (relationship == 'None') {

			add_img_butt('follow.png','follow',follow,otherUser,'search-icon',20);
			/*
			img = document.createElement('img');
			img.src = "./Images/block.png";
			img.width = 20;
			img.classList.add('search-icon');
			img.title = "block";
			img.addEventListener("click",follow);
			otherUser.appendChild(img);
			*/

		} else if (users_recieved[x]['relationship'] == 'Following') {
			//Following Icon

			add_img_butt('unfollow.png','unfollow',unfollow,otherUser,'search-icon',20);
		} else if (users_recieved[x]['relationship'] == 'Followed') {
			//Followed Icon

			add_img_butt('follow.png','follow',follow,otherUser,'search-icon',20);
		} else if (users_recieved[x]['relationship'] == 'Friends') {
			//Friends Icon

			add_img_butt('unfollow.png','unfollow',unfollow,otherUser,'search-icon',20);
		}
		add_img_butt('block.png','block',block,otherUser,'search-icon',20);	
	}	
}

function clearSearch() {
	document.getElementById('search_results').innerHTML = "";
	document.getElementById('search_results').classList.remove('search-box');
	document.getElementById('search-input').value = "";
}

function follow(evt) {
	change_relationship(evt,1);
}

function block(evt) {
	change_relationship(evt,3);
}

function unfollow(evt) {
	change_relationship(evt,0);
}

function change_relationship(user,relType) {

	user_no = user.srcElement.parentElement.id.substr(4);

	url = "users.php?follow="+document.getElementById("hidusrdtls"+user_no).innerHTML;

	if (relType==1) {
		url += "&relationship=1";
	} else if (relType==3) {
		url += "&relationship=3";
	} else if (relType==0) {
		url += "&relationship=0";
	}

	fetch(url,{method: "GET"})
	.then(response => response.json())
	.then(data => {
        console.log(data);
        //Popup that displays result of action
        //Reloads screen
    })
	.catch(error => {
	    console.error('Error:', error);
	}); 
}

/*
21 September 2024 - Created File
26 September 2024 - Data retrieved from backend thanks to ChatGPT
28 September 2024 - Added script to display results from search. Added script to clear search results
8 October 2024 - Added id to user tag
13 October 2024 - Added a unique id for users. Added styling for the icons for the search results
				- Stylised image buttons, and moved function to standard
19 October 2024 - Started building other icons. Added unfollow function
*/