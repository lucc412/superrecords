function validateFormOnSubmit() { 
	
	if (document.managepractice.lstType.value == "")
	 {
		alert("Select type");
		document.managepractice.lstType.focus();
		return false;
	}
	
	else if (document.managepractice.refName.value == "") {
		alert("Enter practice name");
		document.managepractice.refName.focus();
		return  false;
	}
	
	else if (document.managepractice.lstSrManager.value == "") {
		alert("Select SR manager");
		document.managepractice.lstSrManager.focus();
		return false;
	}
	
	
	else if (document.managepractice.lstState.value == "") {
		alert("Select State");
		document.managepractice.lstState.focus();
		return false;
	}
	
	else if (document.managepractice.mainContactName.value == "") {
		alert("Enter name of main contact");
		document.managepractice.mainContactName.focus();
		return false;
	}
	
	
	
	else if (document.managepractice.email.value == "") {
		alert("Enter User Name");
		document.managepractice.email.focus();
		return false;
	}
	
	else if (document.managepractice.password.value == "") {
		alert("Enter Password");
		document.managepractice.password.focus();
		return false;
	}
	
	else if (document.managepractice.dateSignedUp.value == "") {
		alert("Enter date signed up");
		document.managepractice.dateSignedUp.focus();
		return  false;
	}
	
	else if (document.managepractice.lstSalesPerson.value == "") {
		alert("Select sales person");
		document.managepractice.lstSalesPerson.focus();
		return false;
	}
	
	else
	{
		return true;
	}
	
	

	
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