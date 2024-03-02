/*
File: PrayerOrder user JS Scripts Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 2 March 2024
Version: 0.1
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
*/