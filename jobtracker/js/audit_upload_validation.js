// This function is used to perform validations for upload
var filestoupload =0;
function uploadValidate() {

	var flagReturn = true;
	var eleFileUpload = document.getElementById('fileUpload');
	var eleFileTitle = document.getElementById('fileTitle');

	if(eleFileTitle.value == "") {
		eleFileTitle.className = "errclass";
		flagReturn = false;
	}
	else if(filestoupload == 0) {
		eleFileUpload.className = "errclass";
		eleFileTitle.className = "";
		flagReturn = false;
	} else{
		eleFileTitle.className = "";
		eleFileUpload.className = "";
		$(".fileUpload").click(); //Upload File & Submit Form Using Ajax
	}
	return flagReturn;
}