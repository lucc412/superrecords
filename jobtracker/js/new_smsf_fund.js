function formValidation(){
		
	var flagReturn = true;
	
	if((document.frmnewsmsffund.txtFund.value == null) || (document.frmnewsmsffund.txtFund.value == ""))
	{	
		document.frmnewsmsffund.txtFund.className = "errclass";
		document.frmnewsmsffund.txtFund.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.txtFund.className = "successClass";
	}
	
	if((document.frmnewsmsffund.taStreetAdd.value == null) || (document.frmnewsmsffund.taStreetAdd.value == ""))
	{	
		document.frmnewsmsffund.taStreetAdd.className = "errclass";
		document.frmnewsmsffund.taStreetAdd.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.taStreetAdd.className = "successClass";
	}
	
	if((document.frmnewsmsffund.taPostalAdd.value == null) || (document.frmnewsmsffund.taPostalAdd.value == ""))
	{	
		document.frmnewsmsffund.taPostalAdd.className = "errclass";
		document.frmnewsmsffund.taPostalAdd.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.taPostalAdd.className = "successClass";
	}
	
	if((document.frmnewsmsffund.txtSetupDate.value == null) || (document.frmnewsmsffund.txtSetupDate.value == ""))
	{	
		document.frmnewsmsffund.txtSetupDate.className = "errclass";
		document.frmnewsmsffund.txtSetupDate.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.txtSetupDate.className = "successClass";
	}

	if((document.frmnewsmsffund.lstMembers.value == null) || (document.frmnewsmsffund.lstMembers.value == ""))
	{	
		document.frmnewsmsffund.lstMembers.className = "errclass";
		document.frmnewsmsffund.lstMembers.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.lstMembers.className = "successClass";
	}

	if((document.frmnewsmsffund.lstTrustee.value == null) || (document.frmnewsmsffund.lstTrustee.value == ""))
	{	
		document.frmnewsmsffund.lstTrustee.className = "errclass";
		document.frmnewsmsffund.lstTrustee.focus();
		flagReturn = false;
	}
	else{
		if(document.frmnewsmsffund.lstTrustee.value == '1') {
			noOfMembers = document.frmnewsmsffund.lstMembers.value;
			if(noOfMembers == '1') {
				alert("When Trustee type is 'Individuals' minimum two members are required");
				document.frmnewsmsffund.lstMembers.className = "errclass";
				document.frmnewsmsffund.lstMembers.focus();
				flagReturn = false;
			}
		}

		document.frmnewsmsffund.lstTrustee.className = "successClass";
	}
	
	return flagReturn;	
}
	
