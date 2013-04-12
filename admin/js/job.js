//************************************************************************************************
//  Task          : Validation function to check for mandatory fields.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 15-Jan-2013
//  Last Modified : 15-Jan-2013 
//************************************************************************************************
function validateFormOnSubmit() { 
	flagReturn = true;

	// do field validation  
	if (document.objForm.lstClientType.value == "") {
		alert("Select Client type");
		document.objForm.lstClientType.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.objForm.lstPractice.value == "") {
		alert("Select Practice");
		document.objForm.lstPractice.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.objForm.lstClient.value == "") {
		alert("Select Client");
		document.objForm.lstClient.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.objForm.lstJob.value == "") {
		alert("Select Job");
		document.objForm.lstJob.focus();
		flagReturn = false;
	}

	// do field validation  
	else if (document.objForm.txtPeriod.value == "") {
		alert("Enter Period");
		document.objForm.txtPeriod.focus();
		flagReturn = false;
	}

	if(flagReturn)
	{
		document.objForm.submit();
	}
	
	return flagReturn;
}

// global count variable
var eleCount = 50;

// This function is used to Add new upload control
function addElement()
{
	eleCount++;
	var parentDiv = document.getElementById('parentDiv');

	// create a div dynamically
	var eleDiv = document.createElement("div");

	var eleUpload = document.createElement("input");
	eleUpload.setAttribute("name", 'sourceDoc_' + (eleCount));
	eleUpload.setAttribute("id", 'sourceDoc_' + (eleCount));
	eleUpload.setAttribute("type", "file");

	var eleName = document.createElement("input");
	eleName.setAttribute("name", 'textSource_' + (eleCount));
	eleName.setAttribute("type", "text");
	eleName.setAttribute("title", "Specify name of source document");

	eleDiv.appendChild(eleName);
	eleDiv.appendChild(eleUpload);

	parentDiv.appendChild(eleDiv);
}

//************************************************************************************************
//  Task          : This function is used to update a query response.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 03-Jan-2013
//  Last Modified : 03-Jan-2013 
//************************************************************************************************
function updateQuery(queryId)
{
	 var eleQueryId = document.getElementById('queryId');
	 eleQueryId.value = queryId;
	 document.frmQueriesList.submit();
}

//************************************************************************************************
//  Task          : This function is used to redirect to listing page of Queries.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 03-Jan-2013
//  Last Modified : 03-Jan-2013 
//************************************************************************************************
function ComfirmCancel(jobId)
{
   if(jobId)
		url = "job.php?a=queries&jobId="+jobId;
   else
   		url	= "job.php";
		
   var r = confirm("Are you sure you want to cancel?");
   if(r == true)
   {
	  window.location.href = url;
   }
   else
   {
	  return false;
   }
}

//************************************************************************************************
//  Task          : Popup window code.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 03-Jan-2013
//  Last Modified : 03-Jan-2013 
//************************************************************************************************
function newPopup(url)
{
	popupWindow = window.open(
		url,'popUpWindow','height=600,width=1050,left=40,top=20,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}

//************************************************************************************************
//  Task          : Validation function to check for mandatory fields in Upload Report page.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 07-Jan-2013
//  Last Modified : 07-Jan-2013 
//************************************************************************************************
function checkReportValidation()
{	
	if (document.objForm.fileReport.value == "")
	{
		alert("Select Report file");
		document.objForm.fileReport.focus();
	}
	else
	{
		document.objForm.submit();
	}
}

//************************************************************************************************
//  Task          : Calling Ajax file on selection of Practice and Client to display Client list
//					and	Job list respectively in drop down.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 15-Jan-2013
//  Last Modified : 15-Jan-2013 
//************************************************************************************************

function selectOptions(listName)
{
	if(listName == 'Client')
		var selObj = document.getElementById('lstPractice');
	
	
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
		var selectEmptyStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option>----------- Select Client -----------</option></select>";
		document.getElementById("span"+listName).innerHTML = selectEmptyStr;
	}
	else
	{
		var arrData = response.split("+");
		
		if(listName == 'Client')
		{
			var selectStr = "<select onChange=\'javascript:selectTeamMember();\' name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option>----------- Select Client -----------</option>";
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

function redirectURL(url)
{
	//alert("\""+url+"\"");
	//window.location.href = url;	
	//alert("After");
	window.open(url);
	
}