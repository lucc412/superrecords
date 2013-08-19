	
	function formValidation(){
		
		var flagReturn = true;
	
		if((document.frmexstsmsfcont.txtFname.value == null) || (document.frmexstsmsfcont.txtFname.value == ""))
		{	
			document.frmexstsmsfcont.txtFname.className = "errclass";
			document.frmexstsmsfcont.txtFname.focus();
			flagReturn = false;
		}else{
			document.frmexstsmsfcont.txtFname.className = "successClass";
		}
		
		if((document.frmexstsmsfcont.txtLname.value == null) || (document.frmexstsmsfcont.txtLname.value == ""))
		{	
			document.frmexstsmsfcont.txtLname.className = "errclass";
			document.frmexstsmsfcont.txtLname.focus();
			flagReturn = false;
		}else{
			document.frmexstsmsfcont.txtLname.className = "successClass";
		}
		
		if((document.frmexstsmsfcont.txtEmail.value == null) || (document.frmexstsmsfcont.txtEmail.value == ""))
		{	
			document.frmexstsmsfcont.txtEmail.className = "errclass";
			document.frmexstsmsfcont.txtEmail.focus();
			flagReturn = false;
			
		}else{
			flagReturn = email_validate(document.frmexstsmsfcont.txtEmail);
		}
		
		if((document.frmexstsmsfcont.txtPhone.value == null) || (document.frmexstsmsfcont.txtPhone.value == ""))
		{	
			document.frmexstsmsfcont.txtPhone.className = "errclass";
			document.frmexstsmsfcont.txtPhone.focus();
			flagReturn = false;
			
		}else{
			
			if(isNaN(document.frmexstsmsfcont.txtPhone.value) == true)
			{
				document.frmexstsmsfcont.txtPhone.className = "errclass";
				document.frmexstsmsfcont.txtPhone.value = ""
				document.frmexstsmsfcont.txtPhone.focus();
				flagReturn = false;
			}else{
				document.frmexstsmsfcont.txtPhone.className = "successClass";
			}
		}
		
		if((document.frmexstsmsfcont.txtCode.value == null) || (document.frmexstsmsfcont.txtCode.value == ""))
		{
			document.frmexstsmsfcont.flaginit.value = 'N';
		}else{
			document.frmexstsmsfcont.flaginit.value = 'Y';
		}
		
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
	
	