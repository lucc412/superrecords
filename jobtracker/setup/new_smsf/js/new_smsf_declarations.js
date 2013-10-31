function checkYesNoAns()
{
	var count = 0;
	
	if(document.getElementById('hdnTrusteeType').value != '3')
		loop = 5;
	else
		loop = 8;
	
	for(i=1; i<=loop; i++)
	{
		if(document.getElementById('rd'+i).checked == true)
			count++;
	}	
	
	if(count > 0)
	{
		alert('You will need to discuss your application with a consultant. Please call super records on 1800 278 737 or submit your details via the enquiry form to have someone contact you.');
		
		return false;
	}
//	else if(document.getElementById('chkAgree').checked == false)
//	{
//		alert('Please click to agree our terms & conditions.');
//		document.getElementById('chkAgree').focus();
//		return false;
//	}
	
	
//	if(count == 0 && document.getElementById('chkAgree').checked == true)
//		return true;
//	else
//		return false;
}
