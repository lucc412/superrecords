// This function is used to redirect page
function urlRedirect(url)
{
	window.location.href = url;
}


// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var lstClientType = document.getElementById('lstClientType');
	var clientType = document.getElementById('lstCliType');
	var lstJobType = document.getElementById('lstJobType');
	var txtPeriod = document.getElementById('txtPeriod');

	if(lstClientType.value == 0) {
		lstClientType.className = "errclass";
		flagReturn = false;
	}
	else {
		lstClientType.className = "drop_down_select";
	}

	if(clientType.value == 0) {
		clientType.className = "errclass";
		flagReturn = false;
	}
	else {
		clientType.className = "drop_down_select";
	}
	
	if(lstJobType.value == 0) {
		lstJobType.className = "errclass";
		flagReturn = false;
	}
	else {
		lstJobType.className = "drop_down_select";
	}

	if(txtPeriod.value == "") {
		txtPeriod.className = "errclass";
		flagReturn = false;
	}
	else {
		txtPeriod.className = "";
	}

	// validation for source doc upload
	if(flagReturn) {
		flagUpload = false;
		var object = document.getElementById("objForm");
		
		for (var i=0; i<object.length; i++){
			var element = object.elements[i];
			var elementId = element.id;
			if(elementId.indexOf("sourceDoc_") != -1) {
				if(element.value != "") {
					flagUpload = true;
				}
			}
		}

		if(!flagUpload) {
			flagReturn = confirm('You have not uploaded any Source Documents. Are you sure you want to continue?');
		}
	}
	
	return flagReturn;
}

function checkDocValidation()
{	
	flagReturn = true;

	var lstJob = document.getElementById('lstJob');
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

// This function is used to perform validations
function unlinkFile() {

	response = confirm('Are you sure you want to delete this document ?');

	if(response) {
		return true;
	}
	else {
		return false;
	}
}

// global count variable
var eleCount = 50;

// This function is used to perform validations
function addElement() {
	eleCount++;
	var parentDiv = document.getElementById('parentDiv');

	// create a div dynamically
	var eleDiv = document.createElement("div");

	var eleUpload = document.createElement("input");
	eleUpload.setAttribute("name", 'sourceDoc_' + (eleCount));
	eleUpload.setAttribute("id", 'sourceDoc_' + (eleCount));
	eleUpload.setAttribute("type", "file");
	eleUpload.setAttribute("title", "Upload source document");

	var eleName = document.createElement("input");
	eleName.setAttribute("name", 'textSource_' + (eleCount));
	eleName.setAttribute("type", "text");
	eleName.setAttribute("title", "Specify name of source document");
	eleName.setAttribute("style", "margin-right:43px");

	eleDiv.appendChild(eleName);
	eleDiv.appendChild(eleUpload);

	parentDiv.appendChild(eleDiv);
}

function selectOptions(listName) {
	if(listName == 'JobType')
		var selObj = document.getElementById('lstCliType');
		
	var item_id = selObj.value;


	if(item_id != '')
	{
		ajaxUrl = '/jobtracker/ajax/jobs.php?doAction='+listName+'&itemId='+item_id;
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
		var selectEmptyStr = "<select class=\'drop_down_select\' name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option value=\'0\'>Select "+listName+"</option></select>";
		document.getElementById("span"+listName).innerHTML = selectEmptyStr;
	}
	else
	{
		var arrData = response.split("+");
		
		if(listName == 'JobType')
		{
			var selectStr = "<select class=\'drop_down_select\' name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option value=\'0\'>Select Job Type</option>";
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