/*
File: PrayerOrder user functions
Author: David Sarkies 
Initial: 30 January 2025
Update: 29 March 2025
Version: 1.2
*/

function find_user() {

	search_query = document.getElementById('search-input')
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
		addUserLine(relationship,otherUser);
	}	
}

function addUserLine(relationship,otherUser) {

	//Removes the class that is added if no relationship exists
	otherUser.classList.remove('noRelationship');

	if (relationship == 'None') {

		add_img_butt('follow.png','follow',follow,otherUser,'search-icon',20);
		otherUser.classList.add("noRelationship");

	} else if (relationship == 'Following') {

		addRelImg("./Images/icon/following.png",otherUser,'haveRelationship','Following');
		add_img_butt('unfollow.png','unfollow',unfollow,otherUser,'search-icon',20);

	} else if (relationship == 'Followed') {

		addRelImg("./Images/icon/followed_by.png",otherUser,'haveRelationship','Followed By');
		add_img_butt('follow.png','follow',follow,otherUser,'search-icon',20);

	} else if (relationship == 'Friends') {

		addRelImg("./Images/icon/friends.png",otherUser,'haveRelationship','Friends');
		add_img_butt('unfollow.png','unfollow',unfollow,otherUser,'search-icon',20);

	}

	if (relationship == 'Blocked') {
		addRelImg("./Images/icon/block.png",otherUser,'haveRelationship','Blocked');
		add_img_butt('unblock.png','unblock',unblock,otherUser,'search-icon',20);
	} else {
		add_img_butt('block.png','block',block,otherUser,'search-icon',20);
	}
}

function addRelImg(imageSrc,tag,tagClass,imgTitle) {

	img = document.createElement('img');
	img.src = imageSrc;
	img.width = 20;
	img.alt = imgTitle;
	img.title = imgTitle;
	img.classList.add("haveRelationship");
	tag.insertBefore(img,tag.childNodes[0]);
}

function follow(evt) {
	change_relationship(evt,1);
}

function block(evt) {
	change_relationship(evt,3);
}

function unblock(evt) {
	change_relationship(evt,4);
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
	} else if (relType==4) {
		url += "&relationship=4";
	}

	fetch(url,{method: "GET"})
	.then(response => response.json())
	.then(data => {
        
        othuser = document.getElementById("user"+user_no);
        userRel = othuser.childNodes[0];
        name = othuser.textContent.trim();
        othuser.innerHTML= name;
        relationship = data['relationship'];
        addUserLine(relationship,othuser,userRel);

        if (relationship == "None") {

        	if (data['response'] == 'unblocked') {
        		alert(data['response']);
        	} else {
		        alert("Unfollowed");
		    }
	    } else {
	    	alert(relationship);
	    }
    })
	.catch(error => {
	    console.error('Error:', error);
	}); 
}

function setUser() {
	document.getElementById("button-type").innerHTML = document.getElementById('user-button').innerHTML;
	document.getElementById("display-box").innerHTML = document.getElementById('groups').innerHTML;
	document.getElementById('input-box').innerHTML="";
	document.getElementById('input-box').classList.remove("bb-solid-3px");
	document.getElementById("search-input").removeEventListener('keyup',find_user);
	clearSearch();
}

/*
30 January 2025 - Create file
13 February 2025 - Added switch to display groups user is in
29 March 2025 - Moved the clearSearch function to main_page.js
*/