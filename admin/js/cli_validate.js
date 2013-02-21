function validateFormOnSubmit() { 
	flagReturn = true;

	// do field validation  
	if (document.manageclient.lstPractice.value == "") {
		alert("Select practice");
		document.manageclient.lstPractice.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.lstSrManager.value == "") {
		alert("Select SR manager");
		document.manageclient.lstSrManager.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.cliName.value == "") {
		alert("Enter client name");
		document.manageclient.cliName.focus();
		flagReturn = false;
	}

	// do field validation
	else if (document.manageclient.lstType.value == "") {
		alert("Select entity type");
		document.manageclient.lstType.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.lstSrManager.value == "") {
		alert("Select SR manager");
		document.manageclient.lstSrManager.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.dateSignedUp.value == "") {
		alert("Enter date client received");
		document.manageclient.dateSignedUp.focus();
		flagReturn = false;
	}

	if(flagReturn) {
		document.manageclient.submit();
	}
	
	return flagReturn;
}

function ComfirmCancel(){
   var r = confirm("Are you sure you want to cancel?");
   if(r == true) {
	  window.location.href = "cli_client.php";
   }
   else {
	  return false;
   }
}