// show hide audit checklist options
$(function(){
   $("span").each(function (i){
	  (function(i) {
		  i++;
		  $('#checklist' + i).click(function() {
			  $('#subchecklist' + i).toggle(600);
		  });

	  }(i));
   });
});

function newPopup(url)
{
	popupWindow = window.open(
		url,'popUpWindow','height=400,width=1100,left=40,top=20,resizable=yes,scrollbars=no,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
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
	
	return flagReturn;
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