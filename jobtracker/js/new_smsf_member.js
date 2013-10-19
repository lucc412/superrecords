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
			
			if((document.getElementById('StrAddUnit'+i).value == null) || (document.getElementById('StrAddUnit'+i).value == ""))
			{	
				document.getElementById('StrAddUnit'+i).className = "errclass";
				document.getElementById('StrAddUnit'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddUnit'+i).className = "successClass";
			}
			
                        if((document.getElementById('StrAddBuild'+i).value == null) || (document.getElementById('StrAddBuild'+i).value == ""))
			{	
				document.getElementById('StrAddBuild'+i).className = "errclass";
				document.getElementById('StrAddBuild'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddBuild'+i).className = "successClass";
			}
                        
                        if((document.getElementById('StrAddStreet'+i).value == null) || (document.getElementById('StrAddStreet'+i).value == ""))
			{	
				document.getElementById('StrAddStreet'+i).className = "errclass";
				document.getElementById('StrAddStreet'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddStreet'+i).className = "successClass";
			}
                        
                        if((document.getElementById('StrAddSubrb'+i).value == null) || (document.getElementById('StrAddSubrb'+i).value == ""))
			{	
				document.getElementById('StrAddSubrb'+i).className = "errclass";
				document.getElementById('StrAddSubrb'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddSubrb'+i).className = "successClass";
			}
                        
                        if((document.getElementById('StrAddState'+i).value == 0))
			{	
				document.getElementById('StrAddState'+i).className = "errclass";
				document.getElementById('StrAddState'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddState'+i).className = "successClass";
			}
                        
                        if((document.getElementById('StrAddPstCode'+i).value == null) || (document.getElementById('StrAddPstCode'+i).value == ""))
			{	
				document.getElementById('StrAddPstCode'+i).className = "errclass";
				document.getElementById('StrAddPstCode'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddPstCode'+i).className = "successClass";
			}
                        
                        if((document.getElementById('StrAddCntry'+i).value == 0))
			{	
				document.getElementById('StrAddCntry'+i).className = "errclass";
				document.getElementById('StrAddCntry'+i).focus();
				flagReturn = false;
			}else{
				document.getElementById('StrAddCntry'+i).className = "successClass";
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
	

	
	