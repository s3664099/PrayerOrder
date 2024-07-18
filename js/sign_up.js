/*
File: PrayerOrder user JS Scripts Page
Author: David Sarkies 
Initial: 25 February 2024
Update: 18 July 2024
Version: 0.0
*/

function validate_form() {

	sign_up = document.getElementById('sign_up');

	errors = "";
	validated = false;

	if (sign_up[0].value.length == 0) {
		errors = errors + "User Name is blank\n";
	}

	if (sign_up[1].value.length == 0) {
		errors = errors + "Phone is blank\n";
	}

	if (sign_up[2].value.length == 0) {
		errors = errors + "Email is blank\n";
	}

	if (sign_up[3].value.length == 0) {
		errors = errors + "Password is blank\n";
	}

	if (sign_up[3].value != sign_up[4].value) {
		errors = errors + "Passwords don't match";
	}
	
	if (errors.length == 0) {
		validated = true;
	}


	return validated;
}

/*
4 July 2024
18 Jyly 2024
*/