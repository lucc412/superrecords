//************************************************************************************************
//  Task          : Validation function to check for mandatory fields.
//  Modified By   : Disha Goyal 
//  Created on    : 15-Jan-2013 
//  Last Modified : 19-Aug-2013
//************************************************************************************************

// show hide audit checklist options
$(function(){
    // file type validation
    $('INPUT[type="file"]').change(function () {
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val().split('/').pop().split('\\').pop();
            var ext = fileName.split('.').pop();
            ext = ext.toLowerCase();
            switch (ext) {
                    case 'txt':
                    case 'doc':
                    case 'docx':
                    case 'ppt':
                    case 'pptx':
                    case 'pdf':
                    case 'xls':
                    case 'xlsx':
                    case 'zip':
                    case 'rar':
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'msg':
                            break;
                    default:
                            alert('Sorry, This file type is not allowed.');
                            this.value = '';
            }
    });
    
   // checklist show/hide case in audit job
   $("span").each(function (i){
	  (function(i) {
		  i++;
		  $('#checklist' + i).click(function() {
			  $('#subchecklist' + i).toggle(600);
		  });

	  }(i));
   });
   
   // show fields when job status is set as completed 
   $('#lstJobStatus').change(function () {
        var status = this.value;
        if(status == '7') {
            $('#trDtCompleted').show(); 
            $('#trInvoiceNo').show();
        }
        else {
            $('#trDtCompleted').hide(); 
            $('#trInvoiceNo').hide();
        }
   });
   
   $("#objJobDetails").submit(function() {
        if($('#lstJobStatus').val() == '7') {
            if($("#dateCompleted").val() == '') {
                alert('Select Date Completed');
                $("#dateCompleted").focus();
                return false;
            }
            else if($("#invoiceNo").val() == '') {
                alert('Specify Invoice Number');
                $("#invoiceNo").focus();
                return false;
            }
        }
        return true;
       
   });
});

function validateFormOnSubmit() { 
	flagReturn = true;

	if (document.objForm.lstPractice.value == "") {
		alert("Select Practice");
		document.objForm.lstPractice.focus();
		flagReturn = false;
	}
	
	else if (document.objForm.lstClient.value == "") {
		alert("Select Client");
		document.objForm.lstClient.focus();
		flagReturn = false;
	}
	
	else if (document.objForm.lstClientType.value == "") {
		alert("Select Client type");
		document.objForm.lstClientType.focus();
		flagReturn = false;
	}

	else if (document.objForm.lstJob.value == "") {
		alert("Select Job Type");
		document.objForm.lstJob.focus();
		flagReturn = false;
	}

	else if (document.objForm.txtPeriod.value == "") {
		alert("Select Period");
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
//  Task          : This function is used to update a query post yes or no.
//  Modified By   : Siddhesh Champaneri 
//  Created on    : 11-Apr-2013
//  Last Modified : 11-Apr-2013 
//************************************************************************************************
function updateQueryPost(post,queryId)
{
	
	var eleQueryId = document.getElementById('queryId');
	eleQueryId.value = queryId;
	document.getElementById('qryPost').value = post;
	document.frmQueriesList.submit();
	
	//document.getElementById('flagPost').value = post;
	
	/*var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert('Successfull')
			document.getElementById("qrPost").innerHTML='UnPost';
		}
	}
	xmlhttp.open("POST","job.php?sql=updateQueryPost&flagPost="+post+"&queryId="+queryId,true);
	xmlhttp.send();*/
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
		url,'popUpWindow','height=350,width=800,left=40,top=20,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}

//************************************************************************************************
//  Task          : Validation function to check for mandatory fields in Upload Report page.
//  Modified By   : Disha Goyal 
//  Created on    : 07-Jan-2013
//  Last Modified : 20-Sept-2013
//************************************************************************************************
function checkReportValidation()
{	
	if (document.objForm.txtReportTitle.value == "")
	{
		alert("Specify Report title");
		document.objForm.txtReportTitle.focus();
	}
	else if (document.objForm.fileReport.value == "")
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
		var selectEmptyStr = "<select name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option value=\''\''>----------- Select Client -----------</option></select>";
		document.getElementById("span"+listName).innerHTML = selectEmptyStr;
	}
	else
	{
		var arrData = response.split("+");
		
		if(listName == 'Client')
		{
			var selectStr = "<select onChange=\'javascript:selectTeamMember();\' name=\'lst"+listName+"\' id=\'lst"+listName+"\'><option value=\''\''>----------- Select Client -----------</option>";
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
	window.open(url);	
}