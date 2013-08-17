	function formValidation(){
		
		var flagReturn = true;
		
		if((document.frmexstsmsffund.txtFund.value == null) || (document.frmexstsmsffund.txtFund.value == ""))
		{	
			document.frmexstsmsffund.txtFund.className = "errclass";
			document.frmexstsmsffund.txtFund.focus();
			flagReturn = false;
		}else{
			document.frmexstsmsffund.txtFund.className = "successClass";	
		}
		
		if((document.frmexstsmsffund.txtAbn.value == null) || (document.frmexstsmsffund.txtAbn.value == ""))
		{	
			document.frmexstsmsffund.txtAbn.className = "errclass";
			document.frmexstsmsffund.txtAbn.focus();
			flagReturn = false;
		}else{
			if(isNaN(document.frmexstsmsffund.txtAbn.value) == true)
			{
				document.frmexstsmsffund.txtAbn.className = "errclass";
				document.frmexstsmsffund.txtAbn.value = ""
				document.frmexstsmsffund.txtAbn.focus();
				flagReturn = false;
				
			}else{
				document.frmexstsmsffund.txtAbn.className = "successClass";
			}	
		}
		
		
		if((document.frmexstsmsffund.taStreetAdd.value == null) || (document.frmexstsmsffund.taStreetAdd.value == ""))
		{	
			document.frmexstsmsffund.taStreetAdd.className = "errclass";
			document.frmexstsmsffund.taStreetAdd.focus();
			flagReturn = false;
		}else{
			document.frmexstsmsffund.taStreetAdd.className = "successClass";
		}
		
		if((document.frmexstsmsffund.taPostalAdd.value == null) || (document.frmexstsmsffund.taPostalAdd.value == ""))
		{	
			document.frmexstsmsffund.taPostalAdd.className = "errclass";
			document.frmexstsmsffund.taPostalAdd.focus();
			flagReturn = false;
		}else{
			document.frmexstsmsffund.taPostalAdd.className = "successClass";
		}
		
		return flagReturn;
		
	}
	
	