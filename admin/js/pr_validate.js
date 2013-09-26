function checkAgreedServices() {
	var flagChecked = false;
	$('input[type=checkbox]').each(function () {
	   if(this.checked) {
		 flagChecked = true;
	   }
	});
	return flagChecked;
}

function validateFormOnSubmit() { 
	var flagReturn = true;
	if (document.managepractice.lstType.value == "") {
		alert("Select Type");
		document.managepractice.lstType.focus();
		flagReturn = false;
	}

	else if (document.managepractice.refName.value == "") {
		alert("Enter Practice Name");
		document.managepractice.refName.focus();
		flagReturn = false;
	}
	
	else if (document.managepractice.lstState.value == "") {
		alert("Select State");
		document.managepractice.lstState.focus();
		flagReturn = false;
	}
	
	else if (document.managepractice.mainContactName.value == "") {
		alert("Enter Main Contact Name");
		document.managepractice.mainContactName.focus();
		flagReturn = false;
	}
	
	else if (document.managepractice.email.value == "") {
		alert("Enter Email Address");
		document.managepractice.email.focus();
		flagReturn = false;
	}

	/*else if (document.managepractice.email.value != "") {
		var flagEmail = emailValidate();
		if(!flagEmail) flagReturn = false;
			alert(flagReturn);
	}
	*/
	
	else if (document.managepractice.password.value == "") {
		alert("Enter Password");
		document.managepractice.password.focus();
		flagReturn = false;
	}
	
	else if (document.managepractice.lstSrManager.value == "") {
		alert("Select SR Manager");
		document.managepractice.lstSrManager.focus();
		flagReturn = false;
	}
	
	else if (document.managepractice.lstSalesPerson.value == "") {
		alert("Select Sales Person");
		document.managepractice.lstSalesPerson.focus();
		flagReturn = false;
	}
	else if (document.managepractice.dateSignedUp.value == "") {
		alert("Enter Date Signed Up");
		document.managepractice.dateSignedUp.focus();
		flagReturn = false;
	}
	
	else if(flagReturn) {
		var flagChecked = checkAgreedServices();
		if(!flagChecked) {
			alert("Select Agreed Services");
			flagReturn = false;
		}
	}
	return flagReturn;
}

function emailValidate() {
	var atpos = document.managepractice.email.value.indexOf("@");
	var dotpos = document.managepractice.email.value.lastIndexOf(".");
	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= document.managepractice.email.value.length){
		alert('Invalid Email Address. Please enter again.');
		document.managepractice.email.focus();
		flagEmail = false;
	}
	else {
		flagEmail = true;
	}
	return flagEmail;
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