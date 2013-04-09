/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is JS file for all reports page	
*/

// This function is used to move options from one listbox to other
function moveOption(src, dest) {
	for (var i = src.options.length - 1; i >= 0; i--) {
		if (src.options[i].selected) {
			var option = document.createElement("option");
			dest.options[dest.length] = option;
			option.text = src.options[i].text;
			option.value = src.options[i].value;
			dest.options[0].selected = true;
			src.remove(i);
		}
	}
}

// This function is used close share window popup
function closeWindow() {
	self.close();
}

// This function is used to make all options selected in listbox for Fields list & shared users list
function makeSelection() {
	var element = document.objForm.lstSelected;
	if(element.options.length == 0) {
		alert('Please select atleast one field to proceed.');
		return false;
	}
	
	for (var i = 0; i < element.options.length; i++) {
		element.options[i].selected = true;
	}

	return true;
}

// This function is used for Add all/ Remove all options in listbox
function makeAllSelection() {
	var chkAll = document.objForm.chkAll;
	
	if(chkAll.checked == true) {
		var src = document.objForm.lstSelection;
		var dest = document.objForm.lstSelected;
	}
	else {
		var src = document.objForm.lstSelected;
		var dest = document.objForm.lstSelection;
	}
	
	for (var i = src.options.length - 1; i >= 0; i--) {
		if(!src.options[i].disabled) {
			var option = document.createElement("option");
			dest.options[dest.length] = option;
			option.text = src.options[i].text;
			option.value = src.options[i].value;
			src.remove(i);
		}
	}
}

// This function is used for Move Up/ move down options in listbox
function swap(type){
	var sel = document.objForm.lstSelected;
	
	if(sel.options.length == 0) {
		alert('Please select atleast one field to proceed.');
		return false;
	}
	
	var opt = sel.options[sel.selectedIndex];
	
	if(type=='up'){
		var prev=opt.previousSibling;
		while(prev&&prev.nodeType!=1){
			prev=prev.previousSibling;
		}
		prev?sel.insertBefore(opt,prev):sel.appendChild(opt)
	}
	else{
		var next=opt.nextSibling;
		while(next&&next.nodeType!=1){
			next=next.nextSibling;
		}
		if(!next){
			sel.insertBefore(opt,sel.options[0]);
		}
		else{
			var nextnext=next.nextSibling;
			while(next&&next.nodeType!=1){
				next=next.nextSibling;
			}
			nextnext?sel.insertBefore(opt,nextnext):sel.appendChild(opt);
		}
	}
}

// This function is used to view selected report
function selectedReportDisplay(reportId) {
	window.location.href='lead_report.php?lstReport=' + reportId;
}

// This function is used to save report
function saveReport() {
	var report = document.getElementById("txtReportName");
	var reportName = report.value;
	if(reportName === '') {
		alert('Please enter report name');
		report.focus();
		return false;
	}
}

// This function is used to update saved report
function updateReport() {
	var eleLstReport = document.getElementById("lstReport");
	var reportId = eleLstReport.value;
	if(reportId == '0') {
		alert('Please choose a report');
		eleLstReport.focus();
		return false;
	}
}

// This function is used to print pdf/excel report
function printReport() {
	url = 'lead_report.php?print=yes';
	window.open(url, '_blank');
  	window.focus();
}

// This function is used to submit for condition fields by ajax
function showCondition(colName, key) {

	if (colName.length == 0) { 
	  	document.getElementById("condition" + key).innerHTML="";
	 	return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
	  	var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    	document.getElementById("condition" + key).innerHTML=xmlhttp.responseText;
	    }
	}

	if(colName.indexOf('MT_') != -1) {
		xmlhttp.open("GET","ajax_report.php?headerName="+colName+"&key="+key+"&doAction=showCondition",true);
	}
	else {
		xmlhttp.open("GET","ajax_report.php?colName="+colName+"&key="+key+"&doAction=showCondition",true);
	}

	xmlhttp.send();
}

// This function is used to submit for condition fields by ajax
function showInputType(colName, key) {

	if (colName.length == 0) { 
	  	document.getElementById("inputType" + key).innerHTML="";
	 	return;
	}
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
	  	var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    	document.getElementById("inputType" + key).innerHTML=xmlhttp.responseText;
	    }
	}
	if(colName.indexOf('MT_') != -1) {
		xmlhttp.open("GET","ajax_report.php?headerName="+colName+"&key="+key+"&doAction=showInputType",true);
	}
	else {
		xmlhttp.open("GET","ajax_report.php?colName="+colName+"&key="+key+"&doAction=showInputType",true);
	}
	xmlhttp.send();
}

// This function is used to create dynamic From & To date textbox
function addDateTextbox(optionVal, colName, key) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("inputType" + key).innerHTML=xmlhttp.responseText;
			}
		}

        if(optionVal == 'In Between') {
			if(colName.indexOf('MT_') != -1) {
				xmlhttp.open("GET","ajax_report.php?headerName="+colName+"&key="+key+"&doAction=showInputType&option=between",true);
			}
			else {
				xmlhttp.open("GET","ajax_report.php?colName="+colName+"&key="+key+"&doAction=showInputType&option=between",true);
			}
        }
		else {
			if(colName.indexOf('MT_') != -1) {
				xmlhttp.open("GET","ajax_report.php?headerName="+colName+"&key="+key+"&doAction=showInputType&option=",true);
			}
			else {
				xmlhttp.open("GET","ajax_report.php?colName="+colName+"&key="+key+"&doAction=showInputType&option=",true);
			}
		}
		xmlhttp.send();
}