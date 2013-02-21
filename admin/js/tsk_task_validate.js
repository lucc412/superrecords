//************************************************************************************************
//  Task          : Validation function to check for mandatory fields.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 29-Dec-2012
//  Last Modified : 30-Jan-2012 
//************************************************************************************************
function validateFormOnSubmit() { 
	flagReturn = true;

	// do field validation
	if (document.managetask.txtTaskName.value == "") {
		alert("Enter Task name");
		document.managetask.txtTaskName.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstPractice.value == 0) {
		alert("Select Practice");
		document.managetask.lstPractice.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstClient.value == 0) {
		alert("Select Client");
		document.managetask.lstClient.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstJob.value == 0) {
		alert("Select Job");
		document.managetask.lstJob.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstMasterActivity.value == 0) {
		alert("Select Master activity");
		document.managetask.lstMasterActivity.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstSubActivity.value == 0) {
		alert("Select Sub activity");
		document.managetask.lstSubActivity.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstSrManager.value == 0) {
		alert("Select Sr Manager");
		document.managetask.lstSrManager.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.managetask.lstSrIndiaManager.value == 0) {
		alert("Select Sr India Manager");
		document.managetask.lstSrIndiaManager.focus();
		flagReturn = false;
	}
	
	// do field validation  
	else if (document.managetask.lstSrTeamMember.value == 0) {
		alert("Select Sr Team Member");
		document.managetask.lstSrTeamMember.focus();
		flagReturn = false;
	}
	
	// do field validation  
	else if (document.managetask.lstTaskStatus.value == 0) {
		alert("Select Task Status");
		document.managetask.lstTaskStatus.focus();
		flagReturn = false;
	}
	
	// do field validation  
	else if (document.managetask.lstPriority.value == 0) {
		alert("Select Priority");
		document.managetask.lstPriority.focus();
		flagReturn = false;
	}
	
	// do field validation  
	else if (document.managetask.lstProcessingCycle.value == 0) {
		alert("Select Processing Cycle");
		document.managetask.lstProcessingCycle.focus();
		flagReturn = false;
	}
	
	if(flagReturn) {
		document.managetask.submit();
	}
	
	return flagReturn;
}
//************************************************************************************************
//  Task          : Validation function to redirect to Listing page when Cancel button is pressed.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 29-Dec-2012
//  Last Modified : 05-Jan-2013 
//************************************************************************************************
function ComfirmCancel(jobId)
{
   var r = confirm("Are you sure you want to cancel?");
   if(r == true) {
	  window.location.href = "tsk_task.php?jobId="+jobId;
   }
   else {
	  return false;
   }
}

//************************************************************************************************
//  Task          : Calling Ajax file on selection of Practice and Client to display Client list
//					and	Job list respectively in drop down.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 29-Dec-2012
//  Last Modified : 26-Jan-2013 
//************************************************************************************************

function selectOptions(listName)
{
	if(listName == 'Client')
		var selObj = document.getElementById('lstPractice');
	
	if(listName == 'Job')
		var selObj = document.getElementById('lstClient');
		
	if(listName == 'SubActivity')
		var selObj = document.getElementById('lstMasterActivity');
		
	var item_id = selObj.value;


	if(item_id != '')
	{
		ajaxUrl = 'ajax_options.php?doAction='+listName+'&itemId='+item_id;
		var code = $('.lst'+listName).val();

	  	var response = $.ajax({
		   type: "GET",
		   url: ajaxUrl,
		   async: false,
		   data:{
			   code : code			   
		   }
		  }).responseText;
	}

	if(response == 0 )
	{
		var selectEmptyStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option>----------- Select "+listName+" -----------</option></select>";
			
		document.getElementById("span"+listName).innerHTML = selectEmptyStr;
	}
	else
	{
		var arrData = response.split("+");
		
		if(listName == 'Client')
		{
			var selectStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\' onchange=\'javascript:selectOptions(\"Job\");\'><option>----------- Select Client -----------</option>";
		}
		
		if(listName == 'Job')
		{
			var selectStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option>----------- Select Job -----------</option>";
		}
		
		if(listName == 'SubActivity')
		{
			var selectStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option>----------- Select Sub Activity -----------</option>";
		}
		
		for(var i=0; i<arrData.length; i++)
		{
			var itemInfo = arrData[i];
			var arrInfo = itemInfo.split("_");
			var code = arrInfo[0];
			var name = arrInfo[1];
			selectStr += '<option value=\'' + code + '\'>' + name + '</option>';
		}
		selectStr += '</select>';

		document.getElementById("span"+listName).innerHTML = selectStr;
	}
}