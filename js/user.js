/*
File: PrayerOrder user JS Scripts Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 5 December 2024
Version: 1.0
*/

function validateLogin() {

	textHolder = document.getElementById("authenticationFailure");
	textHolder.innerHTML = "";
	email = document.getElementById("email");
	password = document.getElementById("password");
	errorMessage = "";
	noErrors = 0;
	event.preventDefault();

	response = validate_input(email,noErrors,errorMessage,"Email");
	errorMessage = response[0];
	noErrors = response[1];

	response = validate_input(password,noErrors,errorMessage,"Password");
	errorMessage = response[0];
	noErrors = response[1];

	if (noErrors != 0) {
		create_tag("h3",textHolder,"failMessage",errorMessage);
	} else {
		document.getElementById("sign_in").submit();
	}
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
*/