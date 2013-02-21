// This function is used to update a query response
function updateQuery(queryId) {

	var eleQueryId = document.getElementById('queryId');
	eleQueryId.value = queryId;
	document.objForm.submit();
}

// This function is used to update a query response
function submitForm() {

	var doAction = document.getElementById('action');
	doAction.value = 'submitForm';
	document.objForm.submit();
}


// This function is used to perform validations
function unlinkFile() {

	response = confirm('Are you sure you want to delete this document ?');

	if(response) {
		return true;
	}
	else {
		return false;
	}
}