// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var username = document.getElementById('txtName');
	var password = document.getElementById('txtPassword');

	if(username.value == "") {
		username.className = "errclass";
		flagReturn = false;
	}
	else {
		username.className = "";
	}
	
	
	if(password.value == "") {
		password.className = "errclass";
		flagReturn = false;
	}
	else {
		password.className = "";
	}
	
	return flagReturn;
}