/*
File: PrayerOrder prayer functions
Author: David Sarkies 
Initial: 21 September 2024
Update: 18 March 2025
Version: 1.8
*/

//Validates prayer being sent
function sendPrayer() {
	
	event.preventDefault();
	prayer = document.getElementById("prayer").value.trim();
	
	if (prayer.length>0) {
		document.getElementById("pray").submit();
	}
}

function enlarge() {
	document.getElementById("prayer").style.height="5em";
}

function shrink() {
	document.getElementById("prayer").style.height="2em";
}

function react(responseType) {

	id = responseType.id.substr(4,responseType.id.length);
	rspid = responseType.id.substr(0,4);
	rctn = 0;

	if (responseType.id.substr(0,6) == "praise") {
		id = responseType.id.substr(6,responseType.id.length);
		rspid = responseType.id.substr(0,6);
	}

	if (responseType.classList.contains('selected')) {
		responseType.classList.remove('selected');

		if (rspid == "pray") {
			decreaseReactionCount(document.getElementById("pry"+id));
		} else {
			decreaseReactionCount(document.getElementById("prs"+id));

		}

	} else {
		responseType.classList.add('selected');

		if (rspid == "pray") {
			if(document.getElementById("praise"+id).classList.contains('selected')) {
				document.getElementById("praise"+id).classList.remove('selected');
				decreaseReactionCount(document.getElementById("prs"+id));
			}
			rctn = 1;
			increaseReactCount(document.getElementById("pry"+id));
		} else {
			if (document.getElementById("praise"+id).classList.contains('selected')) {
				document.getElementById("pray"+id).classList.remove('selected');
				decreaseReactionCount(document.getElementById("pry"+id));
			}
			rctn = 2;
			increaseReactCount(document.getElementById("prs"+id));
		}
	}

	url = "users.php";

	fetch(url,{   
		method: "POST",
   	headers: {
        "Content-Type": "application/json" // Sending JSON
    	},
    	body: JSON.stringify({
        react: rctn,
        id: id
    	})
	});
}

function increaseReactCount(count) {
	count.innerHTML = Number(count.innerHTML)+1;
}

function decreaseReactionCount(count) {
	if (count.innerHTML == "1") {
		count.innerHTML = "";
	} else {
		count.innerHTML = Number(count.innerHTML)-1;
	}	
}

/*
21 September 2024 - Created File
26 September 2024 - Data retrieved from backend thanks to ChatGPT
28 September 2024 - Added script to display results from search. Added script to clear search results
8 October 2024 - Added id to user tag
13 October 2024 - Added a unique id for users. Added styling for the icons for the search results
				- Stylised image buttons, and moved function to standard
19 October 2024 - Started building other icons. Added unfollow function
22 October 2024 - Made the user lines dynamic so they change when you click the buttons
27 October 2024 - Added the icon that defines the relationship
7 November 2024 - Started working on bugs with regards to displaying relationship icons.
				- Now got the first image to change.
10 November 2024 - The non-blocked relationships work correctly.
12 November 2024 - Added blocked icons
16 November 2024 - Added unblock functionality
23 November 2024 - Added error to display if invalid prayer sent (blank)
26 November 2024 - Moved icons to specific directory. Added function to increase and decrease side of text input
5 December 2024 - Increased Version
13 December 2024 - Added code to activate pray & praise buttons in front end.
24 December 2024 - Fixed issue where variable was overwriting react function
26 December 2024 - Added count function for reactions, and it counts properly.
30 December 2024 - Added code to increase and decrease reaction count if user reacts,
23 January 2025 - Initial to display group button in button type.
26 January 2025 - Added functions to change content of boxes.
30 January 2025 - Moved non-prayer related functions to separate js files.
18 March 2025 - Disabled prayer button when prayer box blank.
*/