/*
File: PrayerOrder user JS Scripts Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 23 February 2025
Version: 1.2
*/

function validateLogin() {

	textHolder = document.getElementById("authenticationFailure");
	textHolder.innerHTML = "";
	email = document.getElementById("email");
	password = document.getElementById("password");
	errorMessage = "";
	noErrors = 0;
	event.preventDefault();

	response = validate_input(email,0,errorMessage,"Email");

	if (response[1] != 0) {
		displayError(document.getElementById("email-error"),response[0]);
		noErrors = 1;
	} else {
		document.getElementById("email-error").style.display = "none";
	}

	if (!validateEmail(email.value) && response[1]==0) {
		displayError(document.getElementById("email-error"),"Email Invalid");
		email.style.backgroundColor = "#ffcccb";
		noErrors = 1;
	} else if(response[1]==0) {
		document.getElementById("email-error").style.display = "none";
		email.style.backgroundColor = "white";
	}

	response = validate_input(password,0,errorMessage,"Password");
	if (response[1] != 0) {
		displayError(document.getElementById("password-error"),response[0]);
		noErrors = 1;
	} else {
		document.getElementById("password-error").style.display = "none";
	}

	if (noErrors == 0) {
		document.getElementById("sign_in").submit();
	}
}

function validateSignUpInput(inputName,errorName,errorTag) {

	if (inputName.value == "") {
		displayError(document.getElementById(errorTag),errorName+" cannot be blank");
		inputName.style.backgroundColor = "#ffcccb";
	} else {
		inputName.style.backgroundColor = "white";
		document.getElementById(errorTag).style.display = "none";
	}

}

function displayError(display,errorMessage) {
	display.innerHTML = errorMessage;
	display.style.display = "block";
}

function validateSignUp() {

	sign_up = document.getElementById('sign_up');
	textHolder = document.getElementById("authenticationFailure");
	textHolder.innerHTML = "";
	errorMessage = "";
	noErrors = 0;
	event.preventDefault();
	validated = false;
	form = document.getElementById("sign_up");

	if (form.name != "index.php") {

		response = validate_input(sign_up[0],noErrors,errorMessage,"User Name");
		errorMessage = response[0];
		noErrors = response[1];

		response = validate_input(sign_up[1],noErrors,errorMessage,"Email");
		errorMessage = response[0];
		noErrors = response[1];

		response = validate_input(sign_up[2],noErrors,errorMessage,"Phone");
		errorMessage = response[0];
		noErrors = response[1];

		response = validate_input(sign_up[3],noErrors,errorMessage,"Password");
		errorMessage = response[0];
		noErrors = response[1];

		response = validate_input(sign_up[4],noErrors,errorMessage,"Confirm, Password");
		errorMessage = response[0];
		noErrors = response[1];

		if (sign_up[3].value != sign_up[4].value) {

			sign_up[3].style.backgroundColor = "#ffcccb";
			sign_up[4].style.backgroundColor = "#ffcccb";

			if (noErrors>0) {
				errorMessage += "<br>";
			}

			errorMessage += "Passwords not the same";
			noErrors ++;
		}
	}

	if (noErrors != 0) {
		create_tag("h3",textHolder,"failMessage",errorMessage);
	} else {
		document.getElementById("sign_up").submit();
	}					

}

function sign_out() {

	var formData = new URLSearchParams();
    formData.append('action', 'sign_out');

	fetch('authenticate.php', {
		method: 'POST',
		headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
		body: formData.toString(),
	})
    .then(response => response.text())
    .then(data => {
    	window.location.href = "index.php";
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

/*
25 February 2024 - Created file
2 March 2024 - Added sign out function
19 July 2024 - Added Validation for sign up
5 December 2024 - Increased version
22 February 2025 - Changed the error styling for validation
23 February 2025 - Added function to handle error displays
*/