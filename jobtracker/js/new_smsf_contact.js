	function formValidation()
	{
		var flagReturn = true;
		
		if((document.getElementById('txtFname').value == null) || (document.getElementById('txtFname').value == ""))
		{	
			document.getElementById('txtFname').className = "errclass";
			document.getElementById('txtFname').focus();
			flagReturn = false;
		}else{
			document.getElementById('txtFname').className = "successClass";
		}
		
		if((document.frmnewsmsfcont.txtLname.value == null) || (document.frmnewsmsfcont.txtLname.value == ""))
		{	
			document.frmnewsmsfcont.txtLname.className = "errclass";
			document.frmnewsmsfcont.txtLname.focus();
			flagReturn = false;
		}else{
			document.frmnewsmsfcont.txtLname.className = "successClass";
		}
		
		if((document.frmnewsmsfcont.txtEmail.value == null) || (document.frmnewsmsfcont.txtEmail.value == ""))
		{	
			document.frmnewsmsfcont.txtEmail.className = "errclass";
			document.frmnewsmsfcont.txtEmail.focus();
			flagReturn = false;
			
		}else{
			email_validate(document.frmnewsmsfcont.txtEmail);
		}
		
		if((document.frmnewsmsfcont.txtPhone.value == null) || (document.frmnewsmsfcont.txtPhone.value == ""))
		{	
			document.frmnewsmsfcont.txtPhone.className = "errclass";
			document.frmnewsmsfcont.txtPhone.focus();
			flagReturn = false;
			
		}else{
			
			if(isNaN(document.frmnewsmsfcont.txtPhone.value) == true)
			{
				document.frmnewsmsfcont.txtPhone.className = "errclass";
				document.frmnewsmsfcont.txtPhone.value = ""
				document.frmnewsmsfcont.txtPhone.focus();
				flagReturn = false;
			}else{
				document.frmnewsmsfcont.txtPhone.className = "successClass";
				
			}
			
		}
		
//		if((document.frmnewsmsfcont.txtCode.value == null) || (document.frmnewsmsfcont.txtCode.value == ""))
//		{
//			document.frmnewsmsfcont.flaginit.value = 'N';
//		}else{
//			document.frmnewsmsfcont.flaginit.value = 'Y';
//		}
//		
		return flagReturn;
                
	}

	
	function email_validate(element)
	{
		var x = element.value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			element.focus();
			element.className = "errclass";
			element.value="";
			return false;
		}else{
			element.className = "successClass";
		}
	}
	