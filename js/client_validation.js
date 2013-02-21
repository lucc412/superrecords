// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var clientName = document.getElementById('txtName');
	var entityType = document.getElementById('lstType');

	if(clientName.value == "") {
		clientName.className = "errclass";
		flagReturn = false;
	}
	else {
		clientName.className = "";
	}
	
	if(entityType.value == 0) {
		entityType.className = "errclass";
		flagReturn = false;
	}
	else {
		entityType.className = "";
	}
	
	return flagReturn;
}

// This function is used to submit for condition fields by ajax
function checkUnique(inputValue, entityId) {
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
	  	var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var response = xmlhttp.responseText;
			if(response == 'success') {
				//document.getElementById("rightText").style.display = '';
				document.getElementById("wrongText").style.display = 'none';
				document.getElementById("submit").disabled = false;
				document.getElementById("submit").className = 'addbtnclass';
			}
			else {
				//document.getElementById("rightText").style.display = 'none';
				document.getElementById("wrongText").style.display = '';
				document.getElementById("submit").disabled = true;
				document.getElementById("submit").className = 'disbtnclass';
			}
	    }
	}

	var that = this;
	var searchVal = $(this).val();

	if (searchVal == $(that).val()) {
		xmlhttp.open("GET","../ajax/clients.php?inputValue="+inputValue+"&entityId="+entityId+"&doAction=checkUnique",true);
		xmlhttp.send();
	}
}