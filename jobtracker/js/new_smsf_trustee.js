	
	function formValidation()
	{
		
		var flagReturn = true;
			
		if((document.frmnewsmsftrustee.txtCname.value == null) || (document.frmnewsmsftrustee.txtCname.value == ""))
		{	
			document.frmnewsmsftrustee.txtCname.className = "errclass";
			document.frmnewsmsftrustee.txtCname.focus();
			flagReturn = false;
		}else{
			document.frmnewsmsftrustee.txtCname.className = "successClass";	
		}
		
		if(document.getElementById('trustyType').value == 3)
		{
			// acn
			if((document.frmnewsmsftrustee.txtAcn.value == null) || (document.frmnewsmsftrustee.txtAcn.value == ""))
			{	
				document.frmnewsmsftrustee.txtAcn.className = "errclass";
				document.frmnewsmsftrustee.txtAcn.focus();
				flagReturn = false;
			}
			else{
				
				if(isNaN(document.frmnewsmsftrustee.txtAcn.value) == true)
				{
					document.frmnewsmsftrustee.txtAcn.className = "errclass";
					document.frmnewsmsftrustee.txtAcn.focus();
					flagReturn = false;
					
				}else{
					document.frmnewsmsftrustee.txtAcn.className = "successClass";
				}	
			}

			// abn
			if(isNaN(document.frmnewsmsftrustee.txtAbn.value) == true)
			{
				document.frmnewsmsftrustee.txtAbn.className = "errclass";
				document.frmnewsmsftrustee.txtAbn.focus();
				flagReturn = false;
				
			}else{
				document.frmnewsmsftrustee.txtAbn.className = "successClass";
			}
			
			// tfn
			if(isNaN(document.frmnewsmsftrustee.txtTfn.value) == true)
			{
				document.frmnewsmsftrustee.txtTfn.className = "errclass";
				document.frmnewsmsftrustee.txtTfn.focus();
				flagReturn = false;
				
			}else{
				document.frmnewsmsftrustee.txtTfn.className = "successClass";
			}
		}
		
		if((document.frmnewsmsftrustee.txtRegAddress.value == null) || (document.frmnewsmsftrustee.txtRegAddress.value == ""))
		{	
			document.frmnewsmsftrustee.txtRegAddress.className = "errclass";
			document.frmnewsmsftrustee.txtRegAddress.focus();
			flagReturn = false;
		}else{
			document.frmnewsmsftrustee.txtRegAddress.className = "successClass";
		}
				
		if((document.frmnewsmsftrustee.txtPriAddress.value == null) || (document.frmnewsmsftrustee.txtPriAddress.value == ""))
		{	
			document.frmnewsmsftrustee.txtPriAddress.className = "errclass";
			document.frmnewsmsftrustee.txtPriAddress.focus();
			flagReturn = false;
		}else{
			document.frmnewsmsftrustee.txtPriAddress.className = "successClass";
		}
		
		if(document.getElementById('trustyType').value == 3)
		{
			if(document.getElementById('lstQuestion').value == 0) {
				document.frmnewsmsftrustee.lstQuestion.className = "errclass";
				document.frmnewsmsftrustee.lstQuestion.focus();
				flagReturn = false;
			}
			else {
				document.frmnewsmsftrustee.lstQuestion.className = "successClass";
			}
		}
		
		return flagReturn;
	}
	
	function yes_no()
	{
		if(document.getElementById('lstQuestion').value == 'No')
		{
			flagSelect = confirm('All members of superfund are required to be directors of the company. A change of detail forms need to be lodged with ASIC to ensure this is the case. An additional fees of $50 plus GST applies. Our consultant will contact you to organize this on your behalf.');

			if(!flagSelect) {
				document.getElementById('lstQuestion').focus();
				return false;
			}
			else {
				return true;
			}
		}
	}
	