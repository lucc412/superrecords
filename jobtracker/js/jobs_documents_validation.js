function checkDocValidation()
{	
	flagReturn = true;

	var lstJob = document.getElementById('lstJob');
	var docTitle = document.getElementById('txtDocTitle');
	var fileDoc = document.getElementById('fileDoc');
	
	// do field validation  
	if (lstJob.value == 0)
	{
		lstJob.className = "errclass";
		flagReturn = false;
	}
	else {
		lstJob.className = "drop_down_select";
	}

	if (docTitle.value == "")
	{		
		docTitle.className = "errclass";
		flagReturn = false;
	}
	else {
		docTitle.className = "";
	}
	
	if (fileDoc.value == "")
	{		
		fileDoc.className = "errclass";
		flagReturn = false;
	}
	else {
		fileDoc.className = "";
	}
	
	if(flagReturn) {
		document.objForm.submit();
	}
	
	return flagReturn;
}