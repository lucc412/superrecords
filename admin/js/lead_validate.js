//************************************************************************************************
//  Task          : Validation to check for mandatory fields.
//  Modified By   : Dhiraj Sahu
//  Created On    : 05-Feb-2013
//  Last Modified : 05-Feb-2013
//************************************************************************************************
function validateFormOnSubmit()
{ 
	flagReturn = true;
	
	// do field validation
	if (document.frmlead.lead_type.value == "") {
		alert("Select Lead type");
		document.frmlead.lead_type.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.frmlead.lead_name.value == "") {
		alert("Enter name");
		document.frmlead.lead_name.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.frmlead.state.value == "") {
		alert("Select state");
		document.frmlead.state.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.frmlead.main_contact_name.value == "") {
		alert("Enter name of main contact");
		document.frmlead.main_contact_name.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.frmlead.date_received.value == "") {
		alert("Enter Received Date");
		document.frmlead.date_received.focus();
		flagReturn = false;
	}
	
	// Code for Reason box
	else if(document.frmlead.lead_status.value == 3 && document.frmlead.lead_reason.value == ""){
		alert("Enter Reason");
		document.frmlead.lead_reason.focus();
		flagReturn = false;
	}	

	// do field validation  
	else if (document.frmlead.sales_person.value == "") {
		alert("Select sales person");
		document.frmlead.sales_person.focus();
		flagReturn = false;
	}
	
	if(flagReturn) {
		document.frmlead.submit();
	}
	
	return flagReturn;
}

function ComfirmCancel(){
   var r = confirm("Are you sure you want to cancel?");
   if(r == true) {
	  window.location.href = "lead.php";
   }
   else {
	  return false;
   }
}

function noDelete(){
   alert("Sorry, You are not authorised to delete this Lead.");
   return false;
}