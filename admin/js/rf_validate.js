function validateFormOnSubmit() { 
	flagReturn = true;

	// do field validation
	if (document.managereferrer.lstType.value == "") {
		alert("Select type");
		document.managereferrer.lstType.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.refName.value == "") {
		alert("Enter referrer name");
		document.managereferrer.refName.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.lstSrManager.value == "") {
		alert("Select SR manager");
		document.managereferrer.lstSrManager.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.lstState.value == "") {
		alert("Select state");
		document.managereferrer.lstState.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.mainContactName.value == "") {
		alert("Enter name of main contact");
		document.managereferrer.mainContactName.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.dateSignedUp.value == "") {
		alert("Enter date signed up");
		document.managereferrer.dateSignedUp.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managereferrer.lstSalesPerson.value == "") {
		alert("Select sales person");
		document.managereferrer.lstSalesPerson.focus();
		flagReturn = false;
	}

	if(flagReturn) {
		document.managereferrer.submit();
	}
	
	return flagReturn;
}

function ComfirmCancel(){
   var r = confirm("Are you sure you want to cancel?");
   if(r == true) {
	  window.location.href = "rf_referrer.php";
   }
   else {
	  return false;
   }
}