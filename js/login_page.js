/*
File: PrayerOrder login functions
Author: David Sarkies 
Initial: 25 February 2024
Update: 19 April 2025
Version: 1.5
*/

if (document.getElementById("sign_in") != null) {
	document.getElementById("sign_in").addEventListener("submit", e => {
	    if (!validateLogin()) {
	        e.preventDefault();
	    }
	});
}

if (document.getElementById("sign_up")) {
	document.getElementById("sign_up").addEventListener("submit", e => {
	    if (!validateSignUp()) {
	        e.preventDefault();
	    }
	});
}

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

	var valid = true;

	if (inputName.value == "") {
		displayError(document.getElementById(errorTag),errorName+" cannot be blank");
		inputName.style.backgroundColor = "#ffcccb";
		valid = false;
	} else {
		inputName.style.backgroundColor = "white";
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function validateEmailInput(inputName,errorName,errorTag) {

	var valid = true;

	if (inputName.value == "") {
		displayError(document.getElementById(errorTag),errorName+" cannot be blank");
		inputName.style.backgroundColor = "#ffcccb";
		valid = false;
	} else if (!validateEmail(email.value)) {
		displayError(document.getElementById("email-error"),"Email Invalid");
		email.style.backgroundColor = "#ffcccb";
		valid = false;
	} else {
		inputName.style.backgroundColor = "white";
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function validateConfirmInput(inputName,errorName,errorTag) {
;
	var password = document.getElementById("password");
	var passwordError = document.getElementById("password-error");
	var valid = true;
	
	if (inputName.value == "") {
		displayError(document.getElementById(errorTag),errorName+" cannot be blank");
		inputName.style.backgroundColor = "#ffcccb";
		validateSignUpInput(password,'Password','password-error');
		valid = false;
	} else if (inputName.value != password.value) {
		displayError(document.getElementById("confirm-error"),"Passwords don't match");
		displayError(passwordError,"Passwords don't match");
		inputName.style.backgroundColor = "#ffcccb";
		password.style.backgroundColor = "#ffcccb";
		valid=false;
	} else {
		inputName.style.backgroundColor = "white";
		password.style.backgroundColor = "white";
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function displayError(display,errorMessage) {
	display.innerHTML = errorMessage;
	display.style.display = "block";
}

function validateSignUp() {

	event.preventDefault();
	validated = true;
	form = document.getElementById("sign_up");

	if (form.name != "index.php") {

		if (!validateSignUpInput(document.getElementById('username'),'User Name','username-error')) {
			validated = false;
		}

		if (!validateEmailInput(document.getElementById('email'),'Email','email-error')) {
			validated = false;
		}


		if (!validateSignUpInput(document.getElementById('phone'),'Phone','phone-error')) {
			validated = false;
		}

		if (!validateSignUpInput(document.getElementById('password'),'Password','password-error')) {
			validated = false;
		}

		if (!validateConfirmInput(document.getElementById('confirm_password'),'Confirm Password','confirm-error')) {
			validated = false;
		}
	}

	if (validated) {
		document.getElementById("sign_up").submit();
	}					

}

function sign_out() {

	var formData = new URLSearchParams();
    formData.append('action', 'sign_out');

	fetch('includes/user/authenticate.php', {
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
27 February 2025 - Added validation onBlurs for signup specifically for email and confirm password
				 - Added submission validation
29 March 2025 - Changed file name to better reflect purpose
19 April 2025 - Moved authenticate to new folder
*/