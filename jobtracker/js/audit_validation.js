// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var lstClientType = document.getElementById('lstClientType');
        var lstClientTypeSearch = document.getElementById('lstClientTypeSearch');
	var txtPeriod = document.getElementById('txtPeriod');
	var hiddenType = document.getElementById('type');

	if(lstClientType.value == 0) {
		lstClientTypeSearch.className = "errclass";
		flagReturn = false;
	}
	else {
		lstClientTypeSearch.className = "drop_down_select";
	}

	if(txtPeriod.value == "") {
		txtPeriod.className = "errclass";
		flagReturn = false;
	}
	else {
		txtPeriod.className = "";
	}
	return flagReturn;
}