function validateFormOnSubmit() { 
	
	if (document.managepractice.lstType.value == "")
	 {
		alert("Select Type");
		document.managepractice.lstType.focus();
		return false;
	}
	
	else if (document.managepractice.refName.value == "") {
		alert("Enter Practice Name");
		document.managepractice.refName.focus();
		return  false;
	}
	
	else if (document.managepractice.lstSrManager.value == "") {
		alert("Select SR Manager");
		document.managepractice.lstSrManager.focus();
		return false;
	}
	
	else if (document.managepractice.lstSalesPerson.value == "") {
		alert("Select Sales Person");
		document.managepractice.lstSalesPerson.focus();
		return false;
	}
	
	else if (document.managepractice.lstState.value == "") {
		alert("Select State");
		document.managepractice.lstState.focus();
		return false;
	}
	
	else if (document.managepractice.mainContactName.value == "") {
		alert("Enter Main Contact Name");
		document.managepractice.mainContactName.focus();
		return false;
	}
	
	else if (document.managepractice.email.value == "") {
		alert("Enter Email Address");
		document.managepractice.email.focus();
		return false;
	}

	else if (document.managepractice.email.value != "") {
		var atpos = document.managepractice.email.value.indexOf("@");
		var dotpos = document.managepractice.email.value.lastIndexOf(".");

		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= document.managepractice.email.value.length){
			alert('Invalid Email Address. Please enter again.');
			document.managepractice.email.focus();
			return false;
		}
	}

	else if (document.managepractice.password.value == "") {
		alert("Enter Password");
		document.managepractice.password.focus();
		return false;
	}
	
	else if (document.managepractice.dateSignedUp.value == "") {
		alert("Enter Date Signed Up");
		document.managepractice.dateSignedUp.focus();
		return  false;
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