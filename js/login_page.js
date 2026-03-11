/*
File: PrayerOrder login functions
Author: David Sarkies 
Initial: 25 February 2024
Update: 11 March 2026
Version: 1.7
*/

if (document.getElementById("sign_in") != null) {
	document.getElementById("sign_in").addEventListener("submit", e => {
	    if (!validateLogin(e)) {
	        e.preventDefault();
	    }
	});
}

if (document.getElementById("sign_up")) {
	document.getElementById("sign_up").addEventListener("submit", e => {
	    if (!validateSignUp(e)) {
	        e.preventDefault();
	    }
	});
}

const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");

function validateLogin(event) {

	const textHolder = document.getElementById("authenticationFailure");
	textHolder.textContent = "";
	const email = document.getElementById("email");
	const password = document.getElementById("password");
	let errorMessage = "";
	let noErrors = 0;
	let valid = true;
	let response = validate_input(email,0,errorMessage,"Email");

	if (response[1] != 0) {
		displayError(emailError,response[0]);
		email.classList.add("error_colour");
		noErrors = 1;
	} else {
		emailError.style.display = "none";
	}

	if (!validateEmail(email.value) && response[1]==0) {
		displayError(emailError,"Email Invalid");
		email.classList.remove("no_error_colour");
		email.classList.add("error_colour");
		noErrors = 1;
	} else if(response[1]==0) {
		emailError.style.display = "none";
		email.classList.remove("error_colour");
		email.classList.add("no_error_colour");
	}

	response = validate_input(password,0,errorMessage,"Password");
	if (response[1] != 0) {
		displayError(passwordError,response[0]);
		noErrors = 1;
	} else {
		passwordError.style.display = "none";
	}

	if (noErrors == 0) {
		document.getElementById("sign_in").submit();
	} else {
		valid = false;
	}
	return valid;
}

function validateSignUpInput(inputName,errorName,errorTag) {

	let valid = true;

	let response = validate_input(inputName,0,"",errorName);

	if (response[1] != 0) {
		displayError(document.getElementById(errorTag),response[0]);
		inputName.classList.add("error_colour");
		inputName.classList.remove("no_error_colour");
		valid = false;
	} else {
		inputName.classList.remove("error_colour");
		inputName.classList.add("no_error_colour");
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function validateEmailInput(inputName,errorName,errorTag) {

	let valid = true;

	let response = validate_input(inputName,0,"",errorName);

	if (response[1] != 0) {
		displayError(document.getElementById(errorTag),response[0]);
		inputName.classList.remove("no_error_colour");
		inputName.classList.add("error_colour");
		valid = false;
	} else if (!validateEmail(inputName.value)) {
		displayError(emailError,"Email Invalid");
		inputName.classList.remove("no_error_colour");
		inputName.classList.add("error_colour");
		valid = false;
	} else {
		inputName.classList.remove("error_colour");
		inputName.classList.add("no_error_colour");
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function validateConfirmInput(inputName,errorName,errorTag) {
	const password = document.getElementById("password");
	let valid = true;

	let response = validate_input(inputName,0,"",errorName);
	
	if (response[1] != 0) {
		displayError(document.getElementById(errorTag),response[0]);
		inputName.classList.add("error_colour");
		validateSignUpInput(password,'Password','password-error');
		valid = false;
	} else if (inputName.value != password.value) {
		displayError(document.getElementById("confirm-error"),"Passwords don't match");
		displayError(passwordError,"Passwords don't match");
		inputName.classList.remove("no_error_colour");
		password.classList.remove("no_error_colour");
		inputName.classList.add("error_colour");
		password.classList.add("error_colour");
		valid=false;
	} else {
		inputName.classList.remove("error_colour");
		password.classList.remove("error_colour");
		inputName.classList.add("no_error_colour");
		password.classList.add("no_error_colour");
		document.getElementById(errorTag).style.display = "none";
	}

	return valid;
}

function displayError(display,errorMessage) {
	display.textContent = errorMessage;
	display.style.display = "block";
}

function validateSignUp(event) {

	event.preventDefault();
	let validated = true;
	const form = document.getElementById("sign_up");

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

	let formData = new URLSearchParams();
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
9 March 2026 - Started fixing issues.
11 March 2026 - Fixed minor issues
*/