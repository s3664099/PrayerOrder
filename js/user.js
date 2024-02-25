/*
File: PrayerOrder user JS Scripts Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 25 February 2024
Version: 0.0
*/

function validateLogin() {

	textHolder = document.getElementById("authenticationFailure");
	textHolder.innerHTML = "";
	email = document.getElementById("email");
	password = document.getElementById("password");
	errorMessage = "";
	noErrors = 0;
	event.preventDefault();

	if (email.value == "") {
		noErrors +=1;
		email.style.backgroundColor = "#ffcccb";
		errorMessage += "Email cannot be blank";
	}

	if (password.value == "") {

		if (noErrors == 1) {
			errorMessage += "<br>";
		}

		password.style.backgroundColor = "#ffcccb";
		errorMessage += "Password cannot be blank";
	}

	if (noErrors != 0) {
		create_tag("h3",textHolder,"failMessage",errorMessage);
	} else {
		document.getElementById("sign_in").submit();
	}
}

/*
25 February 2024 - Created file
*/