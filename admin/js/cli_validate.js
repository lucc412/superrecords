function validateFormOnSubmit() { 
	flagReturn = true;

	

	// do field validation  
	if (document.manageclient.dateSignedUp.value == "") {
		alert("Enter Date Client Received");
		document.manageclient.dateSignedUp.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.lstPractice.value == "") {
		alert("Select Practice");
		document.manageclient.lstPractice.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.manageclient.cliName.value == "") {
		alert("Enter Client Name");
		document.manageclient.cliName.focus();
		flagReturn = false;
	}

	// do field validation
	else if (document.manageclient.lstType.value == "") {
		alert("Select Entity Type");
		document.manageclient.lstType.focus();
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