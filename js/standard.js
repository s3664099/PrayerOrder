/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 11 May 2025
Version: 1.2
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

function validateEmail(email) {
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
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
	img.src = "./Images/icon/"+imageSrc;
	img.width = 20;
	img.alt = imgTitle;
	img.title = imgTitle;
	tag.appendChild(img);
	tag.classList.add(tagClass);
}

function addImgFront(imageSrc,tag,tagClass,imgTitle) {

	img = document.createElement('img');
	img.src = "./Images/icon/"+imageSrc;
	img.width = 20;
	img.alt = imgTitle;
	img.title = imgTitle;
	img.classList.add(tagClass);
	tag.insertBefore(img,tag.childNodes[0]);

	if (arguments.length>4) {
		addEvent(arguments[4],img);
	}
}

function addEvent(func,tag) {
	tag.addEventListener("click",func);
}

function homePage() {
	window.location.href = "index.php";
}

/*
5 January 2024 - Created file
25 February 2024 - Added functions to create a new tag, and to add classes to a tag
19 July 2024 - Updated change action.
13 October 2024 - Added function to add an image button.
27 October 2024 - Added function to create a standalone icon
26 November 2024 - Moved images to specific icon folder
5 December 2024 - Increased Version
12 April 2025 - Created home redirect
11 May 2025 - Added function to add image to front
*/