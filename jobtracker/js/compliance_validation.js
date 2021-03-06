// This function is used to perform validations
function checkValidation() {

	var flagReturn = true;
	var lstClientType = document.getElementById('lstClientType');
        var lstClientTypeSearch = document.getElementById('lstClientTypeSearch');
	var clientType = document.getElementById('lstCliType');
	var lstJobType = document.getElementById('lstJobType');
	var txtPeriod = document.getElementById('txtPeriod');

	if(lstClientType.value == 0) {
		lstClientTypeSearch.className = "errclass";
		flagReturn = false;
	}
	else {
		lstClientTypeSearch.className = "drop_down_select";
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
                                        var text = element.name;
                                        var eleId = text.replace("sourceDoc_","");
                                        if(document.getElementById('textSource_'+eleId).value == "") {
                                                document.getElementById('textSource_'+eleId).className = "errclass";
                                                flagReturn = false;
                                        }
                                }
                        }
                }

                if(!flagUpload) {
                        flagReturn = confirm('You have not uploaded any Source Documents. Are you sure you want to continue?');
                }
        }
	return flagReturn;
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
	eleName.setAttribute("id", 'textSource_' + (eleCount));
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
			var selectStr = "<select class=\'drop_down_select\' name=\'lst"+listName+"\' id=\'lst"+listName+"\' onchange='changeDuplicate()'><option value=\'0\'>Select Job Type</option>";
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

var duplicate = 0;
function checkDuplicateJob()
{
    $("#dialog-confirm").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        height:250,
        buttons: {
            "Continue": function() {
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
                window.location.assign('jobs_pending.php');
            }
        }    
    });

    ajaxUrl = '/jobtracker/compliance.php?a=duplicateJob&lstClientType='+$("#lstClientType").val()+'&lstJobType='+$("#lstJobType").val()+'&txtPeriod='+$("#txtPeriod").val();
    var response = $.ajax({
        type: "GET",
        url: ajaxUrl,
        async: false,
        data:{}
    }).responseText;

    if(response != '')
    {
        if(duplicate == 0)
        {
            duplicate++;
            $( "#dialog-confirm" ).dialog( "open" );
            return false;
        }

    }
    else
    {
        var flag = checkValidation();
        return flag;
    }  

}

function changeDuplicate()
{
    if(duplicate == 1)
    {
        duplicate=0;
    }
}
    