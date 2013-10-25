// This function is used to perform validations for upload
function uploadValidate() {

	var flagReturn = true;
	var eleFileUpload = document.getElementById('fileUpload');
	var eleFileTitle = document.getElementById('fileTitle');

	if(eleFileTitle.value == "") {
		eleFileTitle.className = "errclass";
		flagReturn = false;
	}
	else if(eleFileUpload.value == 0) {
		eleFileUpload.className = "errclass";
		flagReturn = false;
	}

	return flagReturn;
}