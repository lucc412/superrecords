	function formValidation(count)
	{
		var flagReturn = true;
		
		for(var i = 1; i <= count; i++){
			
			if((document.getElementById('txtFname'+i).value == null) || (document.getElementById('txtFname'+i).value == ""))
			{	
				document.getElementById('txtFname'+i).className = "errclass";
				document.getElementById('txtFname'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtFname'+i).className = "successClass";
			}
			
			if((document.getElementById('txtLname'+i).value == null) || (document.getElementById('txtLname'+i).value == ""))
			{	
				document.getElementById('txtLname'+i).className = "errclass";
				document.getElementById('txtLname'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtLname'+i).className = "successClass";
			}
			
			if((document.getElementById('txtDob'+i).value == null) || (document.getElementById('txtDob'+i).value == ""))
			{	
				document.getElementById('txtDob'+i).className = "errclass";
				document.getElementById('txtDob'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtDob'+i).className = "successClass";
			}	
			
			if((document.getElementById('txtCity'+i).value == null) || (document.getElementById('txtCity'+i).value == ""))
			{	
				document.getElementById('txtCity'+i).className = "errclass";
				document.getElementById('txtCity'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtCity'+i).className = "successClass";
			}
			
			if((document.getElementById('txtAddress'+i).value == null) || (document.getElementById('txtAddress'+i).value == ""))
			{	
				document.getElementById('txtAddress'+i).className = "errclass";
				document.getElementById('txtAddress'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtAddress'+i).className = "successClass";
			}
			
			if((document.getElementById('txtTfn'+i).value == null) || (document.getElementById('txtTfn'+i).value == ""))
			{	
				document.getElementById('txtTfn'+i).className = "errclass";
				document.getElementById('txtTfn'+i).focus();
				flagReturn = false;
				
			}else{
				
				if(isNaN(document.getElementById('txtTfn'+i).value) == true)
				{
					document.getElementById('txtTfn'+i).className = "errclass";
					document.getElementById('txtTfn'+i).value = ""
					document.getElementById('txtTfn'+i).focus();
					flagReturn = false;
				}else{
					document.getElementById('txtTfn'+i).className = "successClass";
				}
				
			}
			
			if((document.getElementById('txtOccupation'+i).value == null) || (document.getElementById('txtOccupation'+i).value == ""))
			{	
				document.getElementById('txtOccupation'+i).className = "errclass";
				document.getElementById('txtOccupation'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('txtOccupation'+i).className = "successClass";
			}
			document.getElementById('txtPhone'+i)
			if((document.getElementById('txtPhone'+i).value == null) || (document.getElementById('txtPhone'+i).value == ""))
			{	
				document.getElementById('txtPhone'+i).className = "errclass";
				document.getElementById('txtPhone'+i).focus();
				flagReturn = false;
				
			}else{
				
				if(isNaN(document.getElementById('txtPhone'+i).value) == true)
				{
					document.getElementById('txtPhone'+i).className = "errclass";
					document.getElementById('txtPhone'+i).value = ""
					document.getElementById('txtPhone'+i).focus();
					flagReturn = false;
				}else{
					document.getElementById('txtPhone'+i).className = "successClass";
				}
				
			}
		
		}
		return flagReturn;
		
	}
	

	
	