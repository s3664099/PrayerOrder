/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 5 December 2024
Version: 1.0

	Prayer
	- Create NoSQL db to store prayers
	- Once done can increase number and move onto groups
	
	v1.0
	Group
	- when select sets variable for a group
	- Search invites people to group
	- User gets message (appears at top) inviting them to join group
	- The ask prayer has arrows to circle through people in group to add prayer
	- Add to all users and then press pray
	- Also tick to advise whether available
	- sends prayer to random person in group
		- Does not get own prayer
		- Can get more than one prayer if users not present

	- Then do create group, select group
*/

function change_action(location,form_id) {

	form = document.getElementById(form_id);
	form.action = location;
	form.name = location;
	form.submit;
}

//Creates a tag and adds it to the page
function create_tag(newTag,location,style,text) {
	var tag = document.createElement(newTag);
	add_classes(tag,style);
	tag.innerHTML = text;

	if (arguments.length>4) {
		tag.id = arguments[4];	
	}

	location.appendChild(tag);
}

function create_simple_tag(newTag,style,text) {
	var tag = document.createElement(newTag);
	add_classes(tag,style);
	tag.innerHTML = text;
	return tag;
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

function validate_input(input,noErrors,errorMessage,inputName) {

	if (noErrors>0) {
		errorMessage += "<br>";
	}

	if (input.value == "") {

		input.style.backgroundColor = "#ffcccb";
		errorMessage = errorMessage + inputName + " cannot be blank";
		noErrors ++;
	} else {
		input.style.backgroundColor = "white";
	}

	return [errorMessage,noErrors]
}

function add_img_butt(img_file,title,img_func,el,img_class,img_size) {

	img = document.createElement('img');
	img.src = "./Images/icon/"+img_file;
	img.width = img_size;
	img.classList.add(img_class);
	img.title = title;
	img.alt = title;
	img.addEventListener("click",img_func);
	el.appendChild(img);
}

function addImg(imageSrc,tag,tagClass,imgTitle) {

	img = document.createElement('img');
	img.src = imageSrc;
	img.width = 20;
	img.alt = imgTitle;
	img.title = imgTitle;
	tag.appendChild(img);
	tag.classList.add(tagClass);
}

/*
5 January 2024 - Created file
25 February 2024 - Added functions to create a new tag, and to add classes to a tag
19 July 2024 - Updated change action.
13 October 2024 - Added function to add an image button.
27 October 2024 - Added function to create a standalone icon
26 November 2024 - Moved images to specific icon folder
5 December 2024 - Increased Version
*/