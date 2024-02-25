/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 25 February 2024
Version: 0.1
*/

function change_action(location,form_id) {

	form = document.getElementById(form_id);
	form.action = location;
	form.submit;
}

//Creates a tag and adds it to the page
function create_tag(newTag,location,style,text) {
	var tag = document.createElement(newTag);
	add_classes(tag,style);
	tag.innerHTML = text;
	location.appendChild(tag);
}

//Adds multiple classes to the div
function add_classes(div,argument) {

	if (argument.length>0) {
		classes = argument.split(" ");

		for (var x=0;x<classes.length;x++) {
			div.classList.add(classes[x])
		}
	}
	return div;	
}

/*
5 January 2024 - Created file
25 February 2024 - Added functions to create a new tag, and to add classes to a tag
*/