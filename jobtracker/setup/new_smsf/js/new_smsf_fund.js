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
	
        if((document.frmnewsmsffund.StrAddBuild.value == null) || (document.frmnewsmsffund.StrAddBuild.value == ""))
	{	
		document.frmnewsmsffund.StrAddBuild.className = "errclass";
		document.frmnewsmsffund.StrAddBuild.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddBuild.className = "successClass";
	}
        
        if((document.frmnewsmsffund.StrAddStreet.value == null) || (document.frmnewsmsffund.StrAddStreet.value == ""))
	{	
		document.frmnewsmsffund.StrAddStreet.className = "errclass";
		document.frmnewsmsffund.StrAddStreet.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddStreet.className = "successClass";
	}
        
        if((document.frmnewsmsffund.StrAddSubrb.value == null) || (document.frmnewsmsffund.StrAddSubrb.value == ""))
	{	
		document.frmnewsmsffund.StrAddSubrb.className = "errclass";
		document.frmnewsmsffund.StrAddSubrb.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddSubrb.className = "successClass";
	}
        
        if((document.frmnewsmsffund.StrAddState.value == 0))
	{	
		document.frmnewsmsffund.StrAddState.className = "errclass";
		document.frmnewsmsffund.StrAddState.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddState.className = "successClass";
	}
        
        if((document.frmnewsmsffund.StrAddPstCode.value == null) || (document.frmnewsmsffund.StrAddPstCode.value == ""))
	{	
		document.frmnewsmsffund.StrAddPstCode.className = "errclass";
		document.frmnewsmsffund.StrAddPstCode.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddPstCode.className = "successClass";
	}
        
        if((document.frmnewsmsffund.StrAddCntry.value == 0))
	{	
		document.frmnewsmsffund.StrAddCntry.className = "errclass";
		document.frmnewsmsffund.StrAddCntry.focus();
		flagReturn = false;
	}else{
		document.frmnewsmsffund.StrAddCntry.className = "successClass";
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
	
