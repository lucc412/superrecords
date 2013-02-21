function validateFormOnSubmit() { 
	flagReturn = true;

	// do field validation
	if (document.managepractice.lstType.value == "") {
		alert("Select type");
		document.managepractice.lstType.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.refName.value == "") {
		alert("Enter practice name");
		document.managepractice.refName.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.lstSrManager.value == "") {
		alert("Select SR manager");
		document.managepractice.lstSrManager.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.state.value == "") {
		alert("Select state");
		document.managepractice.state.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.mainContactName.value == "") {
		alert("Enter name of main contact");
		document.managepractice.mainContactName.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.dateSignedUp.value == "") {
		alert("Enter date signed up");
		document.managepractice.dateSignedUp.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managepractice.lstSalesPerson.value == "") {
		alert("Select sales person");
		document.managepractice.lstSalesPerson.focus();
		flagReturn = false;
	}

	if(flagReturn) {
		document.managepractice.submit();
	}
	
	return flagReturn;
}

function ComfirmCancel(){
   var r = confirm("Are you sure you want to cancel?");
   if(r == true) {
	  window.location.href = "pr_practice.php";
   }
   else {
	  return false;
   }
}

function noDelete(){
   alert("Sorry, You are not authorised to delete this Practice.");
   return false;
}