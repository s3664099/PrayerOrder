/*
File: PrayerOrder Sign In Page
Author: David Sarkies 
Initial: 5 January 2024
Update: 8 March 2026
Version: 1.4
*/

const ICON_PATH = "./Images/icon/";

function change_action(location,form_id) {

	const form = document.getElementById(form_id);
	if (form) {
		form.action = location;
		form.submit();
	}
}

//Creates a tag and adds it to the page
function create_tag(newTag,location,style,text,id=null) {
	let tag = document.createElement(newTag);
	add_classes(tag,style);
	tag.textContent = text;

	if (id) {
		tag.id = id;	
	}

	location.appendChild(tag);
}

function create_simple_tag(newTag,style,text) {
	let tag = document.createElement(newTag);
	add_classes(tag,style);
	tag.textContent = text;
	return tag;
}

//Adds multiple classes to the div
function add_classes(div,classString) {

	if (classString) {
		const classes = classString.split(" ");
		div.classList.add(...classes);
	}
	return div;	
}

function validate_input(input,noErrors,errorMessage,inputName) {

	if (noErrors>0) {
		errorMessage += "<br>";
	}

	if (!input.value.trim()) {

		input.style.backgroundColor = "#ffcccb";
		errorMessage = errorMessage + inputName + " cannot be blank";
		noErrors++;
	} else {
		input.style.backgroundColor = "white";
	}

	return [errorMessage,noErrors]
}

function validateEmail(email) {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
}

function add_img_butt(src,title,onClick,el,className,width) {
	el.appendChild(createImage(src,title,width,className,onClick));
}

function addImg(imageSrc,tag,tagClass,imgTitle,imgSize=20) {

	let img = createImage(imageSrc,imgTitle,imgSize);
	tag.appendChild(img);
	tag.classList.add(tagClass);
}

function addImgFront(imageSrc,tag,imgClass,imgTitle,imgSize=20,onClick=null) {

	let img = createImage(imageSrc,imgTitle,imgSize,imgClass,onClick);
	tag.insertBefore(img,tag.childNodes[0]);
}

function createImage(src, title, width = 20, className = null, onClick = null) {

  const img = document.createElement("img");

  img.src = ICON_PATH + src;
  img.width = width;
  img.alt = title;
  img.title = title;

  if (className) {
    img.classList.add(className);
  }

  if (onClick) {
    img.addEventListener("click", onClick);
  }

  return img;
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
5 March 2026 - Removed implicit global variables
						 - Changed innerHTML to textContent
						 - Tightened images functions
8 March 2026 - Updated & tightened code
*/